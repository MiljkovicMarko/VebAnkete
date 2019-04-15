<?php
    namespace App\Core\Role;

    class AdminRoleController extends \App\Core\Controller {
        public function __pre() {
            if ($this->getSession()->get('administrator_id') === null) {
                $this->redirect(\Configuration::BASE . 'admin/login');
            }
        }
    }
