<?php


$db['db_local_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_password'] = '';
$db['db_name'] = 'moble_form';


foreach($db as $key => $value){


    define(strtoupper($key), $value);


}

    $conn = mysqli_connect(DB_LOCAL_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if($conn->connect_errno){
        die('Query failed' .$conn->connect_error);

    }