<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;

    class AdministratorLoginModel extends Model {
        protected function getFields(): array {
            return [
                'admministrator_login_id'   => new Field((new \App\Validators\NumberValidator())->setIntegerLength(11), false),
                'login_at'                  => new Field((new \App\Validators\DateTimeValidator())->allowDate()->allowTime() , false),
                'administrator_id'          => new Field((new \App\Validators\NumberValidator())->setIntegerLength(11)),
                'ip_address'                => new Field((new \App\Validators\StringValidator(7, 255)) ),
                'user_agent'                => new Field((new \App\Validators\StringValidator(0, 255)) )
            ];
        }

        public function getAllByAdministratorId(int $administratorId): array {
            return $this->getAllByFieldName('admministrator_id', $administratorId);
        }

        public function getAllByIpAddress(string $ipAddress): array {
            return $this->getAllByFieldName('ip_address', $ipAddress);
        }
    }