<?php
    namespace App\Core\Role;

    class UserRoleController extends \App\Core\Controller {
        public function __pre() {
            // var_dump($this->getSession());
            //     die();
            if ($this->getSession()->get('user_id') === null) {
                
                $this->redirect(\Configuration::BASE . 'user/login');
            }
        }
    }
