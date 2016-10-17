/**
 * Close UW Alert
 */

jQuery(document).ready(function() {
  closeUWAlert();
});

function closeUWAlert () {
  if($('#uwalert-alert-message').is(':hidden')){ //if the container is visible on the page
    if ($('#uwalert-alert-message')){
        $('#uwalert-alert-header').append('<div class="button right" id="closer">X</div>');
        var alertHeading = $('#uwalert-alert-header')[0];
        $('#closer').live('click', function(e){
            $('#uwalert-alert-message').removeClass('please-unhide');
            $('#uwalert-alert-message').hide();
            localStorage.clicked = alertHeading.innerHTML;
        });
        if(localStorage.clicked === alertHeading.innerHTML){
            console.log('UW Alert is hidden ' + localStorage.clicked);
            $('#uwalert-alert-message').hide();
        } else {
            $('#uwalert-alert-message').addClass('please-unhide');
        }
    }
  } else {
    setTimeout(closeUWAlert, 50); //wait 50 ms, then try again
  }
}