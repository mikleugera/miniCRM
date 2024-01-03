<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function tt($str) {
        echo '<pre>';
            print_r($str);
        echo '</pre>';    
    }

    function tte($str) {
        echo '<pre>';
            print_r($str);
        echo '</pre>';    
        exit();
    }

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'mysql');
    define('DB_NAME', 'crm_for_telegram');

    define('ENABLE_PERMISSION_CHECK', true);
