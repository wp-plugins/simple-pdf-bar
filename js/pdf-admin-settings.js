jQuery(document).ready(function($) {

  $('#uploadbtn').click(function(e) {
	    e.preventDefault();
	    jQuery('#publish').click();
	});

  $( "#meta-checkbox-enablebar" ).click(function() {
   	enableSettings();
	});

  function enableSettings(){
   if($('#meta-checkbox-enablebar').prop('checked') == true){
   	$(".pdf-bar-settings input").prop('disabled', false);
   	$(".pdf-bar-settings").fadeTo( "fast", 1 );
   } else {
   	$(".pdf-bar-settings input").prop('disabled', true);
   	$(".pdf-bar-settings").fadeTo( "fast", 0.33 );
   }
  }
  enableSettings();

  $( "#meta-include-btn" ).click(function() {
    enableBtnSettings();
  });

  function enableBtnSettings(){
   if($('#meta-include-btn').prop('checked') == true){
    $( ".pdf-bar-settings .btn-settings.first" ).show( "fast" );
    $(".pdf-bar-settings .btn-settings.first input").prop('disabled', false);
    $(".pdf-bar-settings .btn-settings.first").fadeTo( "fast", 1 );
   } else {
    $( ".pdf-bar-settings .btn-settings.first" ).hide( "fast" );
    $(".pdf-bar-settings .btn-settings.first input").prop('disabled', true);
    $(".pdf-bar-settings .btn-settings.first").fadeTo( "fast", 0.33 );
   }
  }
  enableBtnSettings();

  $( "#meta-include-btn-second" ).click(function() {
    enableBtnSettingsSecond();
  });

  function enableBtnSettingsSecond(){
   if($('#meta-include-btn-second').prop('checked') == true){
    $( ".pdf-bar-settings .btn-settings.second" ).show( "fast" );
    $(".pdf-bar-settings .btn-settings.second input").prop('disabled', false);
    $(".pdf-bar-settings .btn-settings.second").fadeTo( "fast", 1 );
   } else {
    $( ".pdf-bar-settings .btn-settings.second" ).hide( "fast" );
    $(".pdf-bar-settings .btn-settings.second input").prop('disabled', true);
    $(".pdf-bar-settings .btn-settings.second").fadeTo( "fast", 0.33 );
   }
  }
  enableBtnSettingsSecond();

  // Add Color Picker to all inputs that have 'color-field' class
    $(function() {

        $('.color-field').wpColorPicker();

    });

});