<?php
include 'connect.php';
$tplt = 'includes/templates/';
$css = 'assest/css/';
$js = 'assest/js/';
$lang = 'includes/languages/';
$func = 'includes/functions/';

include $func.'functions.php';
include $lang.'english.php';
include $tplt . 'header.php'; 

if(!isset($noNav)){include $tplt.'navbar.php';}
?>