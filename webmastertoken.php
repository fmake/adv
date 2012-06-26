<?php

/**
*	перейти залогиненым по этому адресу
*	https://oauth.yandex.ru/authorize?response_type=code&client_id=f8b4ab12131f4cd99f35c2f55d60ab03
*	после программа выдаст токен, его надо скопировать в настройки системы
*/
require('./fmake/FController.php');
printAr($_REQUEST);
$curl = new cURL();
$curl->init();
echo $request -> code;
$curl -> post("https://oauth.yandex.ru/token","grant_type=authorization_code&code={$request -> code}&client_id=f8b4ab12131f4cd99f35c2f55d60ab03&client_secret=f3d06d36611945dda47acaae7cc48241");
printAr( $curl -> data );
