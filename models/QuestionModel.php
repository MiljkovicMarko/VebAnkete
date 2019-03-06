<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;
    use App\Validators\BitValidator;

    class QuestionModel extends Model {
        protected function getFields(): array {
            return [
                'question_id'     => new Field((new NumberValidator())->setIntegerLength(11), false),
                'survey_id'       => new Field((new NumberValidator())->setIntegerLength(11)),
                'nmbr_in_survey'  => new Field((new NumberValidator())->setIntegerLength(11)),
                'answer_type'     => new Field((new StringValidator())->setMaxLength(255) ),
                'answer_choices'  => new Field((new StringValidator())->setMaxLength(64*1024) ),
                'answer_required' => new Field(new BitValidator()),
                'created_at'      => new Field((new DateTimeValidator())->allowDate()->allowTime() , false),
                'question_text'            => new Field((new StringValidator())->setMaxLength(64*1024) ),
                'is_active'       => new Field(new BitValidator())
                
            ];
        }

        public function getAllActiveBySurveyId(int $surveyId, int $isActive=1): array {
            return $this->getAllByFieldNames(['survey_id','is_active'], [$surveyId,$isActive]);
        }

        public function getOrderedActiveBySurveyId(int $surveyId, int $isActive=1):array{
            return $this->getOrderedByFieldNames(['survey_id','is_active'], [$surveyId,$isActive],['nmbr_in_survey'],[true]);
        }

        //za ADMINA
        public function getAllBySurveyId(int $surveyId): array {
            return $this->getAllByFieldName('survey_id', $surveyId);
        }

        public function getOrderedBySurveyId(int $surveyId):array{
            return $this->getOrderedByFieldNames(['survey_id'], [$surveyId],['nmbr_in_survey'],[true]);
        }
    }
