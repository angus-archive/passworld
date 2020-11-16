<?
//Import the global functions
include_once dirname($_SERVER["DOCUMENT_ROOT"])."/core/global-functions.php";
//Load the database
include_once include_private_file("/core/public_functions/connect-to-database.php");
//Import public functions
include_once include_private_file("/core/public_functions/public_functions.php");
if (isset($_POST['offset'])){
  $offset=$_POST['offset'];
  $data=get_common_passwords($pdo,$offset);
  print_r(json_encode($data));

}

