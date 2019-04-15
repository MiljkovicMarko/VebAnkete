<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;
    use App\Validators\BitValidator;

    class AnswerModel extends Model {
        protected function getFields(): array {
            return [
                'answer_id'     => new Field((new NumberValidator())->setIntegerLength(11), false),
                'question_id'   => new Field((new NumberValidator())->setIntegerLength(11)),
                'created_at'    => new Field((new DateTimeValidator())->allowDate()->allowTime() , false),
                'answer_text'   => new Field((new StringValidator())->setMinLength(1)->setMaxLength(10240) ),
                'is_active'     => new Field(new BitValidator())
                
            ];
        }

        public function getAllBySurveyId(int $surveyId): array {//ne koristi se
            try{
            $customSql='SELECT * FROM answer
            INNER JOIN question
            ON question.question_id = answer.question_id WHERE  question.survey_id = ?;';
            $values = array($surveyId);
            $res = $this->executeCustomSQL($customSql, $values);
            }
            catch(Exception $e)
            {
                die($e);
            }
            return $res;
        }

        public function getAllActiveBySurveyId(int $surveyId, int $isActive=1): array {//ne koristi se
            try{
                $customSql='SELECT * FROM answer
                INNER JOIN question
                ON question.question_id = answer.question_id WHERE  question.survey_id = ? AND answer.is_active = ? AND question.is_active = ?;';
                $values = array($surveyId, $isActive, $isActive);
                $res = $this->executeCustomSQL($customSql, $values);
                }
                catch(Exception $e)
                {
                    die($e);
                }
                return $res;
        }

        public function getAllByQuestionId(int $questionId): array {
            return $this->getAllByFieldName('question_id', $questionId);
        }

        public function getAllActiveByQuestionId(int $questionId, int $isActive=1): array {
            return $this->getAllByFieldNames(['question_id', 'is_active'], [$questionId, $isActive]);
        }
    }
