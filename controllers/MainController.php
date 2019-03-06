<?php
    namespace App\Controllers;

    class MainController extends \App\Core\Controller {
        public function home() {
            $surveyModel = new \App\Models\SurveyModel($this->getDatabaseConnection());
            $surveys = $surveyModel->getAllPublished();
            $this->set('surveys', $surveys);
        }

        public function getAbout()
        {

        }

        // USER
        public function getRegister() {
            
        }

        public function postRegister() {
            $email     = \filter_input(INPUT_POST, 'reg_email', FILTER_SANITIZE_EMAIL);
            $forename  = \filter_input(INPUT_POST, 'reg_forename', FILTER_SANITIZE_STRING);
            $surname   = \filter_input(INPUT_POST, 'reg_surname', FILTER_SANITIZE_STRING);
            $username  = \filter_input(INPUT_POST, 'reg_username', FILTER_SANITIZE_STRING);
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
            if ($user) {
                $this->setMessage(true,'Došlo je do greške!','Već postoji korisnik sa ovom adresom e-pošte.');
               
                return;
            }

            $user = $userModel->getByFieldName('username', $username);
            if ($user) {
                $this->setMessage(true,'Došlo je do greške!','Već postoji korisnik sa ovim korisničkim imenom.');
               
                return;
            }

            $passwordHash = \password_hash($password1, PASSWORD_DEFAULT);


            // try
            // {
                $userId = $userModel->add([
                    'username'      => $username,
                    'password_hash' => $passwordHash,
                    'email'         => $email,
                    'forename'      => $forename,
                    'surname'       => $surname
                ]);
            // }
            // catch(Exception $e) {
            //    $this->setMessage(true,'Došlo je do greške!','$e');
            // }
            

            if (!$userId) {
                $this->setMessage(true,'Došlo je do greške!','Došlo je do greške pri registraciji, probajte ponovo.');
                return;
            }
            $this->setMessage(false,'Čestitamo!','Napravili ste nalog. Sada možete da se prijavite.',\Configuration::BASE . 'user/login/', 'da se prijavite.');
        }

        public function getLogin() {

        }

        public function postLogin() {
            $username = \filter_input(INPUT_POST, 'login_username', FILTER_SANITIZE_STRING);
            $password = \filter_input(INPUT_POST, 'login_password', FILTER_SANITIZE_STRING);

            $validPassword = (new \App\Validators\StringValidator())
                ->setMinLength(7)
                ->setMaxLength(120)
                ->isValid($password);

            if ( !$validPassword) {
                $this->setMessage(true,'Došlo je do greške!','Lozinka nije ispravnog formata.');
                return;
            }

            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());

            if(!$userModel->isFieldValueValid('username',$username))
            {
                $this->setMessage(true,'Došlo je do greške!','Korisničko ime nije ispravnog formata.');
                return;
            }

            $user = $userModel->getByFieldName('username', $username);
            if (!$user) {
                $this->setMessage(true,'Došlo je do greške!','Ne postoji korisnik sa tim korisničkim imenom.');
                return;
            }

            if (!password_verify($password, $user->password_hash)) {
                sleep(1);
                $this->setMessage(true,'Došlo je do greške!','Lozinka nije ispravna.');
                return;
            }
            $this->getSession()->put('user_id', $user->user_id);
            $this->getSession()->save();

            $ipAddress = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
            $userAgent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

            $userLoginModel = new \App\Models\UserLoginModel($this->getDatabaseConnection());
            $userLoginModel->add([
                'user_id'       =>   $user->user_id,
                'ip_address'    =>   $ipAddress,
                'user_agent'    =>   $userAgent,
            ]);

            $this->redirect(\Configuration::BASE . 'user/surveys');
        }

        public function getLogout() {
            $this->getSession()->remove('user_id');
            $this->getSession()->save();

            $this->redirect(\Configuration::BASE);
        }

        // ADMIN

        public function getAdminLogin() {

        }

        public function postAdminLogin() {
            $adminName = \filter_input(INPUT_POST, 'admin_name', FILTER_SANITIZE_STRING);
            $adminPassword = \filter_input(INPUT_POST, 'admin_password', FILTER_SANITIZE_STRING);

            $validPassword = (new \App\Validators\StringValidator())
                ->setMinLength(7)
                ->setMaxLength(120)
                ->isValid($adminPassword);

            if ( !$validPassword) {
                $this->setMessage(true,'Došlo je do greške!','Lozinka nije ispravnog formata.');
                return;
            }

            $adminModel = new \App\Models\AdministratorModel($this->getDatabaseConnection());

            if(!$adminModel->isFieldValueValid('admin_name',$adminName))
            {
                $this->setMessage(true,'Došlo je do greške!','Administratorsko ime nije ispravnog formata.');
                return;
            }

            $admin = $adminModel->getActiveByAdminName($adminName);
            if (!$admin) {
                $this->setMessage(true,'Došlo je do greške!','Ne postoji administrator sa tim imenom.');
                return;
            }

            if (!password_verify($adminPassword, $admin->password_hash)) {
                sleep(1);
                $this->setMessage(true,'Došlo je do greške!','Lozinka nije ispravna.');
                return;
            }

            $this->getSession()->put('administrator_id', $admin->administrator_id);
            $this->getSession()->save();

            $ipAddress = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
            $userAgent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

            $adminLoginModel = new \App\Models\AdministratorLoginModel($this->getDatabaseConnection());
            $adminLoginModel->add([
                'administrator_id'  =>   $admin->administrator_id,
                'ip_address'        =>   $ipAddress,
                'user_agent'        =>   $userAgent,
            ]);

            $this->redirect(\Configuration::BASE . 'admin/surveys');
        }

        public function getAdminLogout() {
            $this->getSession()->remove('administrator_id');
            $this->getSession()->save();

            $this->redirect(\Configuration::BASE);
        }

    }
