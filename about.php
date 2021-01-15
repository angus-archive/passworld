<?php
//Import the global functions
include_once dirname($_SERVER["DOCUMENT_ROOT"])."/core/global-functions.php";
//Import config file
include_once include_local_file("/includes/a_config.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <!-- Head tags -->
  <? include_once include_local_file("/includes/head-tags.php");?>
</head>
<body>
  <!-- Navbar -->
  <? include_once include_local_file("/includes/navbar.php");?>

  <!-- Content -->
  <div id="wrapper" class="has-background-background">
    <div class="container section">
      <!--Master column-->
      <div class="columns is-multiline is-centered is-tablet mt-5">
        <!--Main container column-->
        <div class="column is-12-tablet is-10-desktop is-centered">
          <!--Title and subtitle-->
          <div class="has-text-left-desktop has-text-centered mb-5">
            <h1 class="title is-size-1-tablet is-size-3">About Passworld</h1>
            <h3 class="subtitle is-size-5-tablet is-size-6">Find out about Passworld</h3>
            <hr>
          </div>
          <div class="column">
            <div class="has-text-centered p-5">
              <a class="button is-medium is-bluey" target="_" href="https://github.com/angusgoody/passworld">
                <span class="icon is-medium">
                  <i class="fab fa-github"></i>
                </span>
                <span>GitHub</span>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
</body>
</html>