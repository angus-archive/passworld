/*
 * Passworld
 * JS file for generating passwords etc
 * Angus Goody 16/10/2020
*/




/* =================== F U N C T I O N S ==================== */

//Convert text into Leet speak
function convertLeet(text){
  returnString="";
  for (var i = 0; i < text.length; i++) {
    currentChar=text.charAt(i)
    if (currentChar.toUpperCase() in leetDict){
      returnString+=leetDict[currentChar.toUpperCase()]
    }else{
      returnString+=currentChar;
    }
  }

  return returnString;
}


/*
 * Function will return all the characters for the password in an equal amount      
 */
function createSet(paramList,length){
  var masterString = "";
  let numberOfParams = paramList.length;
  //Calculate set size for each param
  let setSize = Math.floor(length/numberOfParams);  
  let finalSetSize = length-(setSize*(numberOfParams-1))
  //console.log("Using number of params: "+numberOfParams+" and a length of "+length+" our set size is "+setSize+" and our final set size is "+finalSetSize)
  //Go through each parameter
  for (var i = 0; i < numberOfParams; i++) {
    var currentSet = paramList[i]
    //Calculate amount of chars to use
    numberOfChars=setSize;
    if (i >= numberOfParams-1){
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

