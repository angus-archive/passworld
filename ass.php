<?php
//Import the global functions
include_once dirname($_SERVER["DOCUMENT_ROOT"])."/core/global-functions.php";
//Import config file
include_once include_local_file("/includes/a_config.php");
//Load the database
include_once include_private_file("/core/public_functions/connect-to-database.php");
//Import public functions
include_once include_private_file("/core/public_functions/public_functions.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <!-- Head tags -->
  <? include_once include_local_file("/includes/head-tags.php");?>
  <!--Custom CSS-->
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Cousine&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500&display=swap');
  </style>

</head>
<body>
  <!-- Navbar -->
  <? include_once include_local_file("/includes/navbar.php");?>
  <!-- Content -->
  <div id="wrapper" class="has-background-background">
    <div class="container section">

      <!--Title and subtitle-->
      <div class="has-text-centered mb-5">
        <h1 class="title is-1">a$$word</h1>
        <h3 class="subtitle">Generate a rude memorable password</h3>
      </div>

    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
  <!--Scripts-->
  <script src="/assets/scripts/password.js"></script>
</body>
</html>