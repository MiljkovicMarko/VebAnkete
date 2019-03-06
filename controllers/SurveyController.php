<?php
    namespace App\Controllers;

    class SurveyController extends \App\Core\Controller {

        public function getShow($link) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getPublishedBySurveyLink($link);

            if (!$survey) {
                $this->setMessage(true,'Došlo je do greške!','Anketa nije objavljena ili ne postoji!');
                return;
            }

           $surveyId = $survey->survey_id;

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

        public function postShow($link) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getPublishedBySurveyLink($link);

            if (!$survey) {
                $this->setMessage(true,'Došlo je do greške!','Anketa nije objavljena ili ne postoji!');
                return;
            }

            $surveyId = $survey->survey_id;
            $questionModel = new \App\Models\QuestionModel($this->getDatabaseConnection());
            $questionsInSurvey = $questionModel->getOrderedActiveBySurveyId($surveyId);

            if(!count($questionsInSurvey))
            {
                $this->setMessage(true,'Nema pitanja.','Za sada nema pitanja u ovoj anketi.');
                return;
            }  


            $answerModel = new \App\Models\AnswerModel($this->getDatabaseConnection());
            $answers=[];
            for ($i = 0; $i < count($questionsInSurvey); $i++) {
                $questionId=$questionsInSurvey[$i]->question_id;
                $questionNmbr=$questionsInSurvey[$i]->nmbr_in_survey;
                $answer_text = filter_input(INPUT_POST, $questionId.','.$questionNmbr, FILTER_SANITIZE_STRING);
                if($answer_text==null)
                {
                    $this->setMessage(true,'Došlo je do greške!','Niste odgovorili na '.($questionNmbr+1).'. pitanje!');
                    return;
                }
                if(!$answerModel->isFieldValueValid('answer_text',$answer_text))
                {
                    $this->setMessage(true,'Došlo je do greške!','Unešen odgovor nije ispravnog formata.');
                    return;
                }

                array_push($answers,['question_id'=>$questionId,
                'answer_text'=>$answer_text]);
            }
            foreach ($answers as $answer)
            {
                $success=$answerModel->add([
                    'question_id'=> $answer['question_id'],
                    'answer_text'=>$answer['answer_text']
                ]);
                if(!$success)
                {
                    $this->setMessage(true,'Došlo je do greške!','Odgovor nije uspesno dodat!');
                    return;
                }
            }

            $this->setMessage(false,'Čestitamo!',"Uspešno ste popunili anketu! Hvala!");
        }

        public function surveys() {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $surveys = $surveyModel->getAllActive();
            $this->set('surveys', $surveys);
        }

        private function normalizeKeywords(string $keywords):string
        {
            $keywords=trim($keywords);
            $keywords=preg_replace('/ +/',' ',$keywords);
            return $keywords;
        }

        public function postSearch()
        {
            $surveyModel= new \App\Models\SurveyModel($this->getDatabaseConnection());
            $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);
            $validSearch = (new \App\Validators\StringValidator())->setMinLength(1)->setMaxLength(1000)->isValid($search);
            if(!$validSearch)
            {
                $this->setMessage(true,'Došlo je do greške!','Tekst za pretragu nije ispravnog formata! Morate uneti bar 1 karakter i manje od 1000.');
                return;
            }
            $keywords = $this->normalizeKeywords($search);
            $surveys = $surveyModel->getAllbyKeywords($keywords);
            $this->set('surveys', $surveys);
        }
    }