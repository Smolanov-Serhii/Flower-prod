<?php
if (!class_exists('Validator')) {
    class Validator
    {
        private static $errors = [];

        public static function validate($data, $rules)
        {
            foreach ($rules as $field => $rule) {
                $funcs = explode('|', $rule);
                foreach ($funcs as $func) {
                    [$method, $param] = explode(':', $func);

                    if (method_exists(__CLASS__, $method)) {
                        call_user_func([__CLASS__, $method], $field, $data[$field], $param);
                    }
                }
            }

            return self::$errors;
        }

        protected function required($key, $val)
        {
            if (empty($val)) {
                array_push(self::$errors, "Необходимо заполнить «{$key}».");
            }
        }

        protected function min($key, $val, $min)
        {
            if (!empty($val) && strlen($val) < $min) {
                array_push(self::$errors, "Значение «{$key}» не может быть меньше {$min} символов.");
            }
        }

        protected function max($key, $val, $max)
        {
            if (!empty($val) && strlen($val) > $max) {
                array_push(self::$errors, "Значение «{$key}» не может быть больше {$max} символов.");
            }
        }

        protected function full_name($key, $val)
        {
            $val = trim($val);
            $splitName = explode(' ', $val);
            if (count($splitName) < 2) {
                array_push(self::$errors, "Неверное ФИО.");
            }
        }

        protected function login($key, $val)
        {
            $val = trim($val);
            $user = get_user_by('login', $val);
            if (!empty($user)) {
                array_push(self::$errors, "Логин {$val} используеться.");
            }
        }

        protected function exist($key, $val)
        {
            $user = get_user_by('email', $val);
            if (empty($user)) {
                array_push(self::$errors, "Пользователь с таким Email не найден.");
            }
        }

        protected function email($key, $val)
        {
            if (!empty($val) && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
                array_push(self::$errors, "Значение «Email» не является правильным email адресом.");
            }
        }

        protected function unique($key, $val)
        {
            $user = get_user_by('email', $val);
            if (!empty($user)) {
                array_push(self::$errors, "Такой Email уже используеться.");
            }
        }

        protected function tel($key, $val)
        {
            $val = trim($val);
            if (!empty($val) && !preg_match("/^((\+?38\s?)?\(?\d{3}\)?[\s\.-]?(\d{7}|\d{3}[\s\.-]\d{2}[\s\.-]\d{2}|\d{3}-\d{4}))$/", $val)) {
                array_push(self::$errors, "Значение «Телефон» не является правильным.");
            }
        }
    }
}
