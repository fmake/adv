<?php

/**
*	перейти залогиненым по этому адресу
*	https://oauth.yandex.ru/authorize?response_type=code&client_id=055c71b71f604603a2f633093a1980dd
*	после программа выдаст токен, его надо скопировать в настройки системы
*/
require('./fmake/FController.php');
printAr($_REQUEST);
$curl = new cURL();
$curl->init();
echo $request -> code;
$curl -> post("https://oauth.yandex.ru/token","grant_type=authorization_code&code={$request -> code}&client_id=055c71b71f604603a2f633093a1980dd&client_secret=850a7628167f4fed8652e4cbb125a3d9");
printAr( $curl -> data );

