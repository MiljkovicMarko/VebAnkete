<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;

    class UserModel extends Model {
        protected function getFields(): array {
            return [
                'user_id'         => new Field((new \App\Validators\NumberValidator())->setIntegerLength(11), false,'korisnički id'),
                'created_at'      => new Field((new \App\Validators\DateTimeValidator())->allowDate()->allowTime() , false, 'vreme stvaranja'),

                'username'        => new Field((new \App\Validators\StringValidator(0, 64)) ,$alias='korisničko ime'),
                'password_hash'   => new Field((new \App\Validators\StringValidator(0, 128)) ,$alias='heš lozinke'),
                'email'           => new Field((new \App\Validators\EmailValidator()),$alias='email'),
                'forename'        => new Field((new \App\Validators\StringValidator(0, 64)) ,$alias='ime'),
                'surname'         => new Field((new \App\Validators\StringValidator(0, 64)) ,$alias='prezime'),
                'is_active'       => new Field((new \App\Validators\BitValidator()),$alias='aktivan')
            ];
        }

        public function getByUsername(string $username) {
            return $this->getByFieldName('username', $username);
        }
        public function getActiveByUsername(string $username) {
            return $this->getByFieldName('username', $username);
        }
    }
