<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;
    use App\Validators\BitValidator;

    class SurveyModel extends Model {
        protected function getFields(): array {
            return [
                'survey_id'     => new Field((new NumberValidator())->setIntegerLength(11), false),
                'user_id'       => new Field((new NumberValidator())->setIntegerLength(11)),
                'survey_link'   => new Field((new StringValidator())->setMaxLength(43), false),
                'created_at'    => new Field((new DateTimeValidator())->allowDate()->allowTime() , false),
                'title'         => new Field((new StringValidator())->setMaxLength(255) ),
                'description'   => new Field((new StringValidator())->setMaxLength(500) ),
                'is_active'     => new Field(new BitValidator()),
                'is_published'  => new Field(new BitValidator())
            ];
        }

        public function getAllActiveByUserId(int $userId, int $isActive=1): array {
            return $this->getAllByFieldNames(['user_id', 'is_active'], [$userId, $isActive]);
        }

        public function getAllActive(int $isActive=1): array {
            return $this->getAllByFieldName('is_active', $isActive);
        }

        public function getPublishedBySurveyLink(string $surveyLink, int $isActive=1, int $isPublished=1) {
            return $this->getByFieldNames(['survey_link', 'is_active','is_published'], [$surveyLink, $isActive,$isPublished]);
        }

        public function getAllPublished(int $isActive=1, int $isPublished=1) {
            return $this->getAllByFieldNames(['is_active','is_published'], [$isActive,$isPublished]);
        }

        public function getActiveBySurveyId(int $surveyId, int $isActive=1) {
            return $this->getByFieldNames(['survey_id', 'is_active'], [$surveyId, $isActive]);
        }

        public function getAllbyKeywords(string $keywords)
        {
            $sql = "SELECT * FROM survey WHERE is_active = 1 AND is_published = 1 AND (title LIKE ? OR description LIKE ?);";
            $keywords = '%'.$keywords.'%';
            $prep = $this->getConnection()->prepare($sql);
            if(!$prep)
            {
                return [];
            }
            $res = $prep->execute([$keywords,$keywords]);
            if(!$res)
            {
                return [];
            }
            $items = [];
            if ($res) {
                $items = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $items;
        }

    }
