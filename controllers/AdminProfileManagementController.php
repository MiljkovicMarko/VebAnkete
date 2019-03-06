<?php
    namespace App\Controllers;

    class AdminProfileManagementController extends \App\Core\Role\AdminRoleController {
       
        public function getProfile() {
            
        }

        public function postProfile() {
            $passwordOld  = \filter_input(INPUT_POST, 'reg_password_old', FILTER_SANITIZE_STRING);
            $password1 = \filter_input(INPUT_POST, 'reg_password_1', FILTER_SANITIZE_STRING);
            $password2 = \filter_input(INPUT_POST, 'reg_password_2', FILTER_SANITIZE_STRING);

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

            $adminModel = new \App\Models\AdministratorModel($this->getDatabaseConnection());
            $adminId = $this->getSession()->get('administrator_id');
            $admin = $adminModel->getActiveByAdminId($adminId);

            if (!password_verify($passwordOld, $admin->password_hash)) {
                sleep(1);
                $this->setMessage(true,'Došlo je do greške!','Stara lozinka nije ispravna.');
                return;
            }

            $passwordHash = \password_hash($password1, PASSWORD_DEFAULT);

            $success = $adminModel->editById($adminId,[
                'password_hash'=>$passwordHash
            ]);
            
            if(!$success)
            {
                $this->setMessage(1,'Greška!','Došlo je do greške pri promeni lozinke.');
            }

            $this->setMessage(false,'Čestitamo!','Uspešno ste promenili lozinku.');
        }
    }