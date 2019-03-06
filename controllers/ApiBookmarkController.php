<?php
    namespace App\Controllers;

    class ApiBookmarkController extends \App\Core\ApiController {
        public function getBookmarks() {
            $bookmarks = $this->getSession()->get('bookmarks', []);
            $this->set('bookmarks', $bookmarks);
        }

        public function addBookmark($surveyId) {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $survey = $surveyModel->getById($surveyId);

            if (!$survey) {
                $this->set('error', -1);
                return;
            }

            $bookmarks = $this->getSession()->get('bookmarks', []);

            foreach ($bookmarks as $bookmark) {
                if ($bookmark->survey_id == $surveyId) {
                    $this->set('error', -2);
                    return;
                }
            }

            $bookmarks[] = $survey;
            $this->getSession()->put('bookmarks', $bookmarks);

            $this->set('error', 0);
        }

        public function clear() {
            $this->getSession()->put('bookmarks', []);

            $this->set('error', 0);
        }
    }
