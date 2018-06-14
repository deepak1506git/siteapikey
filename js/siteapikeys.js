(function ($) {
  Drupal.behaviors.bxslider = {
    attach: function (context, settings) {
      /* Change site information button text while insert site api key only */
      if ($('#system-site-information-settings input#edit-site-api-key').val().length > 0) {
        $('#system-site-information-settings #edit-submit').val('Update Configuration');
      }else{
        $('#system-site-information-settings #edit-submit').val('Save configuration');
      }
      $('#system-site-information-settings input#edit-site-api-key').keyup(function() { 
        if ($('#system-site-information-settings input#edit-site-api-key').val().length > 0) {
          $('#system-site-information-settings #edit-submit').val('Update Configuration');
        }else{
          $('#system-site-information-settings #edit-submit').val('Save configuration');
        }
      });
    }
  };
}(jQuery));
