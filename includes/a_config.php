<?php
/*
 * This is the config file, this is the first script loaded for every web page
 * on your site, it will setup any global variables needed etc.
 *
 * -------- GLOBAL VARIABLES ---------
 *
 * NAV_PAGE: The global variable indicating the currently selected navigation link
 * CURRENT_PAGE: The currently loaded page (for use in code; not displayed)
 * PAGE_TITLE: The title which is displayed in the Browser tab
 * PAGE_DESCRIPTION: The description of the page (appears in search results)
 * PAGE_CANONICAL: The canonical tag that is used for page directs and SEO
 * 
 * -----------------------------------
 * 
 * The comment below will appear at the top of every page on your site
 */
?>
<!--Passworld, created by Angus Goody 08/10/2020-->

<?php

//Setup Global defaults to avoid undefined errors (These will get overwritten)
$NAV_PAGE="index";
$CURRENT_PAGE="index";
$PAGE_TITLE="Home";
$PAGE_DESCRIPTION="Welcome to Passworld";


//Find the path of the current page
$full_path = $_SERVER["PHP_SELF"];
$first_parent = dirname($full_path);
$file_base = basename($full_path);

//Calculate Canonical
$can_header="https://";
if ($file_base != "index.php"){
    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $full_path); //Remove PHP extension
}else{
  $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $first_parent);
}
$PAGE_CANONICAL=$can_header.$_SERVER['SERVER_NAME'].$withoutExt;


switch ($full_path) {

	//Home page
	case '/index.php':
		$NAV_PAGE="index";
		$CURRENT_PAGE="index";
		$PAGE_TITLE="Generate | Passworld";
		$PAGE_DESCRIPTION="Generate a strong secure password here at Passworld";
		break;

	//Ass page
	case '/ass.php':
		$NAV_PAGE="ass";
		$CURRENT_PAGE="ass";
		$PAGE_TITLE='a$$word | Passworld';
		$PAGE_DESCRIPTION="Generate a secure rude password here at Passworld";
		break;

	//About Page
	case '/about.php':
		$NAV_PAGE="about";
		$CURRENT_PAGE="about";
		$PAGE_TITLE="About | Passworld";
		$PAGE_DESCRIPTION="Find out about Passworld";
		break;

	//Common Page
	case '/common.php':
		$NAV_PAGE="common";
		$CURRENT_PAGE="common";
		$PAGE_TITLE="Common Passwords | Passworld";
		$PAGE_DESCRIPTION="View a list of the most commonly used passwords in the world";
		break;


	//If undefined
	default:
		$NAV_PAGE="undefined";
		$CURRENT_PAGE="undefined";
		$PAGE_TITLE="Passworld";
		$PAGE_DESCRIPTION="Welcome to Passworld";
		break;
}

?>
