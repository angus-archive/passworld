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
                  <button id="copyButton" data-tooltip="Copy to Clipboard" class="button has-tooltip-right"><span class="icon"><i class="far fa-copy"></i></span></button>
                </div>
                <div class="level-item">
                  <button data-tooltip="Regenerate password" id="refresh" class="button has-tooltip-right"><span class="icon"><i class="fas fa-sync-alt"></i></span></button>
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
  <script type="text/javascript">
    
    /* =================== F U N C T I O N S ==================== */

    /*
     * Will generate the complex password
     */
    function generate(length){
      var password="";

      //Set of parameters to use
      masterSet=[]
      allSet=[["ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz","letCheck"],
        ["0123456789","numCheck"],[";!£$&'#,?{}[]()+=*<>~","symCheck"]]
      //Filter into master set (only add characters based on checkboxes)
      for (var i = 0; i < allSet.length; i++) {
        if (checkSet(allSet[i][1])){
          masterSet.push(allSet[i])
        }
      }
      //Create a master string to pick randomly from
      masterString=createSet(masterSet,length).split('').sort(function(){return 0.5-Math.random()}).join(''); //Shuffle the password
      return masterString
    }

    /*
     * Function will all the characters for the password in an equal amount      
     */
    function createSet(paramList,length){
      var masterString = "";
      let numberOfParams = paramList.length;
      //Calculate set size for each param
      let setSize = Math.floor(length/numberOfParams);  
      let finalSetSize = length-((numberOfParams-1)*setSize);
      //Go through each parameter
      for (var i = 0; i < numberOfParams; i++) {
        var currentSet = paramList[i]
        //Calculate amount of chars to use
        numberOfChars=setSize;
        if (i < numberOfParams-1){
          numberOfChars=finalSetSize;
        }
        //Randomly pick this amount of chars and add it to masterString
        for (var j = 0; j < numberOfChars; j++) {
          masterString += currentSet[0].charAt(Math.floor(Math.random() * currentSet[0].length))
        }
        
      } 
      return masterString;       
    }

    /*
     * Function will check if user wants to use this parameters set
     */
    function checkSet(widgetID){
      //Only add the set if the checkbox is checked
      if($("#"+widgetID).is(':checked')){
        return true;
      }
      return false;
    }

    /*
     * Will generate the complex password
     * as well as updating the correct labels
     */
    function update(length){
      //Update the password label with a generated password
      password=generate(length);
      $("#passwordView").text(password);
      //Update the length label
      let lengthContent="Length: "+length;
      $("#lengthLabel").text(lengthContent);
      //Estimate time
      var timeToCrack = estimateTime(password)
      $("#crackTimeLabel").text("Time to crack: "+convertTime(timeToCrack));
      //Update colours
      updateColours(rankPassword(timeToCrack));
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
     * Function will rank a generated password
     * returns 1, 2 or 3 (3 being best)
     */

    function rankPassword(timeToCrack){
      //If password can be cracked in less than an hour
      if (timeToCrack < 3600){
        return 1
      //If can be cracked in under a year
      }else if(timeToCrack < 3.154e7){
        return 2
      }
      //Takes over a year to crack
      return 3
    }

    /*
     * Estimate the amount of time to crack this password
     */
    function estimateTime(password){;
      //Regular expressions
      let numbersExpression = /\d/ ;
      let lowerExpression = /[a-z]/;
      let upperExpression = /[A-Z]/;
      let symbolsExpression = /[\!\"\#\$\%\&\'\(\)\*\+\,\-\.\/\:\;\<\>\=\?\@\[\]\{\}\\\\\^\_\`\~]/;
      //Create a dictionary
      var regexDict=[[numbersExpression,9],[lowerExpression,26],[upperExpression,26],[symbolsExpression,30]]

      //Calculate the set length
      var setLength = 0;
      for(var i=0; i < regexDict.length; i++) {
        key=regexDict[i][0];
        value=regexDict[i][1];
        //Get the value (current set length)
        if ((password.match(key))){
          setLength+=value;
        }
      }

      //Store constants
      averagePC = 1.21e-7
      superComputer = 1.21e-11;

      //Return
      return 0.5*Math.pow(setLength,password.length) * superComputer; 


    }

    /*
     * Will convert time in seconds to a more 
     * readable format
     */
    function convertTime(time){
      //Array to convert time to a string value
      var data=[["Seconds",60],["Minutes",3600],["Hours",86400],["Days",3.154e7],["Years",3.154e8],["Decades",3.154e9],["Centurys",3.154e10],["Milleniums",3.154e11]];
      //Setup response
      response="???"
      if (time < 1){
        response="Less than a second"
      }else{
        //Loop through time stamps
        for (var i =0; i < data.length;i++){
          item=data[i]
          //If the generated time is less than the current timestamp
          if (time < item[1]){
            var divisor = 1
            if (i > 0){
              divisor=data[i-1][1];
            }
            //Divide the generate time by the divisor and create a string
            response = Math.round(time/divisor)+" "+item[0];
            break;
          }
          response="Over 1 Million Years"
            
        }
      }
      return response;
    }


    /*
     * Will update the ui based on the generated passwords
     * rank
     */

    function updateColours(passwordRank){
      //Remove all classes
      allClasses=["secure","medium","insecure"]
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
          $("#securityIndicator").addClass("has-background-medium");
          //Update label and colour
          $("#strengthLabel").text("Strength: Medium");
          $("#strengthLabel").addClass("has-text-medium");
          break;
        default:
          $("#securityIndicator").addClass("has-background-secure");
          //Update label and colour
          $("#strengthLabel").text("Strength: Secure");
          $("#strengthLabel").addClass("has-text-secure");
      } 
    }

    /* =================== B I N D I N G S ====================
  
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