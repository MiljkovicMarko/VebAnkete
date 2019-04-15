<?php
    namespace App\Controllers;

    class AdminUserManagementController extends \App\Core\Role\AdminRoleController {
        public function getUsers() {
            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $users = $userModel->getAll();
            if (!count($users)) {
                $this->setMessage(2,'',"Nema korisnika.");
                return;
            }
            $this->set('users', $users);
        }

        public function getEdit($userId) {
            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $user = $userModel->getById($userId);

            if (!$user) {
                $this->setMessage(true,'Došlo je do greške!','Korisnik ne postoji!');
                return;
            }

            $this->set('user', $user);
        }

        public function postEdit($userId) {

            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $user = $userModel->getById($userId);

            if(!$user)
            {
                $this->setMessage(true,'Došlo je do greške!','Korisnik nije pronađen.');
                return;
            }

            $email      = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $forename   = filter_input(INPUT_POST, 'forename', FILTER_SANITIZE_STRING);
            $surname    = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
            $username   = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password1  = filter_input(INPUT_POST, 'password_1', FILTER_SANITIZE_STRING);
            $password2  = filter_input(INPUT_POST, 'password_2', FILTER_SANITIZE_STRING);
            $isActive   = +!!filter_input(INPUT_POST, 'is_active', FILTER_SANITIZE_NUMBER_INT);

            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());

            if(!$userModel->isFieldValueValid('email',$email))
            {
                $this->setMessage(true,'Došlo je do greške!','Adresa e-pošte nije ispravnog formata.');
                return;
            }


            if(!$userModel->isFieldValueValid('username',$username))
            {
                $this->setMessage(true,'Došlo je do greške!','Korisničko ime nije ispravnog formata.');
                return;
            }

            if(!$userModel->isFieldValueValid('forename',$forename))
            {
                $this->setMessage(true,'Došlo je do greške!','Unešeno ime nije ispravnog formata.');
                return;
            }

            if(!$userModel->isFieldValueValid('surname',$surname))
            {
                $this->setMessage(true,'Došlo je do greške!','Unešeno prezime nije ispravnog formata.');
                return;
            }

            $user = $userModel->getByFieldName('email', $email);
            if ($user && $user->user_id != $userId) {
                $this->setMessage(true,'Došlo je do greške!','Već postoji korisnik sa ovom adresom e-pošte.');
                return;
            }

            $user = $userModel->getByFieldName('username', $username);
            if ($user && $user->user_id != $userId) {
                $this->setMessage(true,'Došlo je do greške!','Već postoji korisnik sa ovim korisničkim imenom.');
                return;
            }

            if(!$password1 && !$password2)
            {
                $success = $userModel->editById($userId, [
                    'username'      => $username,
                    'email'         => $email,
                    'forename'      => $forename,
                    'surname'       => $surname,
                    'is_active'     => $isActive
                ]);
                
                if (!$success) {
                    $this->setMessage(true,'Došlo je do greške!','Došlo je do greške pri izmeni podataka.');
                    return;
                }
                $this->setMessage(false,'Čestitamo!','Nalog je usepešno izmenjen.');
                return;    
            }

            if ($password1 !== $password2) {
                $this->setMessage(true,'Došlo je do greške!','Niste uneli dva puta istu lozinku!');
                return;
            }

            $validPassword = (new \App\Validators\StringValidator())
                ->setMinLength(8)
                ->setMaxLength(120)
                ->isValid($password1);

            if ( !$validPassword) {
                $this->setMessage(true,'Došlo je do greške!','Lozinka nije ispravnog formata. Mora da ima bar 8 karaktera!');
                return;
            }

            $passwordHash = \password_hash($password1, PASSWORD_DEFAULT);

                $success = $userModel->editById($userId, [
                    'username'      => $username,
                    'password_hash' => $passwordHash,
                    'email'         => $email,
                    'forename'      => $forename,
                    'surname'       => $surname,
                    'is_active'     => $isActive
                ]);
            
            if (!$success) {
                $this->setMessage(true,'Došlo je do greške!','Došlo je do greške pri izmeni podataka.');
                return;
            }
            $this->setMessage(false,'Čestitamo!','Nalog je usepešno izmenjen.');
        }
    }
