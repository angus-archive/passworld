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

      <!--Password View Section-->
      <div class="columns is-vcentered is-centered is-mobile mt-5">
        <!--Generated password label -->
        <div class="column is-9 is-centered has-background-secure border3">
          <div class="columns">
            <div class="column is-10">
              <h4 style="white-space: nowrap;overflow: hidden; overflow-x: scroll; height: 100%; font-family: 'Cousine', monospace;" id="passwordView" class="is-size-4 has-text-light">aasjhd23413lsd</h4>
            </div>
            <div class="column is-2">
              <!--Level for buttons -->
              <div class="level is-mobile">
                <div class="level-item">
                  <button data-tooltip="Copy to Clipboard" onclick="copyToClipboard()" class="button has-tooltip-right"><span class="icon"><i class="far fa-copy"></i></span></button>
                </div>
                <div class="level-item">
                  <button data-tooltip="Regenerate password" id="refresh" class="button has-tooltip-right"><span class="icon"><i class="fas fa-sync-alt"></i></span></button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!--Password Config Section-->
      <div class="columns is-centered is-mobile mt-5">
        <!--Customise Section -->
        <div style="font-family: 'Roboto Mono', monospace;" class="column is-9 is-centered has-background-light border3">
          <h4 id="lengthLabel" class="is-size-5 mb-1">Length: 25</h4>
          <div class="slidecontainer">
            <input id="lengthSlider" type="range" min="5" max="50" value="12" class="slider" style="width: 100%">
          </div>
          <hr>
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
  <script type="text/javascript">
    
    /* =================== F U N C T I O N S ====================

    /*
     * Will generate the complex password
     */
    function generate(length){
      var password="";
      //Setup an array for all letters and numbers etc
      var all = ""
      //Add the correct letters, numbers etc depending on check state
      all+=(addSet("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz","letCheck"));
      all+=(addSet("0123456789","numCheck"));
      all+=(addSet(";!£$&'#,?{}[]()+=*<>~","symCheck"));
      //Create the password
      for ( var i = 0; i < length; i++ ) {
        password += all.charAt(Math.floor(Math.random() * all.length));
      }
      return password;
    }

    /*
     * Function will add a data set to the all list given its widget ID
     */
    function addSet(chars,widgetID){
      //Only add the set if the checkbox is checked
      if($("#"+widgetID).is(':checked')){
        return chars
      }
      return "";
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

    /*
     * Function will get the current value
     * of the slider and generate a password
     */

    function getSliderAndUpdate(){
      var val = document.getElementById("lengthSlider").value
      update(val);
    }

    /*
     * Function will copy password to clipboard
     */

    function copyToClipboard(){
      //Get the password label element
      var copyText = document.getElementById("passwordView");
      //Select the text
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/
      //Copy
      document.execCommand("copy");
      //Alert
      alert("Copied password");
    }

    /* =================== B I N D I N G S ====================

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