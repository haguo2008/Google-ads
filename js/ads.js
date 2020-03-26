jQuery(document).ready(function ($) {
	var $body = $( 'body' ),
		isOverGoogleAd = false,
		ad = /adsbygoogle/,
		isblock = $body.hasClass( 'ads-display' ),
		adsdisplay = 'ads-display',
		adshide = 'ads-hide';
	
    $(document).ready(function(){
        $('ins').on('mouseover', function () {
            if(ad.test($(this).attr('class'))){
                isOverGoogleAd = true;
            }
        });
        $('ins').on('mouseout', function () {
            if(ad.test($(this).attr('class'))){
                isOverGoogleAd = false;
            }
        });
    });
    $(window).blur(function(e){
        if(isOverGoogleAd){
            $.ajax({
				type: 'post',
				url: ads_js_object.admin_ajax_url,
				data: {
					type: 'post',
					action: 'ads_ajax_action',
					_wpnonce: ads_js_object.admin_ajax_nonce
				},
					success: function (res) {
					if(isblock){
						$body.removeClass( adsdisplay );
						$body.addClass( adshide );
					}
				}
			});
        }
    });
});