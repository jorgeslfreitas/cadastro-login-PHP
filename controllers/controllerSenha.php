<?php

$validate =new \Classes\ClassValidate();

$validate->validateFields($_POST);
$validate->validateEmail($email);
$validate->validateIssetEmail($email, "senha");
$validate->validateData($dataNascimento);
$validate->validateDataNascimento($dataNascimento, $email);
$validate->validateCaptcha($gRecaptchaResponse);
echo $validate->validateFinalSen($arrVar);


