<?php 
    class Authorization extends controller {
        public $AccountModels;
        function __construct() {
            $this->AccountModels = $this->model('AccountModels');
        }

        function checkAuthUser($array) {
            $username = $array['username'];
            $checkUS = $this->AccountModels->select_row('*', ['username' => $username]);
            if ($checkUS != null && count($checkUS) > 0) {
                if (($checkUS['role'] == 0) && ($checkUS['publish'] == 1)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        function checkAuthAdmin($array) {
            $username = $array['username'];
            $checkUS = $this->AccountModels->select_row('*', ['username' => $username]);
            if ($checkUS != null && count($checkUS) > 0) {
                if (($checkUS['role'] == 1) && ($checkUS['publish'] == 1)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
?>