$(document).ready(function(){
  setTimeout(function(){
    $(".alert").fadeIn('slow');
  }, 500);
  setTimeout(function(){
    $(".alert").fadeOut('slow');
  }, 5000);

  setTimeout(function(){
    $(".error").fadeIn('slow');
  }, 500);
  setTimeout(function(){
    $(".error").fadeOut('slow');
  }, 5000);
});  