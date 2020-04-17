jQuery(document).ready(function() {
	jQuery(".webinar-delete").on("click", function() {
		var wbnId = jQuery(this).attr("id");
		var email = jQuery('#subscriber_email').val();
		if(confirm("Are you sure you want to unsubscribe from this webinar?")){
			jQuery.ajax({
				'url': wpws.ajaxUrl,
				'data': {'action': 'unSubscribeAttendee', 'wbnId': wbnId, 'email': email},
				'dataType': 'json',
				'type': 'POST'
			}).done(function(data){
				if(!data.error){
					jQuery("#data_" + wbnId).remove();
				}
			});
		}
	});
});