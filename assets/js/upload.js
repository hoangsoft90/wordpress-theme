jQuery(document).ready(function($){
    $('.rt-upload').live( 'click', function(e) {
        e.preventDefault();
        var custom_uploader;
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        var value = $(this).parent().find('.rt-value-upload');

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $(value).val(attachment.url);
        });
        //Open the uploader dialog
        custom_uploader.open();
    }); // end upload banner

});