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
  <div id="wrapper">
    <section class="hero is-light">
      <div class="hero-body">
        <div class="container has-text-centered">
          <h1 class="title">
            About Passworld
          </h1>
          <h2 class="subtitle">
            A website about passwords
          </h2>
        </div>
      </div>
    </section>

    <div class="has-text-centered p-5">
      <a class="button is-medium is-bluey" target="_" href="https://github.com/angusgoody/passworld">
        <span class="icon is-medium">
          <i class="fab fa-github"></i>
        </span>
        <span>GitHub</span>
      </a>
    </div>

  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
</body>
</html>