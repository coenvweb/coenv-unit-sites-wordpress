jQuery(document).ready(function($){
    $('body').on('click', '.custom_media_upload', function(e) {
        var id = $(this).attr('id');
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Widget Image',
            button: {
                text: 'Add Image',
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#coenv_media_image' + id).attr('src', attachment.url).show();
            $('#coenv_media_url' + id).val(attachment.url);
            $('#coenv_media_id' + id).val(attachment.id);
        })
        .open();
    });
    $('body').on('click', '.remove_custom_media', function(e) {
        var id = $(this).attr('id');
        $('#coenv_media_image' + id).attr('src', '').hide();
        $('#coenv_media_url' + id).val('');
        $('#coenv_media_id' + id).val('');
    });
});
