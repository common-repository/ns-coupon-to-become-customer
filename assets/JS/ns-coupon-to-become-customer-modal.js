jQuery(window).resize(nsAdjustLayout);

function nsAdjustLayout(){
   jQuery('.ns-modal-wc').css({
	   position:'fixed',
	   left: (jQuery(window).width() - jQuery('.ns-modal-wc').outerWidth())/2,
	   top: (jQuery(window).height()/2 - jQuery('.ns-modal-wc').outerHeight())/2
   });

}

jQuery(document).ready(function($) {
	
	nsAdjustLayout();
	$('.ns-modal-wc').show();
	$("html").addClass("ns-modal-opened");
	
	
	// $('.ns-modal-wc').addClass('ns-resize-window');
	// $('.ns-modal-wc').css('margin-top' , -$('.box').outerHeight()/2);
	// $('.ns-modal-wc').css('margin-left' , -$('.box').outerWidth()/2);


	$("#ns-close-modal").click(function() {
		$(".ns-modal-wc-layer").hide();
		$(".ns-modal-wc").hide();
		$(".ns-product-id-hidden").remove();
		$("html").removeClass("ns-modal-opened");
	});


	$(".ns-modal-wc-layer").bind('click', function(e) {
		if($(e.target).closest('.ns-modal-wc').length === 0) {
			$(".ns-modal-wc-layer").hide();
			$(".ns-modal-wc").hide();
			$(".ns-product-id-hidden").remove();
			$("html").removeClass("ns-modal-opened");
		}
	  });

	$("#ns-send-mail").click(function() {


		var ns_mail_sender_name = $('#ns-your-name').val();
		var ns_mail_sender_mail = $('#ns-your-email').val();
		if($('#terms_conditions').prop('checked'))
			var ns_terms_and_conditions = $('#terms_conditions').val();
		else
			var ns_terms_and_conditions = '';
		
		
		$("#ns-send-mail").hide();
		$(".ns-image-loader").show();
		
		$(".ns-ctbc-title").hide();
		$(".ns-ctbc-subtitle").hide();
		

		$.ajax({
			
			
			url: nssendcoupon.ajax_url, 
			type : 'POST',
			data : {
				action : 'ns_wc_send_coupon',
				ns_mail_sender_name : ns_mail_sender_name,
				ns_mail_sender_mail : ns_mail_sender_mail,
				ns_terms_and_conditions : ns_terms_and_conditions,
			},
			success: function(result){
				
				$(".ns-image-loader").hide();
				$(".ns-textarea-size").hide();

				if(result=='error&mail'){
					$( ".ns-div-error-span" ).text("Email required");
				}else if(result=='error&terms'){
					$( ".ns-div-error-span" ).text("Check privacy policy");
				}else if(result=='error&registration'){
					$( ".ns-div-error-span" ).text("Email already used!");
				}
				
				if(result == "done")
					$(".ns-div-success").show();
				else
					$(".ns-div-error").show();
				nsAdjustLayout();
				
			}
		});
		
	});
	
	$(".ns-try-again").click(function() {

		$(".ns-div-error").hide();
		$(".ns-textarea-size").show();
		$("#ns-send-mail").show();
		nsAdjustLayout();
		
	});
		
});


  