<?php
    namespace App\Core\Role;

    class AdminRoleController extends \App\Core\Controller {
        public function __pre() {
            // var_dump($this->getSession()->get('administrator_id'));
            // die("redirected");
            if ($this->getSession()->get('administrator_id') === null) {
                $this->redirect(\Configuration::BASE . 'admin/login');
            }
        }
    }
