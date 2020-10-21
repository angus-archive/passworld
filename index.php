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
          <div class="columns">
            <div class="column is-9">
              <h4 style="white-space: nowrap;overflow: hidden; overflow-x: scroll;
              " id="passwordView" class="is-size-4 has-text-light" style="font-family: 'Cousine', monospace;">aasjhd23413lsd</h4>
            </div>
            <div class="column is-3">
              <!--Level for buttons -->
              <div class="level">
                <div class="level-item">
                  <button class="button"><span class="icon"><i class="far fa-copy"></i></span></button>
                </div>
                <div class="level-item">
                  <button class="button"><span class="icon"><i class="fas fa-sync-alt"></i></span></button>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>

      <div class="columns is-centered mt-5">
        <!--Slider box -->
        <div class="column is-6-desktop is-7-tablet is-6-mobile is-centered has-background-light border3">
          
          <h4 id="lengthLabel" class="is-size-5 mb-1">Length: 25</h4>
          <input id="lengthSlider" type="range" min="5" max="50" value="12" class="slider" style="width: 100%">
          <hr>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
  <!--Scripts-->
  <script type="text/javascript">
    
    /*
     * Will generate the complex password
     */
    function generate(length){
      var password="";
      //All numbers and letters
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      for ( var i = 0; i < length; i++ ) {
        password += possible.charAt(Math.floor(Math.random() * possible.length));
      }
      return password;
    }

    /*
     * Will generate the complex password
     * as well as updating the correct labels
     */
    function update(length){
      //Update the password label with a generated password
      $("#passwordView").text(generate(length));
      //Update the length label
      let lengthContent="Length: "+length;
      $("#lengthLabel").text(lengthContent);
    }

    //Whenever slider is moved
    $("#lengthSlider").on("input change", function() {
      //Get the slider value
      var value = this.value;
      //Update
      update(value);
    });

    //First calls (when page loads)
    $( document ).ready(function() {
       //Update
       var val = document.getElementById("lengthSlider").value
       update(val); 
    });


  </script>
</body>
</html>