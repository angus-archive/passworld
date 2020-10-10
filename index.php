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
  <!--Custom CSS-->
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Cousine&display=swap');
  </style> 
</head>
<body>
  <!-- Navbar -->
  <? include_once include_local_file("/includes/navbar.php");?>
  <!-- Content -->
  <div id="wrapper"  style="background-color: #D9DFE3">
    <div class="container section">
      <div class="has-text-centered mb-5">
        <h1 class="title is-1">Generate a strong password</h1>
        <h3 class="subtitle">Use one of our randomly generated passwords</h3>
      </div>
      <div class="columns is-centered is-mobile mt-5">
        <!--Generated password label -->
        <div class="column is-6-desktop is-7-tablet is-6-mobile is-centered has-background-secure border3">
          <h4 class="is-size-4 has-text-light" style="font-family: 'Cousine', monospace;">aasjhd23413lsd</h4>
        </div>
      </div>

      <div class="columns is-centered mt-5">
        <!--Slider box -->
        <div class="column is-6-desktop is-7-tablet is-6-mobile is-centered has-background-light border3">
          <h4 class="is-size-5 mb-1">Length: 25</h4>
          <input type="range" min="1" max="100" value="50" class="slider" style="width: 100%">
          <hr>
          <div class="has-text-centered">
            <button class="button">More</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
</body>
</html>