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

  .icon-insecure{
    background: url('/assets/images/icons/insecure.svg');
    height: 20px;
    width: 20px;
    display: block;
  }

  .icon-average{
    background: url('/assets/images/icons/average.svg');
    height: 20px;
    width: 20px;
    display: block;
  }

  .icon-secure{
      background: url('/assets/images/icons/secure.svg');
      height: 20px;
      width: 20px;
      display: block;
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
          <div class="columns is-multiline is-vcentered">
            <!--Password label section-->
            <div class="column is-8 is-9-widescreen">
              <div class="field is-grouped">
                <p class="control is-expanded has-icons-left">
                  <input id="passwordView"class="input is-medium has-text-light" type="text" placeholder="Password">
                  <?/*
                  <span class="icon is-medium is-left has-text-light">
                      <i class="fas fa-key"></i>
                  </span>
                  */
                  ?>
                  <span class="icon is-medium is-left has-text-light">
                      <i id="strengthIcon" class="low-icon"></i>
                  </span>
                </p>
              </div>
            </div>
            <div class="column is-4 is-3-widescreen">
              <div class="level is-mobile">
                <div class="level-item">
                  <button aria-label="clear password" id="clearButton" class="button"><span class="icon"><i class="fas fa-backspace"></i></span></button>
                </div>
                <div class="level-item">
                  <button aria-label="copy password" id="copyButton" class="button"><span class="icon"><i class="far fa-copy"></i></span></button>
                </div>
                <div class="level-item">
                  <button aria-label="regenerate password" id="refresh" class="button"><span class="icon"><i class="fas fa-sync-alt"></i></span></button>
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
          <label for="lengthSlider" id="lengthLabel" class="is-size-5 mb-1">Length: 25</label>
          <!--Length Slider-->
          <div class="slidecontainer">
            <input id="lengthSlider" type="range" min="3" aria-valuemin="3" max="35" aria-valuemax="35" value="10" aria-valuenow="10" class="slider" style="width: 100%">
          </div>
          <br class="mt-4">
          <!--Customise controls-->
          <fieldset id="passwordParameters">
            <div class="level">
              
                <!--Numbers-->
                <div class="level-item">
                  <label aria-label="Include Numbers in password" class="checkContainer has-text-centered">Numbers
                    <input id="numCheck" type="checkbox" checked="checked">
                    <span aria-checked='true' class="checkmark"></span>
                  </label>
                </div>
                <!--Letters-->
                <div class="level-item">
                  <label aria-label="Include Letters in password" class="checkContainer has-text-centered">Letters
                    <input id="letCheck" type="checkbox" checked="checked">
                    <span aria-checked='true' class="checkmark"></span>
                  </label>
                </div>
                <!--Symbols-->
                <div class="level-item">
                  <label aria-label="Include Symbols in password" class="checkContainer has-text-centered">Symbols
                    <input id="symCheck" type="checkbox" checked="checked">
                    <span aria-checked='true'  aria- class="checkmark"></span>
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
    
    //Setup initial variables
    var commonPasswords=<?php echo json_encode(get_all_common_passwords($pdo))?>;

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
        $("#strengthIcon").removeClass("icon-"+allClasses[i])
      } 
      switch(passwordRank) {
        case 1:
          $("#securityIndicator").addClass("has-background-insecure");
          //Update label and colour
          $("#strengthLabel").text("Strength: Insecure");
          $("#strengthLabel").addClass("has-text-insecure");
          //Update icon
          $("#strengthIcon").addClass("icon-insecure");
          break;
        case 2:
          $("#securityIndicator").addClass("has-background-average");
          //Update label and colour
          $("#strengthLabel").text("Strength: Medium");
          $("#strengthLabel").addClass("has-text-average");
          $("#strengthIcon").addClass("icon-average");
          break;
        default:
          $("#securityIndicator").addClass("has-background-secure");
          //Update label and colour
          $("#strengthLabel").text("Strength: Secure");
          $("#strengthLabel").addClass("has-text-secure");
          $("#strengthIcon").addClass("icon-secure");
      } 
    }

    //Check if password is a common one
    function isPasswordCommon(password){
      for (var i = 0; i < commonPasswords.length; i++) {
        //Collect password info
        var inList=commonPasswords[i]["password"].toUpperCase();
        var onscreen=password.toUpperCase();
        if(onscreen.includes(inList)){
          return true;
        }
      }
      return 
    }

    //Update the labels etc given the password
    function rankAndUpdate(password){
      var timeToCrack = estimateTime(password)
      $("#crackTimeLabel").text("Time to crack: "+convertTime(timeToCrack));
      //Check if password is common
      if (isPasswordCommon(password)){
        $("#crackTimeLabel").text("Time to crack: Instant (Common Password)");
        updateColours(1)
      }else{
        //Update colours
        updateColours(rankPassword(timeToCrack));
      }
      
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