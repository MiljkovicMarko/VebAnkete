<?php
    namespace App\Controllers;

    class AdminSurveyManagementController extends \App\Core\Role\AdminRoleController {
        public function getSurveys() {
            
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $surveys = $surveyModel->getAll();
            if (!count($surveys)) {
                $this->setMessage(2,'',"Nema anketa.");
                return;
            }
            $this->set('surveys', $surveys);
        }

        public function getEdit($surveyId) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getById($surveyId);

            if (!$survey) {
                $this->setMessage(true,'Došlo je do greške!','Anketa nije objavljena ili ne postoji!');
                return;
            }

            $this->set('survey', $survey);

            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $questionsInSurvey = $questionModel->getAllBySurveyId($surveyId);
            $this->set('questionsInSurvey', $questionsInSurvey);

            return $surveyModel;
        }

        public function postEdit($surveyId) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getById($surveyId);

            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $question_type = filter_input(INPUT_POST, 'question_type', FILTER_SANITIZE_STRING);
            if(!$question_type)
            {
                // $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
                // $survey = $surveyModel->getById($surveyId);
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
                // $survey = $surveyModel->getById($surveyId);
                
                $this->redirect(\Configuration::BASE . 'admin/surveys/edit/' . $surveyId);
                return;
            }
            if(!$questionModel->isFieldValueValid('answer_type',$question_type))
            {
                $this->setMessage(true,'Došlo je do greške!','Tip pitanja nije ispravnog formata.');
                return;
            }
            $questionsInSurvey = $questionModel->getOrderedBySurveyId($surveyId);
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
            $success=false;
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
                        'question_text'=> $texquestion_text,
                        'survey_id'=> $surveyId,
                        'nmbr_in_survey'=> $nmbrInSurvey,
                        'answer_type'=> $question_type,
                        'answer_choices' => $answerChoices
                    ]);
                    break;
            }
            if(!$success)
            {
                $this->setMessage(true,'Došlo je do greške!','Dodavanje pitanja nije uspelo.');
                return;
            }

            $this->redirect(\Configuration::BASE . 'admin/surveys/edit/' . $surveyId);
        }
    }
