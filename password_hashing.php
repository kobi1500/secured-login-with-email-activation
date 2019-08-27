<?php

$pass = "secret";

$hash = password_hash($pass,PASSWORD_BCRYPT,['cost=>10']);

echo $hash;

if(password_verify('secret',$hash)){
    echo "Password matched";
}else{
    echo "Password doesn't matched";
}