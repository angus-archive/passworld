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

  #passwordView{
    white-space: nowrap;
    overflow: hidden;
    overflow-x: scroll;
    font-family: 'Cousine', monospace; border: 0;
  }

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
        <h2 class="subtitle">Generate a rude memorable password</h3>
      </div>

      <!--Password Generator Columns-->
      <div class="columns is-multiline is-centered is-tablet mt-5">
        <!--Generated password label (GREEN) -->
        <div id="securityIndicator" class="column is-12-tablet is-10-desktop is-centered border3" style="background-color: #436291">
        <div class="columns is-multiline is-vcentered">
          <!--Password label section-->
          <div class="column is-12 has-text-centered">
            <h2 id="passwordView" class="is-size-3 has-text-light">hello_world_one</h2>
          </div>
        </div>
        </div>
        <!--Customise Section (WHITE)-->
        <div style="font-family: 'Roboto Mono', monospace;" class="mt-5 column is-12-tablet is-10-desktop is-centered has-background-light border3"> 
          <div class="level">
            <!--Button 1 -->
            <div class="level-item">
              <button class="button is-medium">
                <span class="icon is-small">
                  <i class="far fa-copy"></i>
                </span>
                <span>Copy</span>
              </button>
            </div>
            <!--Button 2 -->
            <div class="level-item">
              <button class="button is-medium">
                <span class="icon is-small">
                  <i class="fas fa-sync-alt"></i>
                </span>
                <span>Generate</span>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
  <!--Scripts-->
  <script src="/assets/scripts/password.js"></script>
</body>
</html>