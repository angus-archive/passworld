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
</head>
<body>
  <!-- Navbar -->
  <? include_once include_local_file("/includes/navbar.php");?>
  <!-- Content -->
  <div id="wrapper" class="has-background-background">
    <div class="container section">
      <!--Title and subtitle-->
      <div class="has-text-centered mb-5">
        <h1 class="title is-1">Common Passwords</h1>
        <h3 class="subtitle">View a list of the 1000 most common passwords</h3>
      </div>

      <!--Main View-->
      <div class="columns is-multiline is-centered is-tablet mt-5">
        <div class="column is-12-tablet is-10-desktop is-centered has-background-light border3">
          <!--View passwords-->
          <div id="moreBlock">
            <? $counter=0 ?>
            <?foreach(get_common_passwords($pdo) as $password):?>
            <? $counter+=1 ?>
            <div class="panel-block">
                <p><b><?=$counter?>:</b>&nbsp</p>
                <p><?=$password["password"]?></p>
            </div>
            <? endforeach; ?>
          </div>
          <div class="panel-block">
            <button id="loadMore" class="button is-link is-outlined is-fullwidth">
              Load More..
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
  <!--Javascript-->
  <script type="text/javascript">

    //When the loadMore button is clicked
    $( "#loadMore" ).click(function() {
      console.log("Load more clicked")
      $.post("/helpers/loadMore", {"offset":offset})
        .done(function( data ) {
          if(data){
            console.log("Valid return");
            data=JSON.parse(data);
            //Add data here
            for (var i = 0; i < data.length; i++) {
              //Collect password info
              resourceInfo=data[i];
              //Collect info
              var counterContent=offset+i+1;
              var passwordContent=resourceInfo["password"]
              //Insert into HTML
              var col = `<div class="panel-block">
                  <p><b>${counterContent}</b>&nbsp</p>
                  <p>${passwordContent}</p>
              </div>`

              $("#moreBlock").append(col);

            }
            //Increase offset
            offset+=25;
          }else{
            console.log("Invalid data returned")
          }
        });
    });

    //JAVASCRIPT FIRST CALLS
    $( document ).ready(function() {
       offset=25; 
    });
  </script>
</body>
</html>