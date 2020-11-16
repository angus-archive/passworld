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
  <div id="wrapper"  style="background-color: #D9DFE3">
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
          <div class="columns">
            <div class="column is-10">
              <h4 style="white-space: nowrap;overflow: hidden; overflow-x: scroll; height: 100%; font-family: 'Cousine', monospace;" id="passwordView" class="is-size-4 has-text-light">aasjhd23413lsd</h4>
            </div>
            <div class="column is-2">
              <!--Level for buttons -->
              <div class="level is-mobile">
                <div class="level-item">
                  <button id="copyButton" class="button"><span class="icon"><i class="far fa-copy"></i></span></button>
                </div>
                <div class="level-item">
                  <button id="refresh" class="button"><span class="icon"><i class="fas fa-sync-alt"></i></span></button>
                </div>
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
            <input id="lengthSlider" type="range" min="3" max="35" value="10" class="slider" onmouseup="sliderUp()" ontouchend="sliderUp()" style="width: 100%">
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
      addOneToGenCounter();
    }

    //Function will format a number with thousands seperator
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    //Function will update the number of generated passwords
    function addOneToGenCounter(){
      //Ajax function will update total on server and return result
      $.post("/helpers/increase_gen.php", function(result, status){
      });
    }

    //Function will update the number of copied passwords
    function addOneToCopyCounter(){
      //Ajax function will update total on server and return result
      $.post("/helpers/increase_copy.php", function(result, status){
      });

    }


    /* =================== B I N D I N G S ==================== */

    //Will be called when user releases slider
    function sliderUp(){
      //Increase running total by one 
      addOneToGenCounter();
    }
    
    /* Function will copy password to clipboard*/
    $( "#copyButton" ).click(function() {
      //Get the password label element
      element=("#passwordView")
      //Copy to clipboard using temp input field
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      //Increase counter
      addOneToCopyCounter();
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