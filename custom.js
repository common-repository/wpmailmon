function toggleRuleState(rl){
jQuery(document).ready(function($) {
		var data = {
			'action': 'wpmm_toggle_rulestate',
			'_wpnonce': wpmm.nonce,
			'ruleid': rl
		};

				jQuery.post(ajaxurl, data, function(response) {

				});
});
}
function swapForm(){
jQuery(document).ready(function($) {
		var form = $("#rule_type").val();
alert(form);

		if (form == 'time'){
		$("#form_frame_flood").hide();
		$("#form_frame_time").show();
		}
		if (form == 'flood'){
		$("#form_frame_time").hide();
		$("#form_frame_flood").show();
		}
});
}

function automon(){
jQuery(document).ready(function($) {
		var data = {
			'action': 'wpmm_admin_automon',
			'_wpnonce': wpmm.nonce
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#jax_throttle_mon").html(response);

				setTimeout(function(){
				automon();
				}, 5000);
				});
});
}
jQuery(document).ready(function($) {

$(".schange").change(function(){
$("#form_frame_flood").toggle();
$("#form_frame_time").toggle();
});

var autom = document.getElementById('jax_throttle_mon');

if (autom){
	automon();
}

$('.custom_date').datepicker({
dateFormat : 'yy-mm-dd'
});


$('.ttip').tooltip();


		//wpmm_admin_deletelog
		$("#wpmm_admin_clearthrottle").click(function() {

		var data = {
			'action': 'wpmm_admin_clearthrottle',
			'_wpnonce': wpmm.nonce
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#jax_msg").html(response);
				$("#set_saved").show();
				setTimeout(function(){
				$("#set_saved").hide();
				$("#jax_msg").html('Setting Changed!');
				document.location.href='';
				}, 5000);
				});
		
		});
		//wpmm_admin_clearlogs

		//wpmm_admin_deletelog
		$("#wpmm_admin_deletelog").click(function() {

		var data = {
			'action': 'wpmm_admin_deletelog',
			'_wpnonce': wpmm.nonce
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#jax_fsize").html('Delete Log File [0 KB]');
				$("#jax_msg").html(response);
				$("#set_saved").show();
				setTimeout(function(){
				$("#set_saved").hide();
				$("#jax_msg").html('Setting Changed!');
				}, 5000);
				});
		
		});
		//wpmm_admin_clearlogs

		$("#wpmm_admin_clearlogs").click(function() {

		var data = {
			'action': 'wpmm_admin_clearlogs',
			'_wpnonce': wpmm.nonce
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#jax_msg").html(response);
				$("#set_saved").show();
				setTimeout(function(){
				$("#set_saved").hide();
				$("#jax_msg").html('Setting Changed!');
				document.location.href='';
				}, 5000);
				});
		
		});

		$("#wpmm_nset").click(function() {

		var data = {
			'action': 'toggle_setting',
			'setting': 'wpmm_throttle_notifications'
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#set_saved").show();
				setTimeout(function(){
				$("#set_saved").hide();
				}, 5000);
				});
		
		});

		//wpmm_authset
		$("#wpmm_authset").click(function() {

		var data = {
			'action': 'toggle_setting',
			'setting': 'wpmm_setting_smtp_auth'
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#set_saved").show();
				setTimeout(function(){
				$("#set_saved").hide();
				}, 5000);
				});
		
		});


		$("#wpmm_eset").click(function() {

		var data = {
			'action': 'toggle_setting',
			'setting': 'wpmm_email_logging'
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#set_saved").show();
				setTimeout(function(){
				$("#set_saved").hide();
				}, 5000);
				});
		
		});

		//wpmm_throttle_protection
		$("#wpmm_tset").click(function() {

		var data = {
			'action': 'toggle_setting',
			'setting': 'wpmm_throttle_protection'
		};

				jQuery.post(ajaxurl, data, function(response) {
					//notification...
				$("#set_saved").show();
				setTimeout(function(){
				$("#set_saved").hide();
				}, 5000);
				});
		
		});
});