function hide_show_tr_select_animation(){
	var radio_ss_style = jQuery('input:radio[name="mpp-ss-settings[select-style]"]');
	if ( radio_ss_style.is(':checked') && ( radio_ss_style.filter(':checked').val() == 'horizontal-with-count' || radio_ss_style.filter(':checked').val() == 'small-buttons' ) ) {
        jQuery("tr.tr-select-animation").hide();
    }
    else{
    	jQuery("tr.tr-select-animation").show();	
    }
}

jQuery(document).ready(function(){

	// hide_show_tr_select_animation();
	jQuery('input:radio[name="mpp-ss-settings[ss-select-style]"]').change(function(){
	    hide_show_tr_select_animation();
    });

});


