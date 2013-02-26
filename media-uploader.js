jQuery(function($){
    $(".select-about-image").live('click', function() {

        var elementId = $(this).attr('id');
        var displayId = elementId.replace('select-image', 'display-image');
        var inputId = elementId.replace('select-image', 'image');


        var fileFrame = wp.media.frames.file_frame = wp.media({
            multiple: false
        });

        fileFrame.on('select', function() {

            var attachment = fileFrame.state().get('selection').first().toJSON();

            $('#' + inputId).val(attachment.id);
            $('#' + displayId).html('<img src="' + attachment.url + '" style="max-width: 226px;" />');

        });

        fileFrame.open();

    });
});