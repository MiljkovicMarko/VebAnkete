<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;

    class UserLoginModel extends Model {
        protected function getFields(): array {
            return [
                'user_login_id' => new Field((new \App\Validators\NumberValidator())->setIntegerLength(11), false),
                'login_at'      => new Field((new \App\Validators\DateTimeValidator())->allowDate()->allowTime() , false),
                'user_id'      => new Field((new \App\Validators\NumberValidator())->setIntegerLength(11)),
                'ip_address'      => new Field((new \App\Validators\StringValidator(7, 255)) ),
                'user_agent'      => new Field((new \App\Validators\StringValidator(0, 255)) )
            ];
        }

        public function getAllByUserId(int $userId): array {
            return $this->getAllByFieldName('user_id', $userId);
        }

        public function getAllByIpAddress(string $ipAddress): array {
            return $this->getAllByFieldName('ip_address', $ipAddress);
        }
    }