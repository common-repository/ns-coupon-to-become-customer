jQuery(document).ready(function($) {
	
    $('#ns-ctbc-checkbox').change(function () {
        if ($(this).is(":checked")) {
            $('#ns-show-if-checked').fadeIn('slow');
        } else {
            $('#ns-show-if-checked').fadeOut('slow');
        }
    });

});


  