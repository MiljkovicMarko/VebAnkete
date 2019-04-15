<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;

    class AdministratorModel extends Model {
        protected function getFields(): array {
            return [
                'administrator_id'  => new Field((new \App\Validators\NumberValidator())->setIntegerLength(11), false,'administratorski id'),
                'created_at'        => new Field((new \App\Validators\DateTimeValidator())->allowDate()->allowTime() , false, 'vreme stvaranja'),
                'admin_name'        => new Field((new \App\Validators\StringValidator(0, 64)) ,$alias='administratorsko ime'),
                'password_hash'     => new Field((new \App\Validators\StringValidator(0, 128)) ,$alias='heš lozinke'),
                'email'             => new Field((new \App\Validators\EmailValidator()),$alias ='email'),
                'forename'          => new Field((new \App\Validators\StringValidator(0, 64)) ,$alias='ime'),
                'surname'           => new Field((new \App\Validators\StringValidator(0, 64)) ,$alias='prezime'),
                'is_active'         => new Field((new \App\Validators\BitValidator()),$alias ='aktivan')
            ];
        }

        public function getActiveByAdminId(int $adminId, int $isActive=1) {
            return $this->getByFieldNames(['administrator_id', 'is_active'], [$adminId, $isActive]);
        }

        public function getActiveByAdminName(string $adminName, int $isActive=1) {
            return $this->getByFieldNames(['admin_name', 'is_active'], [$adminName, $isActive]);
        }
    }
