
/*
 * Passworld
 * Global JS files
 * Angus Goody 03/09/2020
*/


$(document).ready(function() {

  // Check for click events on the navbar burger icon
  $(".navbar-burger").click(function() {

      // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
      $(".navbar-burger").toggleClass("is-active");
      $(".navbar-menu").toggleClass("is-active");

  });

  //Dismiss button for bulma notifications
  $(".notification .delete").click(function(){
    parent=$(this).parent();
    parent.hide(250);
  });

  //Dismiss button for bulma messages
  $(".message .delete").click(function(){
    parent=$(this).parent().parent();
    parent.hide(250);
  });
  
});