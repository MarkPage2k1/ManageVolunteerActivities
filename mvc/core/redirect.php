<?php
    require_once "const.php";
    class redirect {
        function __construct($index = '') {
            if ($index != '') {
                header("Location: ".base_url.$index."");
            }         
        }

        function setFlash($type, $text = '') {
            if (isset($_SESSION[$type])) {
                $message = $_SESSION[$type];
                unset($_SESSION[$type]);
                return $message;
            } else {
                $_SESSION[$type] = $text;
            }
            return '';
        }
    }
?>