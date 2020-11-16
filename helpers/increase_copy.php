<?php
/*
 * Update stats function
 * Angus Goody
 * 16/11/20
 */

header('Content-type: application/json');
header('Access-Control-Allow-Origin: https://www.passworld.co.uk');

//Import the global functions
include_once dirname($_SERVER["DOCUMENT_ROOT"])."/core/global-functions.php";
//Load the database
include_once include_private_file("/core/public_functions/connect-to-database.php");
//Import public functions
include_once include_private_file("/core/public_functions/public_functions.php");

//Increase and then return total
increase_stat_by_one($pdo,"copied");
echo get_stat_value($pdo,"copied");
