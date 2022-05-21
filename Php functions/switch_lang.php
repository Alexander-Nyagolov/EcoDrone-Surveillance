<?php
namespace Phppot;

require_once("./Model/NewsLetter.php");
$newsLetter = new NewsLetter();
$result_lang = $newsLetter->getAllRecords();

// include language configuration file based on selected language
$lang = "en";
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
}
require_once ("./view/Language/lang." . $lang . ".php");

switch ($lang){
case ('en'):
    $selection = "English";
    break;
case ('bg'):
    $selection = "Български";
    break;
case ('de'):
    $selection = "Deutsch";
    break;
case ('ru'):
    $selection = "Руский";
    break;
}
$page = $_SERVER['PHP_SELF'];