<?php

$post = Form::Post(
    [
        'email', function($email){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                return strlen($email) < 255 ? $email : false;
            } else {
                return false;
            }
        }
    ],
    [
        'password', function($password){
            if(preg_match('@^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!\@$%^&(){}[]:;<>,.?/~_+-=|\]).{8,32}$@g', $password, $result)){
                return $password;
            } else {
                return false;
            }
        }
    ]
);

?>
