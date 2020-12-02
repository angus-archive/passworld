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
    background: transparent;
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
        <h1 class="title is-1">Generate a strong password</h1>
        <h3 class="subtitle">Use one of our randomly generated passwords</h3>
      </div>

      <!--Password Generator Columns-->
      <div class="columns is-multiline is-centered is-tablet mt-5">
        <!--Generated password label (GREEN) -->
        <div id="securityIndicator" class="column is-12-tablet is-10-desktop is-centered has-background-secure border3">
          <div class="columns is-vcentered">
            <div class="column is-12">
              <?/*
              <h4 style="white-space: nowrap;overflow: hidden; overflow-x: scroll; height: 100%; font-family: 'Cousine', monospace;" id="passwordView" class="is-size-4 has-text-light">aasjhd23413lsd</h4>
              
              
              <input style="white-space: nowrap;overflow: hidden; overflow-x: scroll; height: 100%; font-family: 'Cousine', monospace; border: 0; background: transparent; padding: 5px;" id="passwordView"class="input has-text-light is-size-4" type="text" placeholder="Password" value="aasjhd23413lsd">
              

              <div class="field is-grouped px-3 py-2">
                <p class="control is-expanded has-icons-left">
                  <input id="passwordView"class="input is-large is-rounded" type="text" placeholder="Password">
                  <span class="icon is-medium is-left">
                      <i class="fas fa-key"></i>
                  </span>
                </p>
                <p class="control">
                  <button id="clearButton" class="button is-danger" >Clear</button>
                </p>
              </div>
              */
              ?>

              <div class="field is-grouped">
                <p class="control is-expanded has-icons-left">
                  <input id="passwordView"class="input is-medium has-text-light" type="text" placeholder="Password">
                  <span class="icon is-medium is-left has-text-light">
                      <i class="fas fa-key"></i>
                  </span>
                </p>
                <p class="control">
                  <button id="clearButton" class="button is-medium">Clear</button>
                </p>

                <p class="control">
                  <button id="copyButton" class="button is-medium"><span class="icon"><i class="far fa-copy"></i></span></button>
                </p>

                <p class="control">
                  <button id="refresh" class="button is-medium"><span class="icon"><i class="fas fa-sync-alt"></i></span></button>
                </p>


              </div>

            </div>
          </div>
        </div>
        <!--Customise Section (WHITE)-->
        <div style="font-family: 'Roboto Mono', monospace;" class="mt-5 column is-12-tablet is-10-desktop is-centered has-background-light border3">
          <!--Strength section-->
          <h4 id="strengthLabel" class="is-size-6 mb-1">Strength: 25</h4>
          <h4 id="crackTimeLabel" class="is-size-6 mb-1">Time to crack: ???</h4>
          <hr style="background-color: #E3E2E4">
          <!--Length label-->
          <h4 id="lengthLabel" class="is-size-5 mb-1">Length: 25</h4>
          <!--Length Slider-->
          <div class="slidecontainer">
            <input id="lengthSlider" type="range" min="3" max="35" value="10" class="slider" style="width: 100%">
          </div>
          <br class="mt-4">
          <!--Customise controls-->
          <fieldset id="passwordParameters">
            <div class="level">
              
                <!--Numbers-->
                <div class="level-item">
                  <label class="checkContainer has-text-centered">Numbers
                    <input id="numCheck" type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <!--Letters-->
                <div class="level-item">
                  <label class="checkContainer has-text-centered">Letters
                    <input id="letCheck" type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <!--Symbols-->
                <div class="level-item">
                  <label class="checkContainer has-text-centered">Symbols
                    <input id="symCheck" type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                  </label>
                </div>     
            </div>
          </fieldset>  
        </div>
      </div>

    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
  <!--Scripts-->
  <script src="/assets/scripts/password.js"></script>
  <script type="text/javascript">
    

    /*
     * Function will get the current value
     * of the slider and generate a password
     */

    function getSliderAndUpdate(){
      var val = document.getElementById("lengthSlider").value
      update(val);
    }

    /*
     * Will generate the complex password
     * as well as updating the correct labels
     */
    function update(length){
      //Update the password label with a generated password
      password=generate(length);
      $("#passwordView").val(password);
      //Update the length label
      let lengthContent="Length: "+length;
      $("#lengthLabel").text(lengthContent);
      rankAndUpdate(password);
    }

    /*
     * Will update the ui based on the generated passwords
     * rank
     */

    function updateColours(passwordRank){
      //Remove all classes
      allClasses=["secure","average","insecure"]
      for (i = 0; i < allClasses.length; i++) {
        $("#securityIndicator").removeClass("has-background-"+allClasses[i]);
        $("#strengthLabel").removeClass("has-text-"+allClasses[i]);
      } 
      switch(passwordRank) {
        case 1:
          $("#securityIndicator").addClass("has-background-insecure");
          //Update label and colour
          $("#strengthLabel").text("Strength: Insecure");
          $("#strengthLabel").addClass("has-text-insecure");
          break;
        case 2:
          $("#securityIndicator").addClass("has-background-average");
          //Update label and colour
          $("#strengthLabel").text("Strength: Medium");
          $("#strengthLabel").addClass("has-text-average");
          break;
        default:
          $("#securityIndicator").addClass("has-background-secure");
          //Update label and colour
          $("#strengthLabel").text("Strength: Secure");
          $("#strengthLabel").addClass("has-text-secure");
      } 
    }

    //Update the labels etc given the password
    function rankAndUpdate(password){
      var timeToCrack = estimateTime(password)
      $("#crackTimeLabel").text("Time to crack: "+convertTime(timeToCrack));
      //Update colours
      updateColours(rankPassword(timeToCrack));
    }



    /* =================== B I N D I N G S ==================== */


    //When user starts typing in password field
    $("#passwordView").on('keyup', function () {
      password=$("#passwordView").val();
      rankAndUpdate(password);
    });

    //When user clicks clear button
    $("#clearButton").click(function() {
      $("#passwordView").val("");
      //Update
      rankAndUpdate("");
    });

    
    /* Function will copy password to clipboard*/
    $( "#copyButton" ).click(function() {
      var copyText = document.getElementById("passwordView");
      copyText.select(); 
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/
      document.execCommand("copy");

      $("#copyButton").animate({
              opacity: 0.5
          }, 500)
          .delay(200)
          .animate({
              opacity: 1
          }, 500);


    });

    /*
     * Binding when a checkbox is clicked
     */
    $('#passwordParameters .checkContainer input').change(function() {
      //If it's currently disabled then simply enable it
      if (this.checked){
        $(this).prop("checked", true);
        //Regenerate when enabled again
        getSliderAndUpdate();
      }
      //Check at least 2 checkboxes are selected
      else if ($('#passwordParameters .checkContainer input:checked').length >= 1){
        //Disable the checkbox
        $(this).prop("checked", false);
        //Regenerate when disabled
        getSliderAndUpdate();

      }else{
        //Force this checkbox to be enabled
        $(this).prop("checked", true);
      }  
    });


    //Whenever slider is moved
    $("#lengthSlider").on("input change", function() {
      //Get the slider value
      var value = this.value;
      //Update
      update(value);
    });



    $( "#refresh" ).click(function() {
      getSliderAndUpdate();
    });


    //JAVASCRIPT FIRST CALLS
    $( document ).ready(function() {
       getSliderAndUpdate(); 
    });


  </script>
</body>
</html>