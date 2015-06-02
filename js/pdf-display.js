jQuery(document).ready(function($) {

  //window height
  var windowHeight = $(window).height();
  //get height of bar
  var barHeight = $("#pdf-bar").outerHeight();

  function adjustHeight(){
    //Fetch URL of pdf
    var objectData = $("object#pdf-main").attr("data");
    //remove content of data-attribute
    $("object#pdf-main").attr("data", "");

    var objectHeight = windowHeight - barHeight;
    //add bottom padding
    $("object#pdf-main").attr("height", objectHeight);

    //Add data attribute again, since height is now adjusted
    $("object#pdf-main").attr("data", objectData);
  }
  adjustHeight();

  if ($('body').hasClass("bar-location-top")) {
    //$("object#pdf-main").attr("height", windowHeight);
    $("object#pdf-main").css("top", barHeight);
  }

  $( ".close-btn" ).click(function() {
    $("object#pdf-main").attr("height", windowHeight);
    $("object#pdf-main").css("top", 0);
    $("#pdf-bar").hide();
  });

});