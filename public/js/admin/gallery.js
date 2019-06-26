function startGallery(field) {
    $(field + ' .add-gallery-medium').click(function (e) {
        e.preventDefault();
        var gallery = $(this).closest('.form-group').find('.form-gallery');
        var templateWidget = gallery.data('prototype');
        var $newMedia = $(templateWidget.replace(/__name__/g, generateUID()));

        $newMedia.wrap($('<li class="col-md-2">')).parent().insertBefore($(this).closest('li'));

        // $newMedia.find('img').attr('src', '{{ asset('images/upload.png') }}');
    });

    $(field + ' .delete-gallery-medium').click(function (e) {
        e.preventDefault();
        $(this).closest('li').remove();
    });
}