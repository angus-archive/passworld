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

      <!--Password Generator Columns-->
      <div class="columns is-multiline is-centered is-tablet mt-5">
        <!--Main container column-->
        <div class="column is-12-tablet is-10-desktop is-centered">
          <!--Title and subtitle-->
          <div class="has-text-left-desktop has-text-centered mb-5">
            <h1 class="title is-size-1-tablet is-size-3">a$$word</h1>
            <h3 class="subtitle is-size-5-tablet is-size-6">Generate a strong rude password</h3>
            <hr>
          </div>
          <!--Generated password label -->
          <div id="securityIndicator" class="column is-12 border3 has-background-bluey">
            <div class="columns is-multiline is-vcentered">
              <!--Password label section-->
              <div class="column is-12 has-text-centered">
                <h2 id="passwordView" class="is-size-3-tablet is-size-5 has-text-light">hello_world_one</h2>
              </div>
            </div>
          </div>

          <!--Customise Section (WHITE)-->
          <div class="mt-5 column is-12 has-background-light border3 has-code-font"> 
            <div class="level">
              <!--Button 1 -->
              <div class="level-item">
                <button id="generate_word" class="button is-medium">
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
  </div>
  <!-- Footer -->
  <? include_once include_local_file("/includes/footer.php");?>
  <!--Scripts-->
  <script src="/assets/scripts/password.js"></script>
  <script type="text/javascript">


    /* =================== C L A S S E S ==================== */

    /*
     * Class to organise word types of a language, i.e verbs nouns etc
     * letter: The letter to represent this word type
     * wordList: The list of words of this type
     */
    class words{
      constructor(letter, wordList) {
        this.letter = letter;
        this.wordList = wordList;
      }
      //Add a word to the list
      addWord(word){
        this.wordList.push(word)
      }
    }

    /*
     *Class to organise language
     * grammar: The accepted grammar order
     * allWords: A list of all the words classes
     */
    class language{
      constructor(grammar,allWords){
        this.grammar=grammar
        this.allWords=allWords
      }
      
      //Generate a random string from the grammar
      randomSentence(){
        return this.convertSentence(randomItem(this.grammar))
      }
      
      //Given a input string, generate a sentence
      convertSentence(myString){
        if (myString.length > 1){
          return this.convertSentence(myString.slice(0,1)) + "_" + this.convertSentence(myString.slice(1))
        }else{
          for (var i=0; i < this.allWords.length; i++) {
            var currentWords=this.allWords[i]
            if (currentWords.letter.toUpperCase() == myString.toUpperCase()){
              return randomItem(currentWords.wordList)
            }
          }
        }
      }
    }

    //Function to pick random item from list
    function randomItem (myArray) {
      return myArray[Math.floor(Math.random()*myArray.length)];
    }
    
    //Take the json data and create a words object
    function create_word(letter,jsonData){
      //Create the words object
      let newWord = new words(letter,[])
      //Filter json data and add words to words object
      for(var i in jsonData){
        newWord.addWord(jsonData[i]["word"])
      }

      return newWord
    }


    //Will update the screen with a new word
    function regenerate_word(){
      $("#passwordView").text(myLanguage.randomSentence());
    }

    //When the regenerate button is clicked
    $( "#generate_word" ).click(function() {
      regenerate_word();
    });


    //Get json objects from database
    var verbs=<?php echo json_encode(get_verbs($pdo))?>;
    var adjectives=<?php echo json_encode(get_adjectives($pdo))?>;
    var nouns=<?php echo json_encode(get_nouns($pdo))?>;
    var participles=<?php echo json_encode(get_participles($pdo))?>;
    //Create our language
    var myLanguage = new language(["APN","AVN","PNN","PVN"],
      [create_word("V",verbs),create_word("A",adjectives),create_word("N",nouns),create_word("P",participles)])

    //JAVASCRIPT FIRST CALLS
    $( document ).ready(function() {
       //Update our label
       regenerate_word();
    });

    


  </script>
</body>
</html>