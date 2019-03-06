<?php
    namespace App\Core;

    final class Field {
        private $alias;//ime kojim oslovljavamo polje, za stampanje kod greske, npr 'Korisničko ime'
        private $validator;
        private $editable;

        public function __construct(Validator $validator, bool $editable = true, string $alias=' '){
            $this->validator = $validator;
            $this->editable  = $editable;
            $this->alias  = $alias;
        }

        public function isValid(string $value) {
            return $this->validator->isValid($value);
        }

        public function isEditable() {
            return $this->editable;
        }

        public function getAlias() {//ime kojim oslovljavamo polje, za stampanje kod greske, npr 'Korisničko ime'
            return $this->alias;
        }
    }
