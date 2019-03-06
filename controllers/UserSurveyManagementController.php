<?php
    namespace App\Controllers;

    class UserSurveyManagementController extends \App\Core\Role\UserRoleController {
        public function surveys() {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $userId = $this->getSession()->get('user_id');
            $surveys = $surveyModel->getAllActiveByUserId($userId);
            if (!count($surveys)) {
                $this->setMessage(2,'','Nema anketa.',\Configuration::BASE . 'user/surveys/edit/','da dodate novu anketu.');
                return;
            }
            $this->set('surveys', $surveys);
        }

        public function show($surveyId) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getActiveBySurveyId($surveyId);

            if (!$survey) {
                $this->setMessage(true,'Došlo je do greške!','Anketa ne postoji!');
                return;
            }

            $this->set('survey', $survey);

            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $questionsInSurvey = $questionModel->getOrderedActiveBySurveyId($surveyId);
            if(!count($questionsInSurvey))
            {
                $this->setMessage(true,'Nema pitanja.','Za sada nema pitanja u ovoj anketi.');
                return;
            }
            $this->set('questionsInSurvey', $questionsInSurvey);
        }

        public function getAnswers($surveyId){
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getActiveBySurveyId($surveyId);

            if (!$survey) {
                $this->setMessage(true,'Došlo je do greške!','Anketa ne postoji!');
                return;
            }

            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $questions = $questionModel->getOrderedActiveBySurveyId($surveyId);
            if(!count($questions))
            {
                $this->setMessage(true,'Nema pitanja.','Za sada nema pitanja u ovoj anketi.');
                return;
            }
            

            $answerModel = new \App\Models\AnswerModel($this->getDatabaseConnection());

            $answers= [];
            foreach($questions as $question)
            {
                $ansrow=[];
                foreach($answerModel->getAllActiveByQuestionId($question->question_id) as $ans)
                {
                    array_push($ansrow,$ans->answer_text);
                }
                array_push($answers,$ansrow); 
            }
            if(!count($answers))
            {
                $this->setMessage(true,'Nema odgovora.','Niko nije odgovorio na ovu anketu.');
                return;
            }
            $out = array();
            foreach ($answers as $key => $subarr) {
                foreach ($subarr as $subkey => $subvalue) {
                    $out[$subkey][$key] = $subvalue;
                }
            }
            $answers= $out;

            for($i=0;$i<count($questions);$i++)
            {
                $questions[$i]=$questions[$i]->question_text;
            }
            
            $this->set('survey', $survey);
            $this->set('questions', $questions);
            $this->set('answers', $answers);
        }

        public function postAnswers($surveyId)
        {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getActiveBySurveyId($surveyId);

            if (!$survey) {
                $this->setMessage(true,'Došlo je do greške!','Anketa ne postoji!');
                return;
            }

            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $questions = $questionModel->getOrderedActiveBySurveyId($surveyId);
            if(!count($questions))
            {
                $this->setMessage(true,'Nema pitanja.','Za sada nema pitanja u ovoj anketi.');
                return;
            }
            

            $answerModel = new \App\Models\AnswerModel($this->getDatabaseConnection());
            $answers= [];
            foreach($questions as $question)
            {
                array_push($answers,$answerModel->getAllActiveByQuestionId($question->question_id)); 
            }
            if(!count($answers))
            {
                $this->setMessage(true,'Nema odgovora.','Niko nije odgovorio na ovu anketu.');
                return;
            }

            $out = array();
            foreach ($answers as $key => $subarr) {
                foreach ($subarr as $subkey => $subvalue) {
                    $out[$subkey][$key] = $subvalue;
                }
            }
            $answers= $out;

            $this->set('survey', $survey);
            $this->set('questions', $questions);
            $this->set('answers', $answers);

        }

        public function getEdit($surveyId=null) {
            if($surveyId === null)
            {
                return;
            }

            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());

            $survey = $surveyModel->getActiveBySurveyId($surveyId);

            if (!$survey) {
                $this->setMessage(true,'Došlo je do greške!','Anketa nije objavljena ili ne postoji!');
                return;
            }

            $this->set('survey', $survey);

            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $questionsInSurvey = $questionModel->getOrderedActiveBySurveyId($surveyId);
            $this->set('questionsInSurvey', $questionsInSurvey);
        }

        public function postEdit($surveyId=null) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            if($surveyId === null)
            {
                $surveyId = $surveyModel->add([
                    'user_id' => $userId = $this->getSession()->get('user_id')
                ]);
                if(!$surveyId)
                {
                    $this->setMessage(true,'Došlo je do greške!','Anketa nije objavljena ili ne postoji!');
                    return;
                }
            }
            $survey = $surveyModel->getById($surveyId);
            if($survey->is_published==1)
            {
                $this->postPublishedEdit($surveyId);
            }
            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $question_type = filter_input(INPUT_POST, 'question_type', FILTER_SANITIZE_STRING);
            if(!$question_type)
            {
                if(!$survey)
                {
                    $this->setMessage(true,'Došlo je do greške!','Ankete nije pronađenja.');
                    return;
                }

                $name = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                $active = filter_input(INPUT_POST, 'is_active', FILTER_SANITIZE_NUMBER_INT)===null?1:0;
                $published = +!!filter_input(INPUT_POST, 'is_published', FILTER_SANITIZE_NUMBER_INT);
            
                if(!$surveyModel->isFieldValueValid('title',$name))
                {
                    $this->setMessage(true,'Došlo je do greške!','Naslov ankete nije ispravnog formata.');
                    return;
                }
                if(!$surveyModel->isFieldValueValid('description',$description))
                {
                    $this->setMessage(true,'Došlo je do greške!','Opis ankete nije ispravnog formata. Dozvoljeno je najviše 500 karaktera.');
                    return;
                }
                if(!$surveyModel->isFieldValueValid('is_active',$active))
                {
                    $this->setMessage(true,'Došlo je do greške!','Podešavanje aktivnosti ankete nije ispravnog formata.');
                    return;
                }
                if(!$surveyModel->isFieldValueValid('is_published',$published))
                {
                    $this->setMessage(true,'Došlo je do greške!','Podešavanje objavljanja ankete nije ispravnog formata.');
                    return;
                }
                $questionsInSurvey = $questionModel->getAllActiveBySurveyId($surveyId);
                if($published===1 && count($questionsInSurvey)<1)
                {
                    $this->setMessage(true,'Anketa nema pitanja.','Anketa mora imati bar jedno pitanje pre objave.');
                    return;
                }
                $success=$surveyModel->editById($surveyId, [
                    'title'         => $name,
                    'description'   => $description,
                    'is_active'     => $active,
                    'is_published'  => $published
                ]);
                if(!$success)
                {
                    $this->setMessage(true,'Došlo je do greške!','Greska pri editu!');
                    return;
                }
                $survey = $surveyModel->getById($surveyId);
                
                $this->redirect(\Configuration::BASE . 'user/surveys/edit/'.$surveyId);
                return;
            }
            if(!$questionModel->isFieldValueValid('answer_type',$question_type))
            {
                $this->setMessage(true,'Došlo je do greške!','Tip pitanja nije ispravnog formata.');
                return;
            }
            $questionsInSurvey = $questionModel->getOrderedActiveBySurveyId($surveyId);
            $nmbrInSurvey=1;
            if(count($questionsInSurvey)>0)
            {
                $nmbrInSurvey= end($questionsInSurvey)->nmbr_in_survey+1;
            }
            $question_text = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);
            if(!$questionModel->isFieldValueValid('question_text',$question_text))
            {
                $this->setMessage(true,'Došlo je do greške!','Tekst pitanja nije ispravnog formata.');
                return;
            }
            switch($question_type) {
                case 'short':
                    $success=$questionModel->add([
                        'question_text'=>$question_text,
                        'survey_id'=> $surveyId,
                        'nmbr_in_survey'=>$nmbrInSurvey,
                        'answer_type'=>$question_type
                    ]);
                    break;
                case 'long':
                    $success=$questionModel->add([
                        'question_text'=>$question_text,
                        'survey_id'=> $surveyId,
                        'nmbr_in_survey'=>$nmbrInSurvey,
                        'answer_type'=>$question_type
                    ]);
                    break;
                case 'y/n':
                    $success=$questionModel->add([
                        'question_text'=>$question_text,
                        'survey_id'=> $surveyId,
                        'nmbr_in_survey'=>$nmbrInSurvey,
                        'answer_type'=>$question_type
                    ]);
                    break;
            
                case 'qualitative':
                    $success=$questionModel->add([
                        'question_text'=>$question_text,
                        'survey_id'=> $surveyId,
                        'nmbr_in_survey'=>$nmbrInSurvey,
                        'answer_type'=>$question_type
                    ]);
                    break;
                case 'quantitative':
                    $success=$questionModel->add([
                        'question_text'=>$question_text,
                        'survey_id'=> $surveyId,
                        'nmbr_in_survey'=>$nmbrInSurvey,
                        'answer_type'=>$question_type
                    ]);
                    break;
                case 'choice':
                    $answerChoices=filter_input(INPUT_POST, 'choices', FILTER_SANITIZE_STRING);
                    if(!$questionModel->isFieldValueValid('answer_choices',$answerChoices))
                    {
                        $this->setMessage(true,'Došlo je do greške!','Izbor odgovora nije ispravnog formata.');
                        return;
                    }
                    $success=$questionModel->add([
                        'question_text'=> $question_text,
                        'survey_id'=> $surveyId,
                        'nmbr_in_survey'=> $nmbrInSurvey,
                        'answer_type'=> $question_type,
                        'answer_choices' => $answerChoices
                    ]);
                    break;
            }
            $this->redirect(\Configuration::BASE . 'user/surveys/edit/'.$surveyId);
        }

        private function postPublishedEdit($surveyId) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getById($surveyId);
            if(!$survey)
            {
                $this->setMessage(true,'Došlo je do greške!','Ankete nije pronađenja.');
                return;
            }

            $name = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $active = filter_input(INPUT_POST, 'is_active', FILTER_SANITIZE_NUMBER_INT)===null?1:0;
        
            if(!$surveyModel->isFieldValueValid('title',$name))
            {
                $this->setMessage(true,'Došlo je do greške!','Naslov ankete nije ispravnog formata.');
                return;
            }
            if(!$surveyModel->isFieldValueValid('description',$description))
            {
                $this->setMessage(true,'Došlo je do greške!','Opis ankete nije ispravnog formata. Dozvoljeno je najviše 500 karaktera.');
                return;
            }
            if(!$surveyModel->isFieldValueValid('is_active',$active))
            {
                $this->setMessage(true,'Došlo je do greške!','Podešavanje aktivnosti ankete nije ispravnog formata.');
                return;
            }
            $success=$surveyModel->editById($surveyId, [
                'title'         => $name,
                'description'   => $description,
                'is_active'     => $active,
            ]);
            if(!$success)
            {
                $this->setMessage(true,'Došlo je do greške!','Greska pri editu!');
                return;
            }
            $survey = $surveyModel->getById($surveyId);
            
            $this->redirect(\Configuration::BASE . 'user/surveys/edit/'.$surveyId);
            return;
        }
    }
