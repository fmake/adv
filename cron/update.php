<?php
require '../fmake/configs.php';
if($_GET['key'] != $cronKey)exit;
require('../fmake/FController.php');
$update = new projects_update();
$update -> genPic();