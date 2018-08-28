jQuery(document).ready(function(){
    jQuery('.datepicker').datepicker();

    (function($) {

        $('.headlines_form').submit(function(event) {
            event.preventDefault();
            var data = {
                'action'     : 'build_newsletter',
                'newsletter' : $('select[name="newsletter"]').val()
            }

            $.post(ajax_object.ajax_url, data, function(response) {
                $('#newsletter').html(response);
            });
            
            //TODO: clear button?

        });

    })(jQuery);
});
