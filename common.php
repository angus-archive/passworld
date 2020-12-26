<?php
//Import the global functions
include_once dirname($_SERVER["DOCUMENT_ROOT"])."/core/global-functions.php";
//Import config file
include_once include_local_file("/includes/a_config.php");
//Load the database
include_once include_private_file("/core/public_functions/connect-to-database.php");
//Import public functions
include_once include_private_file("/core/public_functions/public_functions.php");

//Initial password offset (How many appear at first)
$initialOffset=250;
$all_passwords=get_all_common_passwords($pdo);

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
      <!--Main View-->
      <div class="columns is-multiline is-centered is-tablet mt-5">
        <!-- Master container -->
        <div class="column is-12-tablet is-10-desktop is-centered">
          <!--Title and subtitle-->
          <div class="has-text-left-desktop has-text-centered mb-5">
            <h1 class="title is-size-1-tablet is-size-3">Common Passwords</h1>
            <h3 class="subtitle is-size-5-tablet is-size-6">View a list of the 1000 most common passwords</h3>
            <hr>
          </div>
          <!--Common passwords-->
          <div class="column is-12 has-background-light border3">
            <!--Search-->
            <div class="field is-grouped px-3 py-2">
              <p class="control has-icons-left is-expanded">
                <input id="searchBar"class="input" type="text" placeholder="Search">
                <span class="icon is-left">
                  <i class="fas fa-search" aria-hidden="true"></i>
                </span>
              </p>
              <p class="control">
                <button aria-label="Clear search" id="clearButton" class="button is-danger" style="display: none">Clear</button>
              </p>
            </div>
            <!--Number of results-->
            <div class="has-text-centered py-1">
              <p><b id="resultsLabel"><?=sizeof($all_passwords)?></b> results</p>
            </div>
            <!--View passwords-->
            <div id="moreBlock">
              <? for ($i = 0; $i < $initialOffset; $i++):?>
              <? $password = $all_passwords[$i]?>
              <div class="panel-block">
                  <h6 class="subtitle is-6"><b><?=$password["password_id"]?>:</b>&nbsp
                  <?=$password["password"]?></h6>
              </div>
              <? endfor; ?>
            </div>
            <div class="panel-block" id="buttonBlock">
              <button id="loadMore" class="button is-link is-outlined is-fullwidth">
                Load More..
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
  <!--Javascript-->
  <script type="text/javascript">
    //JAVASCRIPT FIRST CALLS
    $( document ).ready(function() {
      
    });
    //Setup initial variables
    var commonPasswords=<?php echo json_encode(get_all_common_passwords($pdo))?>;
    var passwordBucket=[];
    var isSearch = false;
    var offset=parseInt(<?php echo $initialOffset ?>);
    var passwordLimit = parseInt(<?php echo $initialOffset ?>);

    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 500;  //time in ms, 5 second for example
    var $input = $('#searchBar');


    /* =================== F U N C T I O N S ==================== */

    //Will return a sub list with matches
    function search(data,query){
      //Store matches
      matches=[];
      for (var i = 0; i < data.length; i++) {
        //Collect password info
        var resourceInfo=data[i];
        if(resourceInfo["password"].toUpperCase().includes(query.toUpperCase())){
          matches.push(resourceInfo);
        }
      }

      return matches;
    }

    //When user is finished typing in search
    function doneTyping () {
      query=$('#searchBar').val();
      $("#clearButton").show(300);
      console.log("Searching for "+query);
      //Hide all data
      $("#moreBlock").empty();
      //Hide load more 
      $("#loadMore").hide()
      //Search for data
      var matches=search(commonPasswords,query);
      //Update label
      $("#resultsLabel").text(matches.length);
      //Add these matches to the screen
      if (matches.length > passwordLimit){
        $("#loadMore").show();
        addCommonPasswords(matches.slice(0,passwordLimit));
        isSearch=true
        passwordBucket=matches;
        offset=passwordLimit;
      }else{
        addCommonPasswords(matches);
        isSearch=false
        passwordBucket=[];
        offset=0;
      }
      

      
    }

    /*
     * Function will add common passwords
     * to the screen after an AJAX call
     */
    function addCommonPasswords(data){
      for (var i = 0; i < data.length; i++) {
        //Collect password info
        resourceInfo=data[i];
        //Collect info
        var passwordContent=resourceInfo["password"]
        var passwordID=resourceInfo["password_id"]
        //Insert into HTML
        var col = `<div class="panel-block">
            <h6 class="subtitle is-6"><b>${passwordID}:</b>&nbsp
            ${passwordContent}</h6>
        </div>`

        $("#moreBlock").append(col);

      }
    }


    /* =================== B I N D I N G S ==================== */


    //When user starts typing in search bar
    $input.on('keyup', function () {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    $input.on('keydown', function () {
      clearTimeout(typingTimer);
    });

    //Clear button is clicked
    $("#clearButton").click(function(){
      isSearch=false
      passwordBucket=[];
      offset=0;
      $("#searchBar").val("");
      doneTyping();
      $("#clearButton").hide(300);

    });


    //When the loadMore button is clicked
    $( "#loadMore" ).click(function() {
      if (isSearch){
        addCommonPasswords(passwordBucket.slice(offset,offset+passwordLimit));
        offset+=passwordLimit;
        //If offset bigger than list then hide loadMore
        if (offset >= passwordBucket.length - 1){
          $("#loadMore").hide();
        }
      }else{
        //Take array slice
        addCommonPasswords(commonPasswords.slice(offset,offset+passwordLimit));
        offset+=passwordLimit;
        //If offset bigger than list then hide loadMore
        if (offset >= commonPasswords.length - 1){
          $("#loadMore").hide();
        }
      }
      
          
    });

    
  </script>
</body>
</html>