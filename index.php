<?php
//Import the global functions
include_once dirname($_SERVER["DOCUMENT_ROOT"])."/core/global-functions.php";
$error_file_location="/views/public/util/invalid404.php";
$path=parse_url($_SERVER['REQUEST_URI'])["path"];
$elements = preg_split('@/@', $path, NULL, PREG_SPLIT_NO_EMPTY);
//If no parameters - Go home
if(empty($elements))                       
    include_once include_private_file("/views/public/home.php");
else 
switch(array_shift($elements))// Pop off first item and switch
{

  //About page
  case 'about':
    if (count($elements) > 0){include_once include_private_file($error_file_location);}else{include_once include_private_file("/views/public/about.php");}
    break;

  //Common page
  case 'common':
    if (count($elements) > 0){include_once include_private_file($error_file_location);}else{include_once include_private_file("/views/public/common.php");}
    break;

  //Ass page
  case 'ass':
    if (count($elements) > 0){include_once include_private_file($error_file_location);}else{include_once include_private_file("/views/public/ass.php");}
    break;

  //Webhook
  case 'webhook':
    if (count($elements) > 0){include_once include_private_file($error_file_location);}else{include_once include_private_file("/views/public/util/webhook.php");}
    break;


  //Sitemap
  case 'sitemap.xml':
    $filePath=include_private_file("/views/public/util/sitemap.xml");
    $file = file_get_contents($filePath);
    header('Content-type: text/xml');
    echo $file;
    break;

  //Robots
  case 'robots.txt':
    $filePath=include_private_file("/views/public/util/robots.txt");
    $file = file_get_contents($filePath);
    header('Content-type: text');
    echo $file;
    break;

  //Default - Go to error page
  default:
      include_once include_private_file($error_file_location);
}

?>