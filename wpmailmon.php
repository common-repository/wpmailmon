<?php
/*
Plugin Name: WPMailMon
Plugin URI:
Description: Protect & Monitor your Outgoing Mail & add SMTP authentication.
Version: 1.3.0.1
*/

if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class wpmmAdminSet{
function ttip($txt, $class = 'ttip'){
return ' class="'.$class.'" data-html="true" data-toggle="tooltip" data-placement="bottom" title="'.$txt.'"';
}
	function settings(){
	?>
<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
<input type="hidden" name="action" value="WPMailMon_save_settings"/>
<div class="container">
    <div class="row">
        <div class="col-md-6">
<h4>SMTP Settings</h4>
<div class="note">SMTP settings are not required by default, they may overide other plugins with SMTP settings. Your emails may still send without SMTP settings depending on your server setup but we always recommend SMTP settings to fully authenticate your outgoing emails.</div>
<p><br />
  <label for="data[setting_email_host]">SMTP Host</label>
  <br />
  <input type="text" id="data[setting_email_host]" name="data[setting_email_host]" placeholder="your.email.host" style="width:100%" <? echo $this->ttip('Outgoing mail server eg smtp.gmail.com, localhost'); ?> value="<? echo get_option('wpmm_setting_email_host'); ?>" /><br />
  <label for="data[setting_email_user]">SMTP Username</label>
  <br />
  <input type="text" id="data[setting_email_user]" name="data[setting_email_user]" placeholder="your@email.com" style="width:100%" <? echo $this->ttip('Outgoing mail server username for authentication.'); ?> value="<? echo get_option('wpmm_setting_email_user'); ?>" /><br />
  <label for="data[setting_email_pass]">SMTP Password</label>
  <br />
  <input type="password" id="data[setting_email_pass]" name="data[setting_email_pass]" style="width:100%" <? echo $this->ttip('Outgoing mail server password for authentication.'); ?> /><br />
  <label for="data[setting_email_security]">SMTP Security</label>
  <br />
  <select id="data[setting_email_security]" name="data[setting_email_security]" style="width:50%" <? echo $this->ttip('SMTP Security Type Normally TLS for port 25 and SSL for port 465.'); ?>>
    <option value="tls" <? if (get_option('wpmm_setting_email_security') == 'tls' || !get_option('wpmm_setting_email_security')): ?>selected="selected"<? endif; ?>>TLS</option>
    <option value="ssl" <? if (get_option('wpmm_setting_email_security') == 'ssl'): ?>selected="selected"<? endif; ?>>SSL</option>
  </select>
  <br />
  <label for="data[setting_email_port]">SMTP Port</label>
  <br />
  <input type="text" id="data[setting_email_port]" name="data[setting_email_port]" style="width:50%" <? echo $this->ttip('Outgoing mail server port, usually 25 or <b> for SSL</b> 465'); ?> placeholder="25" value="<? echo get_option('wpmm_setting_email_port'); ?>" /><br />
  <label for="data[setting_email_header]">Plaintext/HTML</label>
  <br />
  
  <select id="data[setting_email_header]" name="data[setting_email_header]" style="width:50%" <? echo $this->ttip('Send email using <strong>HTML</strong> or simple plaintext.'); ?>>
    <option value="plaintext" <? if (get_option('wpmm_setting_email_header') == 'plaintext') { ?> selected="selected"<? } ?>>plaintext</option>
    <option value="html" <? if (get_option('wpmm_setting_email_header') == 'html') { ?> selected="selected"<? } ?>>html</option>
    
  </select>
<br />
Use SMTP Authentication<br />
<label class="switch">
  <input type="checkbox" <? if (get_option('wpmm_setting_smtp_auth') == 'on') { ?>checked<? } ?> id="wpmm_authset" class="ttip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Use SMTP authentication to send emails.">
  <span class="slider"></span>
</label><br />
      </div>
        
		<div class="col-md-6">
<h4>Throttle Settings</h4>
<label for="data[setting_throttle_max_errors]">Error cutout</label><br />
<input type="text" id="data[setting_throttle_max_errors]" name="data[setting_throttle_max_errors]" placeholder="0" style="width:50%" <? echo $this->ttip('Stop sending emails if the system has this many errors.<br><b>(0)</b> will disable.<br>You must clear the logs to reset the error counts.'); ?> value="<? echo get_option('wpmm_setting_throttle_max_errors'); ?>" /><br />
<label for="data[setting_throttle_max_emails]">Max daily emails</label><br />
<input type="text" id="data[setting_throttle_max_emails]" name="data[setting_throttle_max_emails]" placeholder="0" style="width:50%" <? echo $this->ttip('Overide all Throttle Rules and set a MAX emails per day limit.<br><b>(0)</b> will disable.<br>The daily counter is reset automatically by CRON.'); ?> value="<? echo get_option('wpmm_setting_throttle_max_emails'); ?>" /><br />
Throttle Notifications<br />
<label class="switch">
  <input type="checkbox" <? if (get_option('wpmm_throttle_notifications') == 'on') { ?>checked<? } ?> id="wpmm_nset" class="ttip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Send admin notifications when throttle detected.">
  <span class="slider"></span>
</label><br />
<label for="data[setting_throttle_max_persec]">X seconds between emails</label><br />
<input disabled="disabled" type="text" id="data[setting_throttle_max_persec]" name="data[setting_throttle_max_persec]" placeholder="0" style="width:50%" <? echo $this->ttip('Overide all Throttle Rules and require <b>X</b> seconds between each mail sent.<br><b>(0)</b> will disable this feature.<br>*NOT AVAILABLE IN THIS VERSION*'); ?> value="<? echo get_option('wpmm_setting_throttle_max_persec'); ?>" /><br />
<label for="data[max_logs]">Max error log entries</label><br />
<input disabled="disabled" type="text" id="data[setting_max_logs]" name="data[setting_max_logs]" placeholder="0" style="width:50%" <? echo $this->ttip('Delete FAILED logs after <strong>X</strong> amount. This cycles the error logs if there are too many but does not reset the error count.<br><b>(0)</b> will disable this feature and allow all logs.<br>You can use the Clear Logs function to reset the error count. *NOT AVAILABLE IN THIS VERSION *'); ?> value="<? echo get_option('wpmm_setting_max_logs'); ?>" /><br />

		</div>
    
	</div>
</div>
            <div class="el-license-active-btn">
                <?php wp_nonce_field( 'wpmm' ); ?>
                <?php submit_button('Save Settings'); ?>
            </div>
</form>
	<?
	}
}
class wpmmMailLogs{

	function ViewLogs(){
		$fpath = plugin_dir_path( __FILE__ ).'mail-log.log';
		if(file_exists($fpath)) {
		_e('LOGS class under construction.');
		} else {
?>
<div class="notice notice-success"> 
	<p><strong><? _e('No error logs to display. So far, so good!'); ?></strong></p>
</div>
<br />
 <ul class="el-license-info">
                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("File Location",$this->slug);?></span>
                        <?php echo plugin_dir_path( __FILE__ ).'mail-log.log'; ?>
                    </div>
                </li>
</ul>
<?
		}
		
	}
}
class WPMailMon {
    public $plugin_file=__FILE__;
    public $responseObj;
    public $licenseMessage;
    public $showMessage=false;
	public $doneMessage=false;
    public $slug="wpmailmon";
    public $slug_settings="wpmailmon_settings";
    public $slug_throttle="wpmailmon_throttle";

  function __construct() {
        add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
		if(class_exists('WPMailMonPro')){
        $licenseKey=get_option("WPMailMon_lic_Key","");
        $liceEmail=get_option( "WPMailMon_lic_email","");

		if(class_exists('WPMailMonPro')){		
        WPMailMonBase::addOnDelete(function(){
           delete_option("WPMailMon_lic_Key");
        });
		}
		}
			add_action('activate_wpmailmon/wpmailmon.php', [$this,'wpmmInstall']);
			add_action('deactivate_wpmailmon/wpmailmon.php', [$this,'wpmmUninstall']);
			add_action( 'plugins_loaded', [$this,'update_db_check'] );
		if(class_exists('WPMailMonPro')){
        if(WPMailMonBase::CheckWPPlugin($licenseKey,$liceEmail,$this->licenseMessage,$this->responseObj,__FILE__)){
add_action('wp_dashboard_setup', [$this, 'wpmm_dashboard_widgets']);
			add_filter( 'cron_schedules', [$this,'add_schedule'] ); 
            add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);

            add_action( 'admin_post_WPMailMon_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
			add_action( 'admin_post_WPMailMon_el_test_email', [ $this, 'action_test_email' ] );
			add_action( 'admin_post_WPMailMon_save_settings', [ $this, 'action_save_settings' ] );
			add_action('admin_post_WPMailMon_add_rule', [$this, 'WPMailMon_add_rule']);
			add_action( 'admin_enqueue_scripts', [$this,'wpmm_admin_scripts'] );
            //$this->licenselMessage=$this->mess;
            //***Write you plugin's code here***
			add_action( 'wpmm_cron_hook_min', [$this,'cron_exec_min']);
			
			if ( ! wp_next_scheduled( 'wpmm_cron_hook_min' ) ) {
    wp_schedule_event( time(), 'throttle_min', 'wpmm_cron_hook_min' );
}
			add_action( 'wpmm_cron_hook_hour', [$this,'cron_exec_hour']);
			
			if ( ! wp_next_scheduled( 'wpmm_cron_hook_hour' ) ) {
    wp_schedule_event( time(), 'throttle_hour', 'wpmm_cron_hook_hour' );
}
			add_action( 'wpmm_cron_hook_day', [$this,'cron_exec_day']);
			if($this->check_mail_throttle()){
			add_action( 'admin_notices', [$this,'throttle_notice'] );
			}

			if ( ! wp_next_scheduled( 'wpmm_cron_hook_day' ) ) {
    wp_schedule_event( time(), 'throttle_day', 'wpmm_cron_hook_day' );
}

			add_action('wp_ajax_wpmm_admin_clearlogs', [$this, 'wpmm_admin_clearlogs'] );
			add_action('wp_ajax_wpmm_admin_deletelog', [$this, 'wpmm_admin_deletelog'] );
			add_action('wp_ajax_wpmm_admin_clearthrottle', [$this, 'wpmm_admin_clearthrottle'] );
			add_action('wp_ajax_wpmm_admin_automon', [$this, 'wpmm_admin_automon']);
			add_action('wp_ajax_wpmm_toggle_rulestate', [$this, 'wpmm_toggle_rulestate']);

			add_action('wp_ajax_toggle_setting', [$this,'toggle_Setting']);
			add_action( 'wp_mail_failed', [$this,'wpmmMailError'], 10, 1 );
			add_filter('wp_mail',[$this,'wpmmMailFilter'], 10,1);
			add_action('phpmailer_init', [$this,'wpmmMailInit']);
add_action( 'plugins_loaded', function () {
	SP_Plugin::get_instance();
} );

			//add_filter( 'plugin_row_meta', [$this, 'filter_plugin_row_meta'], 10, 4 );


        }else{
            if(!empty($licenseKey) && !empty($this->licenseMessage)){
               $this->showMessage=true;
            }
            update_option("WPMailMon_lic_Key","") || add_option("WPMailMon_lic_Key","");
            add_action( 'admin_post_WPMailMon_el_activate_license', [ $this, 'action_activate_license' ] );
            add_action( 'admin_menu', [$this,'InactiveMenu']);
        }
		} else {
		add_action('wp_dashboard_setup', [$this, 'wpmm_dashboard_widgets']);
			add_filter( 'cron_schedules', [$this,'add_schedule'] ); 
            add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);

            add_action( 'admin_post_WPMailMon_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
			add_action( 'admin_post_WPMailMon_el_test_email', [ $this, 'action_test_email' ] );
			add_action( 'admin_post_WPMailMon_save_settings', [ $this, 'action_save_settings' ] );
			add_action('admin_post_WPMailMon_add_rule', [$this, 'WPMailMon_add_rule']);
			add_action( 'admin_enqueue_scripts', [$this,'wpmm_admin_scripts'] );
            //$this->licenselMessage=$this->mess;
            //***Write you plugin's code here***
			add_action( 'wpmm_cron_hook_min', [$this,'cron_exec_min']);
			
			if ( ! wp_next_scheduled( 'wpmm_cron_hook_min' ) ) {
    wp_schedule_event( time(), 'throttle_min', 'wpmm_cron_hook_min' );
}
			add_action( 'wpmm_cron_hook_hour', [$this,'cron_exec_hour']);
			
			if ( ! wp_next_scheduled( 'wpmm_cron_hook_hour' ) ) {
    wp_schedule_event( time(), 'throttle_hour', 'wpmm_cron_hook_hour' );
}
			add_action( 'wpmm_cron_hook_day', [$this,'cron_exec_day']);
			if($this->check_mail_throttle()){
			add_action( 'admin_notices', [$this,'throttle_notice'] );
			}

			if ( ! wp_next_scheduled( 'wpmm_cron_hook_day' ) ) {
    wp_schedule_event( time(), 'throttle_day', 'wpmm_cron_hook_day' );
}

			add_action('wp_ajax_wpmm_admin_clearlogs', [$this, 'wpmm_admin_clearlogs'] );
			add_action('wp_ajax_wpmm_admin_deletelog', [$this, 'wpmm_admin_deletelog'] );
			add_action('wp_ajax_wpmm_admin_clearthrottle', [$this, 'wpmm_admin_clearthrottle'] );
			add_action('wp_ajax_wpmm_admin_automon', [$this, 'wpmm_admin_automon']);
			add_action('wp_ajax_wpmm_toggle_rulestate', [$this, 'wpmm_toggle_rulestate']);

			add_action('wp_ajax_toggle_setting', [$this,'toggle_Setting']);
			add_action( 'wp_mail_failed', [$this,'wpmmMailError'], 10, 1 );
			add_filter('wp_mail',[$this,'wpmmMailFilter'], 10,1);
			add_action('phpmailer_init', [$this,'wpmmMailInit']);
add_action( 'plugins_loaded', function () {
	SP_Plugin::get_instance();
} );

			add_filter( 'plugin_row_meta', [$this, 'filter_plugin_row_meta'], 10, 4 );
			


		}
    }
function wpmm_dashboard_widgets() {
global $wp_meta_boxes;
wp_add_dashboard_widget('wpmm_widget', 'WPMailMon Monitor', [$this, 'wpmm_dashboard_mon']);
}
 
function wpmm_dashboard_mon() {
global $wpdb;

$table = $wpdb->prefix."WPMailMon_counters";
$min = $wpdb->get_var("SELECT throttle_counter_min from ".$table." where ID>0");
$hour = $wpdb->get_var("SELECT throttle_counter_hour from ".$table." where ID>0");
$day = $wpdb->get_var("SELECT throttle_counter_day from ".$table." where ID>0");
$errors = $wpdb->get_var("SELECT error_count from ".$table." where ID>0");
?>
<div id="jax_throttle_mon">
<div class="container" align="center">
    <div class="row">
        <div class="col-md-3">Per Min/<br /><h4><? echo $min; ?></h4></div>
        <div class="col-md-3">Per Hour/<br /><h4><? echo $hour; ?></h4></div>
        <div class="col-md-3">Today/<br /><h4><? echo $day; ?></h4></div>
        <div class="col-md-3">Errors/<br /><h4><? echo $errors; ?></h4></div>
    </div>
</div>
</div>
<?
}
	
function filter_plugin_row_meta( array $plugin_meta, $plugin_file ) {
	if ( 'wpmailmon/wpmailmon.php' !== $plugin_file ) {
		return $plugin_meta;
	}

	$plugin_meta[] = sprintf(
		'<a href="%1$s"><span class="dashicons dashicons-star-filled" aria-hidden="true" style="font-size:14px;line-height:1.3"></span>%2$s</a>',
		'https://gitcoded.co.uk/wpmailmon',
		esc_html_x( 'PRO Features', 'verb', 'wpmailmon' )
	);

	return $plugin_meta;
}

function wpmm_toggle_rulestate(){
global $wpdb;
$nonce = sanitize_text_field($_REQUEST['_wpnonce']);
			if ( ! wp_verify_nonce( $nonce, 'wpmm' ) ) {
				wp_die();
			}
		$id = !empty($_REQUEST['ruleid'])?sanitize_text_field($_REQUEST['ruleid']):0;
		$table = $wpdb->prefix."WPMailMon_throttle_rules";
		$sql = $wpdb->prepare("SELECT rule_active from ".$table." where ID=%d", $id);
		$state = $wpdb->get_var($sql);
		switch($state){
		case 1:
	$sql = $wpdb->prepare("update ".$table." set rule_active=0 where ID=%d", array(
		$id
	));

		$wpdb->query($sql);
		break;

		case 0:
	$sql = $wpdb->prepare("update ".$table." set rule_active=1 where ID=%d", array(
		$id
	));
		$wpdb->query($sql);
		break;
		}
wp_die();
}
function crcnt(){
global $wpdb;
		$table = $wpdb->prefix."WPMailMon_throttle_rules";
return $wpdb->get_var("SELECT COUNT(*) FROM $table where ID>0");
}
function WPMailMon_add_rule(){
	check_admin_referer( 'wpmm' );
	global $wpdb;
$data = $this->sanitize_text_or_array_field($_REQUEST['data']);

switch ($data['rule_type']){

		case "flood":
			if(empty($data['rule_expires'])){
				$rule_expires = 0;
			} else {
try {
$rule_expires = strtotime($data['rule_expires']);
}

//catch exception
catch(Exception $e) {
  $rule_expires = 0;
}
					
			}
		$rule_min = !empty($data['rule_min'])?$data['rule_min']:0;
		$rule_hour = !empty($data['rule_hour'])?$data['rule_hour']:0;
		$rule_day = !empty($data['rule_day'])?$data['rule_day']:0;
		$rule_maxerrors = !empty($data['rule_maxerrors'])?$data['rule_maxerrors']:0;
		$rule_title = !empty($data['rule_title'])?$data['rule_title']:'New rule';
			$error = NULL;
		if($rule_min == 0 && $rule_hour == 0 && $rule_day == 0 && $rule_maxerrors == 0){
		$error = "Your rule will have no effect if all set to zero/disabled.";
		}
		if($rule_expires<strtotime("now")){
		$rule_expires = 0;
		}

		if ($this->crcnt()>=3){
			$error = 'Free version only supports 3 throttle rules.';	
		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug_throttle.'&error='.$error));	
		}
		if($error){
		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug_throttle.'&error='.$error));
		} else {
	
		$rule_min = sanitize_text_field($rule_min);
		$rule_hour = sanitize_text_field($rule_hour);
		$rule_day = sanitize_text_field($rule_day);
		$rule_maxerrors = sanitize_text_field($rule_maxerrors);
		$rule_title = sanitize_text_field($rule_title);

		if($this->crcnt()<3) {
		$table = $wpdb->prefix."WPMailMon_throttle_rules";
	$sql = $wpdb->prepare("INSERT INTO ".$table." (rule_active, rule_title, rule_expires, rule_type, rule_min, rule_hour, rule_day, rule_maxerrors) VALUES (1, %s, %s, 'flood', %d, %d, %d, %d)", array(
		$rule_title,
		$rule_expires,
		$rule_min,
		$rule_hour,
		$rule_day,
		$rule_maxerrors
	));


		$wpdb->query($sql);
		}
		//create the rule and redirect...

	wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug_throttle));
		}

		break;

		case "time":
			if(empty($data['rule_expires'])){
				$rule_expires = 0;
			} else {
try {
$rule_expires = strtotime($data['rule_expires']);
}

//catch exception
catch(Exception $e) {
  $rule_expires = 0;
}
					
			}
		$time_hour_start = !empty($data['time_hour_start'])?$data['time_hour_start']:'00';
		$time_hour_finish = !empty($data['time_hour_end'])?$data['time_hour_end']:'00';
		$time_min_start = !empty($data['time_min_start'])?$data['time_min_start']:'00';
		$time_min_finish = !empty($data['time_min_end'])?$data['time_min_end']:'00';
		$rule_title = !empty($data['rule_title'])?$data['rule_title']:'New rule';

		$error = NULL;
		if($time_hour_start==$time_hour_finish && $time_min_start==$time_min_finish){
		//$error = "Your rule will have no effect if all set to zero/disabled.";
		}

		if ($this->crcnt()>=3){
			$error = 'Free version only supports 3 throttle rules.';	
		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug_throttle.'&error='.$error));	
		}
		
		if($rule_expires<strtotime("now")){
		$rule_expires = 0;
		}

		if($error){
		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug_throttle.'&error='.$error));
		} else {

		$time_hour_start = sanitize_text_field($time_hour_start);
		$time_hour_finish = sanitixe_text_field($time_hour_finish);
		$time_min_start = sanitize_text_field($time_min_start);
		$time_min_finish = sanitize_text_field($time_min_finish);
		$rule_title = sanitize_text_field($rule_title);

	if ($this->crcnt()<3){
		$table = $wpdb->prefix."WPMailMon_throttle_rules";

	$sql = $wpdb->prepare("INSERT INTO ".$table." (rule_active, rule_title, rule_expires, rule_type, time_hour_start, time_hour_end, time_min_start, time_min_end) VALUES (1, %s, %s, 'time', %s, %s, %s, %s)", array(

		$rule_title,
		$rule_expires,
		$time_hour_start,
		$time_hour_finish,
		$time_min_start,
		$time_min_finish

	));

		$wpdb->query($sql);
		}
		//create the rule and redirect...

		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug_throttle));
		}

		break;
}

}
function wpmm_admin_automon(){
	global $wpdb;
$table = $wpdb->prefix."WPMailMon_counters";
$min = $wpdb->get_var("SELECT throttle_counter_min from ".$table." where ID>0");
$hour = $wpdb->get_var("SELECT throttle_counter_hour from ".$table." where ID>0");
$day = $wpdb->get_var("SELECT throttle_counter_day from ".$table." where ID>0");
$errors = $wpdb->get_var("SELECT error_count from ".$table." where ID>0");
?>

<div class="container" align="center">
    <div class="row">
        <div class="col-md-3">Per Min/<br /><h4><? echo $min; ?></h4></div>
        <div class="col-md-3">Per Hour/<br /><h4><? echo $hour; ?></h4></div>
        <div class="col-md-3">Today/<br /><h4><? echo $day; ?></h4></div>
        <div class="col-md-3">Errors/<br /><h4><? echo $errors; ?></h4></div>
    </div>
</div>
<?
	wp_die();
}
/**
 * Recursive sanitation for text or array
 * 
 * @param $array_or_string (array|string)
 * @since  0.1
 * @return mixed
 */
function sanitize_text_or_array_field($array_or_string) {
    if( is_string($array_or_string) ){
        $array_or_string = sanitize_text_field($array_or_string);
    }elseif( is_array($array_or_string) ){
        foreach ( $array_or_string as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = sanitize_text_or_array_field($value);
            }
            else {
                $value = sanitize_text_field( $value );
            }
        }
    }

    return $array_or_string;
}
function action_save_settings(){
	global $wpdb;	
	check_admin_referer( 'wpmm' );
		$data = $this->sanitize_text_or_array_field($_REQUEST['data']);

//print_r($_REQUEST['data']);
		foreach( $data as $key => $value){

			$key = sanitize_text_field($key);
			$value = sanitize_text_field($value);
		
			if($key == 'setting_email_pass' && !empty($value)){
			//update password...
			$opt = 'wpmm_'.$key;
			update_option($opt, $value) || add_option($opt, $value);
			} else {
			
			if(!empty($value) || $value == '0'){
			//echo "<li>".$key." - ".$value."</li>";
			$opt = 'wpmm_'.$key;
			update_option($opt, $value) || add_option($opt, $value);
			}
			}
		}
		update_option('wpmm_settings', true) || add_option('wpmm_settings', true);
	wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug_settings.'&msg=Settings saved!'));

}
public static function ttip($txt){
return ' class="ttip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="'.$txt.'"';
}
function filesize_formatted($path)
{
if(file_exists($path)){

    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}  else {
return '0 KB';
}
}
	function wpmm_admin_clearthrottle(){
		check_admin_referer( 'wpmm' );
		global $wpdb;
		$table = $wpdb->prefix."WPMailMon_counters";
		$sql = 'UPDATE '.$table.' set throttle_counter_min=0, throttle_counter_hour=0, throttle_counter_day=0 where ID>0';
		$wpdb->query($sql);
		echo "Throttle counters reset.";
		wp_die();
	}

	function wpmm_admin_deletelog(){
		check_admin_referer( 'wpmm' );
		$fpath = plugin_dir_path( __FILE__ ).'mail-log.log';

		if(file_exists($fpath)):
		unlink($fpath);
		echo "Removed - ".$fpath;
		wp_die();
		endif;


		echo "No log file to remove.";

		wp_die();
	}	
	function wpmm_admin_clearlogs(){
		check_admin_referer( 'wpmm' );
		global $wpdb;
		$table = $wpdb->prefix."WPMailMon_LOGS";
		$sql = 'DELETE FROM '.$table.' where ID>0';
		$wpdb->query($sql);

		$table = $wpdb->prefix."WPMailMon_counters";
		$sql = 'UPDATE '.$table.' set error_count=0 where ID>0';
		$wpdb->query($sql);

		echo "Removed All Logs. Refreshing page....";

		wp_die();
	}
	function cron_exec_min(){
		global $wpdb;
	$table = $wpdb->prefix."WPMailMon_counters";
$wpdb->query("UPDATE $table set throttle_counter_min=0 WHERE ID=1");
			
	}
	
	function cron_exec_hour(){
		global $wpdb;
	$table = $wpdb->prefix."WPMailMon_counters";
$wpdb->query("UPDATE $table set throttle_counter_hour=0 WHERE ID=1");		
	}
	
	function cron_exec_day(){
		global $wpdb;
	$table = $wpdb->prefix."WPMailMon_counters";
$wpdb->query("UPDATE $table set throttle_counter_day=0 WHERE ID=1");

$wpdb->query("UPDATE $table set todays_count=0 WHERE ID=1");
		
		
	}
		function getCurrentVersion(){
			if( !function_exists('get_plugin_data') ){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$data=get_plugin_data($this->plugin_file);
			if(isset($data['Version'])){
				return $data['Version'];
			}
			return 0;
		}
	function add_schedule($schedules){
	  $schedules['throttle_min'] = array(
    'interval' => 60,
    'display' => __( 'Throttle MIN', $this->slug)
  );
  
  $schedules['throttle_hour'] = array(
    'interval' => 60 * 60,
    'display' => __( 'Throttle HOUR', $this->slug )
  );
  
   $schedules['throttle_day'] = array(
    'interval' => 60 * 60 * 24,
    'display' => __( 'Throttle DAILY', $this->slug )
  );

  return $schedules;	
	}
	
function toggle_setting(){
	global $wpdb;

//	add_option('wpmm_email_logging', 'off');
//	add_option('wpmm_throttle_protection', 'off');

$config_setting = sanitize_text_field($_REQUEST['setting']) ?? null;

if($config_setting){
	$current_setting = get_option($config_setting);
		if($current_setting == 'off'){
		update_option($config_setting, 'on') || add_option($config_setting, 'on');
		}
		if($current_setting == 'on'){
		update_option($config_setting, 'off') || add_option($config_setting, 'off');
		}
		if(!$current_setting){
		update_option($config_setting, 'off') || add_option($config_setting, 'off');
		}
}
	

	wp_die();

}
function update_db_check() {
	global $wpdb;
	$current = get_option('wpmm_version_check');
	$new = $this->getCurrentVersion();
    if ($current != $new) {
		//changes for new version.....

$subject = 'WPMailMon - Upgrade Completed';
$body = 'Your application WPMailMon has been upgraded to Version: '.$new;
if(get_option('wpmm_setting_email_header') == 'html'){
$headers = array('Content-Type: text/html; charset=UTF-8');
}
$to = get_bloginfo( 'admin_email' );
$msg = wp_mail( $to, $subject, $body, $headers );

		update_option('wpmm_version_check', $new);
    }
}


function check_mail_throttle($phpmailer = NULL){
$last_trigger = '';
$notifiaction = '';
global $wpdb;
$throttle = false;
$table = $wpdb->prefix."WPMailMon_counters";
$error_count = $wpdb->get_var("SELECT error_count from ".$table." where ID>0");
$error_set = get_option('wpmm_setting_throttle_max_errors');
$sent_today = $wpdb->get_var("SELECT throttle_counter_day from ".$table." where ID>0");
$max_daily = get_option('wpmm_setting_throttle_max_emails');

if(get_option('wpmm_throttle_protection') == 'on'){

		//detect PHP mailer function and check new PERSEC feature....
		
		//check forced error limi
		if($error_set>0 && $error_count>0){
		if($error_count>=$error_set){
			$throttle = array();
			$throttle['error_code'] = 'FMAXERR';
			$throttle['error_time'] = strtotime("now");
			$throttle['error_message'] = 'Too many errors, sending blocked.';
if($last_trigger<$notification){
$throttle['error_notify'] = true;
}
			return $throttle;
			exit;

		}

		}
		//check forced email limit
		if(($sent_today>$max_daily || $sent_today==$max_daily) && $max_daily>0){
			$throttle['error_code'] = 'FMAXDAY';
			$throttle['error_time'] = strtotime("now");
			$throttle['error_message'] = 'Daily limit reached, sending blocked.';
if($last_trigger<$notification){
$throttle['error_notify'] = true;
}
			return $throttle;
			exit;
		}

		//check flood conditions
		// check the current state our counts are in and if they exceed
		// an active rule that is valid and non expired....
		// $error_count, $sent_today, $error_count
$table = $wpdb->prefix."WPMailMon_counters";
$error_count = $wpdb->get_var("SELECT error_count from ".$table." where ID>0");

		$sent_min = $wpdb->get_var("SELECT throttle_counter_min from ".$table." where ID>0");
		$sent_hour = $wpdb->get_var("SELECT throttle_counter_hour from ".$table." where ID>0");
		$table = $wpdb->prefix."WPMailMon_throttle_rules";

		$sql = $wpdb->prepare("SELECT * FROM ".$table." where rule_active=1 and rule_type = 'flood' and (rule_expires=0 OR rule_expires>%s) and (rule_min>=%s or rule_min=0) and (rule_hour>=%s or rule_hour=0) and (rule_day>=%s or rule_day=0) and (rule_maxerrors<=%s or rule_maxerrors=0)", array(
		strtotime("now"),
		$sent_min,
		$sent_hour,
		$sent_today,
		$error_count
		));
		$db = $wpdb->get_results($sql);

			foreach($db as $rec){
		$e = NULL;
				//get the reason why

			if($sent_today>=$rec->rule_day && $rec->rule_day>0){
				$e = 'Too many today';
			}
			if($sent_hour>=$rec->rule_hour && $rec->rule_hour>0){
				$e = 'Too many per hour';
			}
			if($sent_min>=$rec->rule_min && $rec->rule_min>0){
				$e = 'Too many per minute';
			}
			if($error_count>=$rec->rule_maxerrors && $rec->rule_maxerrors>0){
				$e = 'Too many errors';
			}
			if(!empty($e)){
			$e .= ' ('.$rec->rule_title.')';
			$throttle['error_code'] = 'FUSRRULE:'.$rec->ID;
			$throttle['error_time'] = strtotime("now");
			$throttle['error_message'] = $e;
			return $throttle;
			exit;
			}
			}

		//check time rule condition

		$now = new DateTime();

		//if ($now >= $begin && $now <= $end)

		$sql = $wpdb->prepare("SELECT * FROM ".$table." where rule_active=1 and rule_type = 'time' and (rule_expires=0 or rule_expires > %s)", strtotime("now"));
		$db = $wpdb->get_results($sql);

		foreach($db as $rec){

		//ALL DAY EVENTS

		$b = $rec->time_hour_start.":".$rec->time_min_start;
		$e = $rec->time_hour_end.":".$rec->time_min_end;

		$begin = new DateTime($b);
		$end = new DateTime($e);


			if ($now >= $begin && $now <= $end){
				//triggered TIME event....

			$throttle['error_code'] = 'FUSRRULE:'.$rec->ID;
			$throttle['error_time'] = strtotime("now");
			$throttle['error_message'] = 'Cannot send mail during this time period. ('.$rec->rule_title.')';
			$throttle['error_class'] = 'time';
			return $throttle;
			exit;

			}

		}

		
		//update the last triggered DB IF not been updated in last X hours...(last_send)
		//email site admin if we update a new trigger fail....
}

return $throttle;
}
function screen_option() {

		$option = 'per_page';
		$args   = [
			'label'   => 'Logs Per Page',
			'default' => 5,
			'option'  => 'logs_per_page'
		];

		add_screen_option( $option, $args );

		$this->customers_obj = new WPMMLogs_List();
		
	}
function screen_option_throttle() {

		$option = 'per_page';
		$args   = [
			'label'   => 'Rules Per Page',
			'default' => 5,
			'option'  => 'rules_per_page'
		];

		add_screen_option( $option, $args );

		$this->customers_obj = new WPMMThrottle_List();
		
	}

function action_test_email(){
global $wpdb;
check_admin_referer( 'el-license' );

if(is_email(sanitize_email($_REQUEST['email_address']))){
$to = sanitize_email($_REQUEST['email_address']);
}

$eid = uniqid();
$subject = 'WPMailMon test email ['.$eid.']';
$body = 'The email has sent successfully.';
if(get_option('wpmm_setting_email_header') == 'html'){
$headers = array('Content-Type: text/html; charset=UTF-8');
}
$headers = !empty($headers)?$headers:'';
if($to){
$msg = wp_mail( $to, $subject, $body, $headers );
}
if($msg){
wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug.'&s=success'));
} else {
if($to){
wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug.'&s=error&eid='.$eid));
} else {
if(!is_email(sanitize_email($_REQUEST['email_address']))){
wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug.'&s=error_mail'));
} else {
wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug.'&s=error'));
}
}
}


}
function throttle_notice() {
$throttle = $this->check_mail_throttle();
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'WPMailMon Throttle Protection is blocking outgoing mail. <br> - Error Code: [<b>'.$throttle['error_code'].'</b>] - '.$throttle['error_message'].'<br>Check WPMailMon Logs For More Information.', $this->slug ); ?></p>
    </div>
    <?php
}
function wpmmMailInit($phpmailer) {
global $wpdb;

//check for THROTTLE and cancel

//check if we have SMTP settings

/*
	delete_option('wpmm_setting_email_host');
	delete_option('wpmm_setting_email_user');
	delete_option('wpmm_setting_email_pass');
	delete_option('wpmm_setting_email_security');
	delete_option('wpmm_setting_email_port');
*/
if(get_option('wpmm_setting_smtp_auth') == 'on'){
$phpmailer->isSMTP(); 

$phpmailer->Host = get_option('wpmm_setting_email_host');
$phpmailer->SMTPAuth = true;
$phpmailer->Username = get_option('wpmm_setting_email_user');
$phpmailer->Password = get_option('wpmm_setting_email_pass');
$phpmailer->SMTPSecure = get_option('wpmm_setting_email_security');
$phpmailer->Port = get_option('wpmm_setting_email_port');
}                   



$throttle = $this->check_mail_throttle($phpmailer);

if(!$throttle){
		//update counters
$table = $wpdb->prefix."WPMailMon_counters";
$wpdb->query("UPDATE $table set todays_count=todays_count + 1, throttle_counter_min=throttle_counter_min +1, throttle_counter_hour=throttle_counter_hour + 1, throttle_counter_day=throttle_counter_day + 1 WHERE ID=1");
}

if($throttle){
    $phpmailer->clearAllRecipients();
    $phpmailer->clearAttachments();
    $phpmailer->clearCustomHeaders();
    $phpmailer->clearReplyTos();

$table = $wpdb->prefix."WPMailMon_counters";
$last_trigger = $wpdb->get_var("SELECT last_send from ".$table." where ID>0");
$notification = strtotime("-1 hour");

$eclass = !empty($throttle['error_class'])?$throttle['error_class']:false;
if($last_trigger<$notification){
if (get_option('wpmm_throttle_notifications') == 'on') {
$sql = $wpdb->prepare("UPDATE ".$table." set last_send = %s where ID>0", strtotime("now"));

$wpdb->query($sql);

if(get_option('wpmm_setting_email_header') == 'html'){

$headers = array('Content-Type: text/html; charset=UTF-8');

$msg = 'Hello Admin,<br><br>';
$msg .= 'WPMailMon protected outgoing mail on your WordPress site and blocked sending with the following error.<br><br>';
$msg .= 'Error Code: '.$throttle['error_code'];
$msg .= '<br>Error Message: '.$throttle['error_message'];

} else {
$msg = 'Hello Admin,\n';
$msg .= 'WPMailMon protected outgoing mail on your WordPress site and blocked sending with the following error.\n\n';
$msg .= 'Error Code: '.$throttle['error_code'];
$msg .= '\nError Message: '.$throttle['error_message'];
}


$headers = !empty($headers)?$headers:'';

$this->wpmm_mail(get_bloginfo('admin_email'), 'WPMailMon Throttle Alert.', $msg, $headers );
//new #slack notifications.....
if(class_exists('WPMailMonPro')){
$msg = 'Hello Admin, ';
$msg .= 'WPMailMon protected outgoing mail on your WordPress site and blocked sending with the following error. :: ';
$msg .= 'Error Code: '.$throttle['error_code'];
$msg .= ' Error Message: '.$throttle['error_message'];

		WPMailMonPro::slack_notification($msg);
}
}
}

}
//set admin_notify back to zero....

}
function wpmmMailError( $wp_error ) {
global $wpdb;
		//update counters
$table = $wpdb->prefix."WPMailMon_counters";
$wpdb->query("UPDATE $table set error_count=error_count + 1 WHERE ID=1");

$table = $wpdb->prefix."WPMailMon_LOGS";

$throttle = $this->check_mail_throttle();


if(!$throttle){
$fpath = plugin_dir_path( __FILE__ ).'mail-log.log';
$data = $wp_error;
error_log(print_r($data, true), 3, $fpath);
}

foreach($wp_error->errors as $eid => $edat){
	if($eid == 'wp_mail_failed'){
		foreach($edat as $e => $log){
			$error_log = $log;
		}
	}
}
$eid = "";
$edat = "";

foreach($wp_error->error_data as $eid => $edat){
	if($eid == 'wp_mail_failed'){
		foreach($edat as $errid => $errdat){
			if($errid == 'headers'){
				foreach($errdat as $hid => $hval){
					//echo "<li>".$hid." - ".$hval."</li>";
					$error_ID = $hval;
				}
			}
		}
	}
}
if ($error_ID){
		//can record into DB.....
$sql = $wpdb->prepare("SELECT * FROM $table where message_id = %s", $error_ID);

$db = $wpdb->get_results($sql);

foreach($db as $mail){
if($mail->mail_errors == 'Throttled'){
if($throttle){
$error_log = '['.$throttle['error_code'].'] '.$throttle['error_message'];
} else {

}
} 

}
		$sql = $wpdb->prepare("update $table set mail_status = 'Failed', mail_errors = %s where message_id = %s", array(
		$error_log,
		$error_ID
		));

		$wpdb->query($sql);
}

}
function wpmm_mail( $to, $subject, $message, $headers = '', $attachments = array() ) {
    // Compact the input, apply the filters, and extract them back out.
 
    /**
     * Filters the wp_mail() arguments.
     *
     * @since 2.2.0
     *
     * @param array $args A compacted array of wp_mail() arguments, including the "to" email,
     *                    subject, message, headers, and attachments values.
     */
    $atts = compact( 'to', 'subject', 'message', 'headers', 'attachments' );
 
    if ( isset( $atts['to'] ) ) {
        $to = $atts['to'];
    }
 
    if ( ! is_array( $to ) ) {
        $to = explode( ',', $to );
    }
 
    if ( isset( $atts['subject'] ) ) {
        $subject = $atts['subject'];
    }
 
    if ( isset( $atts['message'] ) ) {
        $message = $atts['message'];
    }
 
    if ( isset( $atts['headers'] ) ) {
        $headers = $atts['headers'];
    }
 
    if ( isset( $atts['attachments'] ) ) {
        $attachments = $atts['attachments'];
    }
 
    if ( ! is_array( $attachments ) ) {
        $attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );
    }
    global $wpmailer;
 
    // (Re)create it, if it's gone missing.
    if ( ! ( $wpmailer instanceof PHPMailer\PHPMailer\PHPMailer ) ) {
        require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
        require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
        require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
        $wpmailer = new PHPMailer\PHPMailer\PHPMailer( true );
 
        $wpmailer::$validator = static function ( $email ) {
            return (bool) is_email( $email );
        };
    }
 
    // Headers.
    $cc       = array();
    $bcc      = array();
    $reply_to = array();
 
    if ( empty( $headers ) ) {
        $headers = array();
    } else {
        if ( ! is_array( $headers ) ) {
            // Explode the headers out, so this function can take
            // both string headers and an array of headers.
            $tempheaders = explode( "\n", str_replace( "\r\n", "\n", $headers ) );
        } else {
            $tempheaders = $headers;
        }
        $headers = array();
 
        // If it's actually got contents.
        if ( ! empty( $tempheaders ) ) {
            // Iterate through the raw headers.
            foreach ( (array) $tempheaders as $header ) {
                if ( strpos( $header, ':' ) === false ) {
                    if ( false !== stripos( $header, 'boundary=' ) ) {
                        $parts    = preg_split( '/boundary=/i', trim( $header ) );
                        $boundary = trim( str_replace( array( "'", '"' ), '', $parts[1] ) );
                    }
                    continue;
                }
                // Explode them out.
                list( $name, $content ) = explode( ':', trim( $header ), 2 );
 
                // Cleanup crew.
                $name    = trim( $name );
                $content = trim( $content );
 
                switch ( strtolower( $name ) ) {
                    // Mainly for legacy -- process a "From:" header if it's there.
                    case 'from':
                        $bracket_pos = strpos( $content, '<' );
                        if ( false !== $bracket_pos ) {
                            // Text before the bracketed email is the "From" name.
                            if ( $bracket_pos > 0 ) {
                                $from_name = substr( $content, 0, $bracket_pos - 1 );
                                $from_name = str_replace( '"', '', $from_name );
                                $from_name = trim( $from_name );
                            }
 
                            $from_email = substr( $content, $bracket_pos + 1 );
                            $from_email = str_replace( '>', '', $from_email );
                            $from_email = trim( $from_email );
 
                            // Avoid setting an empty $from_email.
                        } elseif ( '' !== trim( $content ) ) {
                            $from_email = trim( $content );
                        }
                        break;
                    case 'content-type':
                        if ( strpos( $content, ';' ) !== false ) {
                            list( $type, $charset_content ) = explode( ';', $content );
                            $content_type                   = trim( $type );
                            if ( false !== stripos( $charset_content, 'charset=' ) ) {
                                $charset = trim( str_replace( array( 'charset=', '"' ), '', $charset_content ) );
                            } elseif ( false !== stripos( $charset_content, 'boundary=' ) ) {
                                $boundary = trim( str_replace( array( 'BOUNDARY=', 'boundary=', '"' ), '', $charset_content ) );
                                $charset  = '';
                            }
 
                            // Avoid setting an empty $content_type.
                        } elseif ( '' !== trim( $content ) ) {
                            $content_type = trim( $content );
                        }
                        break;
                    case 'cc':
                        $cc = array_merge( (array) $cc, explode( ',', $content ) );
                        break;
                    case 'bcc':
                        $bcc = array_merge( (array) $bcc, explode( ',', $content ) );
                        break;
                    case 'reply-to':
                        $reply_to = array_merge( (array) $reply_to, explode( ',', $content ) );
                        break;
                    default:
                        // Add it to our grand headers array.
                        $headers[ trim( $name ) ] = trim( $content );
                        break;
                }
            }
        }
    }
 
    // Empty out the values that may be set.
    $wpmailer->clearAllRecipients();
    $wpmailer->clearAttachments();
    $wpmailer->clearCustomHeaders();
    $wpmailer->clearReplyTos();
 
    // Set "From" name and email.
 
    // If we don't have a name from the input headers.
    if ( ! isset( $from_name ) ) {
        $from_name = 'WordPress';
    }
 
    /*
     * If we don't have an email from the input headers, default to wordpress@$sitename
     * Some hosts will block outgoing mail from this address if it doesn't exist,
     * but there's no easy alternative. Defaulting to admin_email might appear to be
     * another option, but some hosts may refuse to relay mail from an unknown domain.
     * See https://core.trac.wordpress.org/ticket/5007.
     */
    if ( ! isset( $from_email ) ) {
        // Get the site domain and get rid of www.
        $sitename = wp_parse_url( network_home_url(), PHP_URL_HOST );
        if ( 'www.' === substr( $sitename, 0, 4 ) ) {
            $sitename = substr( $sitename, 4 );
        }
 
        $from_email = 'wordpress@' . $sitename;
    }
 
    /**
     * Filters the email address to send from.
     *
     * @since 2.2.0
     *
     * @param string $from_email Email address to send from.
     */
    $from_email = $from_email;
 
    /**
     * Filters the name to associate with the "from" email address.
     *
     * @since 2.3.0
     *
     * @param string $from_name Name associated with the "from" email address.
     */
    $from_name = $from_name ;
 
    try {
        $wpmailer->setFrom( $from_email, $from_name, false );
    } catch ( PHPMailer\PHPMailer\Exception $e ) {
        $mail_error_data                             = compact( 'to', 'subject', 'message', 'headers', 'attachments' );
        $mail_error_data['phpmailer_exception_code'] = $e->getCode();
 
        /** This filter is documented in wp-includes/pluggable.php */
       // do_action( 'wp_mail_failed', new WP_Error( 'wp_mail_failed', $e->getMessage(), $mail_error_data ) );
 
        return false;
    }
 
    // Set mail's subject and body.
    $wpmailer->Subject = $subject;
    $wpmailer->Body    = $message;
 
    // Set destination addresses, using appropriate methods for handling addresses.
    $address_headers = compact( 'to', 'cc', 'bcc', 'reply_to' );
 
    foreach ( $address_headers as $address_header => $addresses ) {
        if ( empty( $addresses ) ) {
            continue;
        }
 
        foreach ( (array) $addresses as $address ) {
            try {
                // Break $recipient into name and address parts if in the format "Foo <bar@baz.com>".
                $recipient_name = '';
 
                if ( preg_match( '/(.*)<(.+)>/', $address, $matches ) ) {
                    if ( count( $matches ) == 3 ) {
                        $recipient_name = $matches[1];
                        $address        = $matches[2];
                    }
                }
 
                switch ( $address_header ) {
                    case 'to':
                        $wpmailer->addAddress( $address, $recipient_name );
                        break;
                    case 'cc':
                        $wpmailer->addCc( $address, $recipient_name );
                        break;
                    case 'bcc':
                        $wpmailer->addBcc( $address, $recipient_name );
                        break;
                    case 'reply_to':
                        $wpmailer->addReplyTo( $address, $recipient_name );
                        break;
                }
            } catch ( PHPMailer\PHPMailer\Exception $e ) {
                continue;
            }
        }
    }
 
    // Set to use PHP's mail().
    $wpmailer->isMail();
 
    // Set Content-Type and charset.
 
    // If we don't have a content-type from the input headers.
    if ( ! isset( $content_type ) ) {
        $content_type = 'text/plain';
    }
 
    /**
     * Filters the wp_mail() content type.
     *
     * @since 2.3.0
     *
     * @param string $content_type Default wp_mail() content type.
     */
    $content_type = $content_type;
 
    $wpmailer->ContentType = $content_type;
 
    // Set whether it's plaintext, depending on $content_type.
    if ( 'text/html' === $content_type ) {
        $wpmailer->isHTML( true );
    }
 
    // If we don't have a charset from the input headers.
    if ( ! isset( $charset ) ) {
        $charset = get_bloginfo( 'charset' );
    }
 
    /**
     * Filters the default wp_mail() charset.
     *
     * @since 2.3.0
     *
     * @param string $charset Default email charset.
     */
    $wpmailer->CharSet = $charset ;
 
    // Set custom headers.
    if ( ! empty( $headers ) ) {
        foreach ( (array) $headers as $name => $content ) {
            // Only add custom headers not added automatically by PHPMailer.
            if ( ! in_array( $name, array( 'MIME-Version', 'X-Mailer' ), true ) ) {
                try {
                    $wpmailer->addCustomHeader( sprintf( '%1$s: %2$s', $name, $content ) );
                } catch ( PHPMailer\PHPMailer\Exception $e ) {
                    continue;
                }
            }
        }
 
        if ( false !== stripos( $content_type, 'multipart' ) && ! empty( $boundary ) ) {
            $wpmailer->addCustomHeader( sprintf( 'Content-Type: %s; boundary="%s"', $content_type, $boundary ) );
        }
    }
 
    if ( ! empty( $attachments ) ) {
        foreach ( $attachments as $attachment ) {
            try {
                $wpmailer->addAttachment( $attachment );
            } catch ( PHPMailer\PHPMailer\Exception $e ) {
                continue;
            }
        }
    }
 
 
    // Send!
    try {
        return $wpmailer->send();
    } catch ( PHPMailer\PHPMailer\Exception $e ) {
 
        $mail_error_data                             = compact( 'to', 'subject', 'message', 'headers', 'attachments' );
        $mail_error_data['phpmailer_exception_code'] = $e->getCode();
 
        return false;
    }
}
function wpmmMailFilter($args){
global $wpdb;
    //$args['to'];
    //$args['subject']
    //$args['message']='';
    //$args['headers']
    //$args['attachments']

//check for THROTTLE
$throttle = $this->check_mail_throttle();

if($throttle){

	//add our tracking header
	$eid = strtotime("now").'-'.uniqid();

	$headers = array();
	if($args['headers']){
	
	foreach($args['headers'] as $hid => $h){
		array_push($headers, $h);
	
	}
	}
	array_push($headers, 'WP-EID: ' . $eid);
    $args['headers'] = $headers;

	//record log to DB
	$table = $wpdb->prefix."WPMailMon_LOGS";

	$sql = $wpdb->prepare("INSERT INTO $table (etime, mail_status, mail_subject, mail_body, mail_errors, mail_to, message_id) VALUES (%s, 'Failed', %s, %s, 'Throttled', %s, %s)", array(
		strtotime("now"),
		$args['subject'],
		$args['message'],
		$args['to'],
		$eid
		));

	$wpdb->query($sql);

} else {
	//add our tracking header
	$eid = strtotime("now").'-'.uniqid();
	$headers = array();
	if($args['headers']){
	
	foreach($args['headers'] as $hid => $h){
		array_push($headers, $h);
	
	}
	}
	array_push($headers, 'WP-EID: ' . $eid);
    $args['headers'] = $headers;

}

    return $args;


//SMTP CONFIG DETAILS

//CHECK THROTTLING

// INSERT DB LOG

}

function wpmmInstall(){
global $wpdb;
	$table = $wpdb->prefix."WPMailMon_LOGS";
    $structure = "CREATE TABLE $table (
        ID INT(9) NOT NULL AUTO_INCREMENT,
        UNIQUE KEY ID (id), etime VARCHAR(100), mail_status VARCHAR(50), mail_subject LONGTEXT, mail_body LONGTEXT, mail_errors LONGTEXT DEFAULT NULL, mail_to VARCHAR(200), message_id VARCHAR(100)
    );";
    $wpdb->query($structure);

	$table = $wpdb->prefix."WPMailMon_counters";
	$structure = "CREATE TABLE $table (ID INT(9) NOT NULL AUTO_INCREMENT, UNIQUE KEY ID (id), todays_count INT(9) DEFAULT 0, last_send VARCHAR(200) DEFAULT NULL, error_count INT(9) DEFAULT 0, throttle_counter_min INT(9) DEFAULT 0, throttle_counter_hour INT(9) DEFAULT 0, throttle_counter_day INT(9) DEFAULT 0, last_wmail_sent VARCHAR(100) DEFAULT '0');";

	$wpdb->query($structure);

	$wpdb->query("INSERT INTO $table (todays_count) VALUES (0)");

	$table = $wpdb->prefix."WPMailMon_throttle_rules";

	$structure = "CREATE TABLE $table (ID INT(9) NOT NULL AUTO_INCREMENT, UNIQUE KEY ID (id), rule_active INT(9) DEFAULT 0, rule_title VARCHAR(200), rule_expires VARCHAR(100), rule_type SET('time','flood') NOT NULL, rule_min INT(9) DEFAULT 0, rule_hour INT(9) DEFAULT 0, rule_day INT(9) DEFAULT 0, time_hour_start VARCHAR(100) DEFAULT NULL, time_hour_end VARCHAR(100) DEFAULT NULL, time_min_start VARCHAR(100) DEFAULT NULL, time_min_end VARCHAR(100) DEFAULT NULL, rule_maxerrors INT(9) DEFAULT 0);";

	$wpdb->query($structure);


		//some default rooles

		//all day TIME event
	$sql = "INSERT INTO $table (rule_active, rule_title, rule_expires, rule_type, time_hour_start, time_min_start, time_hour_end, time_min_end) VALUES (0, 'All Day Blocked', '0', 'time', '00', '00', '23', '59')";
	$wpdb->query($sql);

if(class_exists('WPMailMonPro')) {
		//stop emails from 2AM to 5AM
		$expires = strtotime("+1 month");
	$sql = "INSERT INTO $table (rule_active, rule_title, rule_expires, rule_type, time_hour_start, time_min_start, time_hour_end, time_min_end) VALUES (0, 'Block from 2AM to 5AM', '$expires', 'time', '02', '00', '05', '00')";
	$wpdb->query($sql);
}
		// FLOOD rules on any errors over 
	$sql = "INSERT INTO $table (rule_active, rule_title, rule_expires, rule_type, rule_min, rule_hour, rule_day, rule_maxerrors) VALUES (0, 'No Emails After 3 Errors', '0', 'flood', 0, 0, 0, 3)";
	$wpdb->query($sql);
		//FLOOD rules 10 emails per minute
	$sql = "INSERT INTO $table (rule_active, rule_title, rule_expires, rule_type, rule_min, rule_hour, rule_day, rule_maxerrors) VALUES (0, 'Flooding 10 per minute limit.', '0', 'flood', 10, 0, 0, 0)";
	$wpdb->query($sql);
if(class_exists('WPMailMonPro')) {
		//FLOOD RULES 100 PER HOUR
	$sql = "INSERT INTO $table (rule_active, rule_title, rule_expires, rule_type, rule_min, rule_hour, rule_day, rule_maxerrors) VALUES (0, 'Flooding 100 per hour limit.', '0', 'flood', 0, 100, 0, 0)";
	$wpdb->query($sql);
		//flood rules 500 DAULY
	$sql = "INSERT INTO $table (rule_active, rule_title, rule_expires, rule_type, rule_min, rule_hour, rule_day, rule_maxerrors) VALUES (0, 'Flooding 500 per day MAX!', '0', 'flood', 0, 0, 500, 0)";
	$wpdb->query($sql);
}

	add_option('wpmm_version_check', $this->getCurrentVersion());
	add_option('wpmm_email_logging', 'off');
	add_option('wpmm_throttle_protection', 'off');
	add_option('wpmm_settings', false);
	add_option('wpmm_setting_throttle_max_errors', 0);
	add_option('wpmm_setting_throttle_max_emails', 0);
	add_option('wpmm_throttle_notifications', 'on');
	add_option('wpmm_setting_throttle_max_persec', 0);
	add_option('wpmm_setting_max_logs', 0);
	add_option('wpmm_setting_email_header', 'plaintext');
	add_option('wpmm_setting_smtp_auth', 'off');
}
function wpmmUninstall(){
global $wpdb;
	$table = $wpdb->prefix."WPMailMon_LOGS";
	$structure = "DROP TABLE $table";
	$wpdb->query($structure);

	$table = $wpdb->prefix."WPMailMon_counters";
	$structure = "DROP TABLE $table";
	$wpdb->query($structure);

	$table = $wpdb->prefix."WPMailMon_throttle_rules";
	$structure = "DROP TABLE $table";
	$wpdb->query($structure);

 	delete_option("WPMailMon_lic_Key");
	delete_option('wpmm_version_check');
	delete_option('wpmm_throttle_protection');
	delete_option('wpmm_email_logging');
	delete_option('wpmm_settings');
	delete_option('wpmm_setting_throttle_max_errors');
	delete_option('wpmm_setting_throttle_max_emails');
	delete_option('wpmm_setting_email_host');
	delete_option('wpmm_setting_email_user');
	delete_option('wpmm_setting_email_pass');
	delete_option('wpmm_setting_email_security');
	delete_option('wpmm_setting_email_port');
	delete_option('wpmm_throttle_notifications');
	delete_option('wpmm_setting_throttle_max_persec');
	delete_option('wpmm_setting_max_logs');
	delete_option('wpmm_setting_email_header');
	delete_option('wpmm_setting_smtp_auth');
	delete_option('wpmm_setting_slack_url');
	$timestamp = wp_next_scheduled( 'wpmm_cron_hook_min' );
wp_unschedule_event( $timestamp, 'wpmm_cron_hook_min' );
	$timestamp = wp_next_scheduled( 'wpmm_cron_hook_hour' );
wp_unschedule_event( $timestamp, 'wpmm_cron_hook_hour' );
	$timestamp = wp_next_scheduled( 'wpmm_cron_hook_day' );
wp_unschedule_event( $timestamp, 'wpmm_cron_hook_day' );

}
function wpmm_admin_scripts($hook){
wp_register_style('wpmm-css', plugins_url('/custom.css', __FILE__ ));
wp_enqueue_style('wpmm-css');
wp_register_style('bstrap-css', plugins_url('assets/bootstrap/css/bootstrap.min.css', __FILE__ ));
wp_enqueue_style('bstrap-css');
wp_enqueue_script( 'wpmm-jsp', plugins_url('/popper.js', __FILE__ ), array(), '', true );
wp_enqueue_script( 'wpmm-bs', plugins_url('assets/bootstrap/js/bootstrap.min.js', __FILE__ ), array(), '', true );  
wp_enqueue_script( 'wpmm-js', plugins_url('/custom.js', __FILE__ ), array(), '', true ); 
wp_localize_script( 'wpmm-js', 'wpmm', array(
    // URL to wp-admin/admin-ajax.php to process the request
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    // generate a nonce with a unique ID "myajax-post-comment-nonce"
    // so that you can check it later when an AJAX request is sent
    'nonce' => wp_create_nonce( 'wpmm' )
//
  ));


}
	function Throttle_Rules(){
?>
<!-- new throttleMOD -->
   <div class="el-license-container">
<?
if(!empty(sanitize_text_field($_REQUEST['error']))):
?>
    <div class="notice notice-info is-dismissible">
        <p><?php _e( sanitize_text_field($_REQUEST['error']), $this->slug ); ?></p>
    </div>
    
<? endif; ?>
                <h3 class="el-license-title"><i class="dashicons-before dashicons-performance"></i> <?php _e("Throttle Rules",$this->slug);?> </h3>
                <hr>
<?
$this->customers_obj->prepare_items();
$this->customers_obj->display();
?>
            </div><br />
   <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-plus"></i> <?php _e("Add Rule",$this->slug);?> </h3>
                <hr>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="WPMailMon_add_rule"/>
<div class="container">
    <div class="row">
        <div class="col-md-6"><h4>Details</h4>
Title/Description<br />
			<input type="text" id="data[rule_title]" name="data[rule_title]" placeholder="Title, Name Or Description" style="width:100%;" <? echo $this->ttip('Give your new rule a name or title to describe its purpose'); ?> /><br />
Expires<br />
			<input type="text" id="data[rule_expires]" name="data[rule_expires]" placeholder="Expiry Date" class="custom_date ttip" style="width:30%;" <? echo $this->ttip('Choose an expiry date or leave field blank for no expiry.'); ?> /><br />
Rule Type<br />
<select id="data[rule_type]" class="schange ttip" name="data[rule_type]" style="width:30%;" <? echo $this->ttip('<b>Flood:</b> Choose flooding rules per minute, hour and day and block emails exceeding these rules.<br><br><b>Time:</b> Restrict emails being sent during certain time frames.', 'schange'); ?>>
<option value="flood">Flood Throttle</option>
<option value="time">Time Restriction</option>
</select><br />

		</div>
        <div class="col-md-6"><h4>Settings</h4>
<div id="form_frame_flood">
Max Emails Per Minute?<br />
			<input type="number" id="data[rule_min]" name="data[rule_min]" value="0" style="width:100%;" <? echo $this->ttip('Set the maximum allowed emails per minute.<br><b>(0)</b> will disable this restriction.'); ?> min="0" /><br />
Max Emails Per Hour?<br />
			<input type="number" id="data[rule_hour]" name="data[rule_hour]" value="0" style="width:100%;" <? echo $this->ttip('Set the maximum allowed emails per hour.<br><b>(0)</b> will disable this restriction.'); ?> min="0" /><br />
Max Emails Per Day?<br />
			<input type="number" id="data[rule_day]" name="data[rule_day]" value="0" style="width:100%;" <? echo $this->ttip('Set the maximum allowed emails per minute.<br><b>(0)</b> will disable this restriction.'); ?> min="0" /><br />
<?
if (get_option('wpmm_setting_throttle_max_emails')>0){
?>
<strong>Note:</strong> Admin settings overide this rule with <strong><? echo get_option('wpmm_setting_throttle_max_emails'); ?></strong> Max Email / Daily.<br />
<?
}
?>
Max Error Limit?<br />
			<input type="number" id="data[rule_maxerrors]" name="data[rule_maxerrors]" value="0" style="width:100%;" <? echo $this->ttip('Number of errors allowed when sending mail. Once this is reached mail will be stopped.<br><b>(0)</b> will disable this restriction.'); ?> /><br />
<?
if (get_option('wpmm_setting_throttle_max_errors')>0){
?>
<strong>Note:</strong> Admin settings overide this rule with <strong><? echo get_option('wpmm_setting_throttle_max_errors'); ?></strong> Max Errors.
<?
}
?>

</div>
<div id="form_frame_time" style="display:none;">
<div class="note">
Restrict <b>ALL</b> outgoing email during these time periods. This does not protect against the flood rules it simply stops all outgoing email.
</div><br />
Start Time<br />
<div class="container">
    <div class="row">
        <div class="col-md-6">
			<input type="text" id="data[time_hour_start]" name="data[time_hour_start]" value="<? echo date("H"); ?>" style="width:25%;" <? echo $this->ttip('The Start Hour in 24hr format 00-23.'); ?> />
</div>
        <div class="col-md-6">
			<input type="text" id="data[time_min_start]" name="data[time_min_start]" value="<? echo date("i"); ?>" style="width:25%;" <? echo $this->ttip('The Start Minute in 24hr format 00-59.'); ?> />
</div>
    </div>
</div><br />
End Time<br />
<div class="container">
    <div class="row">
        <div class="col-md-6">
			<input type="text" id="data[time_hour_end]" name="data[time_hour_end]" value="<? echo date("H"); ?>" style="width:25%;" <? echo $this->ttip('The End Hour in 24hr format 00-23.'); ?> />
</div>
        <div class="col-md-6">
			<input type="text" id="data[time_min_end]" name="data[time_min_end]" value="<? echo date("i"); ?>" style="width:25%;" <? echo $this->ttip('The End Minute in 24hr format 00-59.'); ?> />
</div>
    </div>
</div>

</div>

		</div>
    </div>
</div>
                <div class="el-license-active-btn">
                    <?php wp_nonce_field( 'wpmm' ); ?>
                    <?php submit_button('Add New Rule'); ?>
                </div>
</form>
            </div>
<?
	}
    function SetAdminStyle() {
        wp_register_style( "WPMailMonLic", plugins_url("_lic_style.css",$this->plugin_file),10);
wp_enqueue_script('jquery-ui-datepicker');  
wp_enqueue_style('jquery-ui-css', plugins_url("jquery-ui.css",$this->plugin_file));    
wp_enqueue_style( "WPMailMonLic" );

    }
    function ActiveAdminMenu(){
		$hook = add_menu_page (  "WPMailMon", "WPMailMon", "activate_plugins", $this->slug, [$this,"Activated"], plugins_url('/images/shield.png', __FILE__));

		add_action( "load-$hook", [ $this, 'screen_option' ] );
		//add_menu_page (  "WPMailMon", "WPMailMon", "activate_plugins", $this->slug, [$this,"Activated"], " dashicons-star-filled ");
		$hook = add_submenu_page(  $this->slug, "WPMailMon Throttle Rules", "Throttle Rules", "activate_plugins",  $this->slug."_throttle", [$this,"Throttle_Rules"] );
		add_action( "load-$hook", [ $this, 'screen_option_throttle' ] );
		$hook = add_submenu_page(  $this->slug, "WPMailMon Settings", "Settings", "activate_plugins",  $this->slug."_settings", [$this,"admin_settings"] );
		//add_action( "load-$hook", [ $this, 'screen_option_throttle' ] );

    }

	function admin_settings(){
	global $wpdb;
if(class_exists('wpmmAdminSetPro')){
$adminSet = new wpmmAdminSetPro(empty($wpmm));
} else {
$adminSet = new wpmmAdminSet(empty($wpmm));
}
?>

   <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-admin-generic"></i> <?php _e("Settings",$this->slug);?> </h3>
                <hr>
<? $adminSet->settings(); ?>
            </div>
<?
	}

    function InactiveMenu() {
        add_menu_page( "WPMailMon", "WPMailMon", 'activate_plugins', $this->slug,  [$this,"LicenseForm"], plugins_url('/images/shield.png', __FILE__) );

    }
    function action_activate_license(){
        check_admin_referer( 'el-license' );
        $licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
        $licenseEmail=!empty($_POST['el_license_email'])?$_POST['el_license_email']:"";
        update_option("WPMailMon_lic_Key",$licenseKey) || add_option("WPMailMon_lic_Key",$licenseKey);
        update_option("WPMailMon_lic_email",$licenseEmail) || add_option("WPMailMon_lic_email",$licenseEmail);
        update_option('_site_transient_update_plugins','');
		
        wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }
    function action_deactivate_license() {
        check_admin_referer( 'el-license' );
        $message="";
        if(WPMailMonBase::RemoveLicenseKey(__FILE__,$message)){
            update_option("WPMailMon_lic_Key","") || add_option("WPMailMon_lic_Key","");
            update_option('_site_transient_update_plugins','');
        }
        wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
			$timestamp = wp_next_scheduled( 'wpmm_cron_hook_min' );
wp_unschedule_event( $timestamp, 'wpmm_cron_hook_min' );
	$timestamp = wp_next_scheduled( 'wpmm_cron_hook_hour' );
wp_unschedule_event( $timestamp, 'wpmm_cron_hook_hour' );
	$timestamp = wp_next_scheduled( 'wpmm_cron_hook_day' );
wp_unschedule_event( $timestamp, 'wpmm_cron_hook_day' );
    }
    function Activated(){
//test mail
global $wpdb;

$table = $wpdb->prefix."WPMailMon_counters";
$e_count = $wpdb->get_var("SELECT throttle_counter_day FROM $table WHERE ID=1");
$err_count = $wpdb->get_var("SELECT error_count FROM $table WHERE ID=1");
?>
            <div class="el-license-container">
<?
if(!empty(sanitize_text_field($_REQUEST['msg']))):
?>
    <div class="notice notice-info is-dismissible">
        <p><?php _e( sanitize_text_field($_REQUEST['msg']), $this->slug ); ?></p>
    </div>
    
<? endif; ?>
                <h3 class="el-license-title"><img src="<?php echo esc_url(plugins_url('/images/shield.png', __FILE__)); ?>" /> <?php _e("WPMailMon",$this->slug);?> </h3>

                <hr>
<div class="notice notice-success" id="set_saved" style="display:none;"> 
	<p><strong><span id="jax_msg"><? _e('Setting Changed!'); ?></span></strong></p>
</div>
<div>
    <div class="container">
        <div class="row">
            <div class="col-md-3" style="margin:auto;">

			</div>
            <div class="col-md-3" style="margin:auto;">
<label class="switch">
  <input type="checkbox" <? if (get_option('wpmm_throttle_protection') == 'on') { ?>checked<? } ?> id="wpmm_tset">
  <span class="slider"></span>
</label>
Throttle Protection
	`		</div>
            <div class="col-md-3" align="center">
	<h2><? _e($e_count); ?></h2>Emails Sent Today
			</div>
            <div class="col-md-3" align="center">
	<h2><? _e($err_count); ?></h2>Recent Errors
			</div>
        </div>
    </div>
</div>

<hr />
<div class="container">
    <div class="row">
        <div class="col-md-6">        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="WPMailMon_el_test_email"/>
<input type="text" placeholder="some@email.com" style="width:100%;" id="email_address" name="email_address" required="required" />
                    <?php wp_nonce_field( 'el-license' ); ?>
                    <?php submit_button('Send Test Email', 'wpmm'); ?>
</form>
            <?php
			$e =!empty(sanitize_text_field($_REQUEST['s']))?sanitize_text_field($_REQUEST['s']):'';
            if($e == 'success'){
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php echo _e('Email Message Sent',$this->slug); ?></p>
                </div>
                <?php
            }
            ?>
            <?php
$e = !empty(sanitize_text_field($_REQUEST['s']))?sanitize_text_field($_REQUEST['s']):'';
            if($e == 'error_mail'){
                ?>
                <div class="notice notice-warn is-dismissible">
                    <p><?php echo _e('Please choose a valid email address.',$this->slug); ?></p>
                </div>
                <?php
            }
            ?>
            <?php
			$e =!empty(sanitize_text_field($_REQUEST['s']))?sanitize_text_field($_REQUEST['s']):'';
            if($e == 'error'){
			if(sanitize_text_field($_REQUEST['eid'])){
					$table = $wpdb->prefix."WPMailMon_LOGS";
		$eid = sanitize_text_field($_REQUEST['eid']);
		$sql = "SELECT mail_errors from $table where mail_subject like '%".$eid."%'";

				$var = $wpdb->get_var($sql);
				} else {
				$var = "Check log files or try again.";
				}
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo _e('Email Sending FAILED! - '.$var,$this->slug); ?></p>
                </div>
                <?php
            }
            ?></div>
        <div class="col-md-6">
<?php 
$attributes = array( 'id' => 'wpmm_admin_clearlogs' );
submit_button('Clear Logs', 'wpmm', '', false, $attributes); 
?>&nbsp;
<?php 
$fpath = plugin_dir_path( __FILE__ ).'mail-log.log';
$title = 'Delete Log File ['.$this->filesize_formatted($fpath).']';
$attributes = array( 'id' => 'wpmm_admin_deletelog' );
submit_button($title, 'wpmm', '', false, $attributes); 
?>&nbsp;
<?php 
$attributes = array( 'id' => 'wpmm_admin_clearthrottle' );
submit_button('Clear Throttle', 'wpmm', '', false, $attributes);
 ?>
</div>
    </div>
</div>
</div>

<!-- new throttleMOD -->
   <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-performance"></i> <?php _e("Throttle Monitor",$this->slug);?> </h3>
                <hr>
<?
$throttle = $this->check_mail_throttle();
if($throttle && get_option('wpmm_throttle_protection') == 'on'){

switch ($throttle['error_code']) {
//$this->ttip('Overide all Throttle Rules and set a MAX emails per day limit.<br><b>(0)</b> will disable.<br>The daily counter is reset automatically by CRON.'
case "FMAXERR":
$span = $this->ttip('<b>FMAXERR - </b> This is set in settings, maximum errors allowed before blocking mail. You can clear the error count by Clearing Logs.<br>This setting overides all throttle rules but can be disabled by setting it to <b>(0)</b>.');
?>
    <div class="notice notice-warning">
        <p><?php _e( 'WPMailMon Throttle Protection is blocking outgoing mail. <br> - Error Code: [<b><span '.$span.'>'.$throttle['error_code'].'</b></span>] - '.$throttle['error_message'].'<br>Check WPMailMon Logs For More Information.', $this->slug ); ?></p>
    </div>
<?
break;

case "FMAXDAY":
$span = $this->ttip('<b>FMAXDAY - </b> This is set in settings, maximum allowed emails to be sent per day. CRON resets this counter daily, or you can Clear Throttle.<br>This setting overides all throttle rules but can be set to <b>(0)</b> to disable.');
?>
    <div class="notice notice-warning">
        <p><?php _e( 'WPMailMon Throttle Protection is blocking outgoing mail. <br> - Error Code: [<b><span '.$span.'>'.$throttle['error_code'].'</b></span>] - '.$throttle['error_message'].'<br>Check WPMailMon Logs For More Information.', $this->slug ); ?></p>
    </div>
<?

break;

default:
?>
    <div class="notice notice-warning">
        <p><?php _e( 'WPMailMon Throttle Protection is blocking outgoing mail. <br> - Error Code: [<b>'.$throttle['error_code'].'</b>] - '.$throttle['error_message'].'<br>Check WPMailMon Logs For More Information.', $this->slug ); ?></p>
    </div>
 <?php
	break;
}

}
else {
?>
    <div class="notice notice-info">
        <p><?php _e( 'All mail functions are operating normally and flowing as usual.', $this->slug ); ?></p>
    </div>
<?
}
$table = $wpdb->prefix."WPMailMon_counters";
$min = $wpdb->get_var("SELECT throttle_counter_min from ".$table." where ID>0");
$hour = $wpdb->get_var("SELECT throttle_counter_hour from ".$table." where ID>0");
$day = $wpdb->get_var("SELECT throttle_counter_day from ".$table." where ID>0");
$errors = $wpdb->get_var("SELECT error_count from ".$table." where ID>0");
?>
<hr />
<div id="jax_throttle_mon">
<div class="container" align="center">
    <div class="row">
        <div class="col-md-3">Per Min/<br /><h4><? echo $min; ?></h4></div>
        <div class="col-md-3">Per Hour/<br /><h4><? echo $hour; ?></h4></div>
        <div class="col-md-3">Today/<br /><h4><? echo $day; ?></h4></div>
        <div class="col-md-3">Errors/<br /><h4><? echo $errors; ?></h4></div>
    </div>
</div>
</div>

            </div>

<!-- New table container -->

   <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-format-status"></i> <?php _e("Mail Logs",$this->slug);?> </h3>
<strong>Note:</strong> The free version will only log errors.
<hr />
<?
$this->customers_obj->prepare_items();
$this->customers_obj->display();
?>

            </div>
    <?php
    }

    function LicenseForm() {
        ?>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="WPMailMon_el_activate_license"/>
        <div class="el-license-container">
            <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("WPMailMon Licensing",$this->slug);?></h3>
            <hr>
            <?php
            if(!empty($this->showMessage) && !empty($this->licenseMessage)){
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo _e($this->licenseMessage,$this->slug); ?></p>
                </div>
                <?php
            }
            ?>
            <p><?php _e("Enter your license key here, to activate the product, and get full feature updates and premium support.",$this->slug);?></p>
<ol>
    <li><?php _e("Write your licnese key details",$this->slug);?></li>
    <li><?php _e("How buyer will get this license key?",$this->slug);?></li>
    <li><?php _e("Describe other info about licensing if required",$this->slug);?></li>
    <li>. ...</li>
</ol>
            <div class="el-license-field">
                <label for="el_license_key"><?php _e("License code",$this->slug);?></label>
                <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
            </div>
            <div class="el-license-field">
                <label for="el_license_key"><?php _e("Email Address",$this->slug);?></label>
                <?php
                    $purchaseEmail   = get_option( "WPMailMon_lic_email", get_bloginfo( 'admin_email' ));
                ?>
                <input type="text" class="regular-text code" name="el_license_email" size="50" value="<?php echo $purchaseEmail; ?>" placeholder="" required="required">
                <div><small><?php _e("We will send update news of this product by this email address, don't worry, we hate spam",$this->slug);?></small></div>
            </div>

            <div class="el-license-active-btn">
                <?php wp_nonce_field( 'el-license' ); ?>
                <?php submit_button('Activate'); ?>
            </div>
        </div>
    </form>
        <?php
    }
}

class WPMMLogs_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Log', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Logs', 'sp' ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );

	}


	/**
	 * Retrieve customers data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_customers( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}WPMailMon_LOGS";

		$ob = sanitize_text_field($_REQUEST['orderby']);
		$o = sanitize_text_field($_REQUEST['order']);

		if ( ! empty( $ob ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $ob );
			$sql .= ! empty( $o ) ? ' ' . esc_sql( $o ) : ' ASC';
		} else {
			$sql .= ' ORDER BY etime desc';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}


	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function resend_customer( $id ) {
		if(class_exists('WPMailMonPro')){
		global $wpdb;
			//new feature to read log and resend mail
			//delete this log at same timw....

		//sendmail....
		$table = $wpdb->prefix."WPMailMon_LOGS";
		$sql = $wpdb->prepare("SELECT * FROM ".$table." where ID=%d", $id);
		$db = $wpdb->get_results($sql);
		foreach($db as $rec){

$subject = $rec->mail_subject;
$body = $rec->mail_body;
if(get_option('wpmm_setting_email_header') == 'html'){
$headers = array('Content-Type: text/html; charset=UTF-8');
}
$to = $rec->mail_to;
$msg = wp_mail( $to, $subject, $body, $headers );
		}

		$wpdb->delete(
			"{$wpdb->prefix}WPMailMon_LOGS",
			[ 'ID' => $id ],
			[ '%d' ]
		);
}

	}

	public static function delete_customer( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}WPMailMon_LOGS",
			[ 'ID' => $id ],
			[ '%d' ]
		);
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}WPMailMon_LOGS";

		return $wpdb->get_var( $sql );
	}


	/** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'No logs available.', 'sp' );
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'address':
			//case 'etime':
				//return self::column_name($item);
			default:
				return $item[ $column_name ];
				//return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */


	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
		function column_mail_errors($item){
			if($item['mail_errors'] <> ''){
				$title = $item['mail_errors'];
			} else {
				$title = '-';
			}
			return $title;
		}

		function column_mail_status($item){
			if($item['mail_status'] <> 'Sent'){
				$title = '<strong><font color="orange">'.$item['mail_status'].'</font></strong>';
			} else {
				$title = '<strong><font color="green">'.$item['mail_status'].'</font></strong>';
			}
			return $title;
		}
	function column_etime($item){
		$title = date("Y-m-d H:i:s A", $item['etime']);
		return $title;
	
	}
	function column_message_id( $item ) {

		$delete_nonce = wp_create_nonce( 'sp_delete_customer' );

		$title = '<strong>' . $item['message_id'] . '</strong>';

		if($item['mail_status'] == 'Failed'){
		if(class_exists('WPMailMonPro')){
		$actions = [
			'delete' => sprintf( '<a href="?page=%s&action=%s&log=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce ),
			'resend' => sprintf( '<a href="?page=%s&action=%s&log=%s&_wpnonce=%s">Resend</a>', esc_attr( $_REQUEST['page'] ), 'resend', absint( $item['ID'] ), $delete_nonce )
		];
		} else {
		$actions = [
			'delete' => sprintf( '<a href="?page=%s&action=%s&log=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
		];
		}


} else {
		$actions = [
			'delete' => sprintf( '<a href="?page=%s&action=%s&log=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
		];

}
		return $title . $this->row_actions( $actions );
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'message_id' => __( 'Message ID', 'sp' ),
			'etime'    => __( 'Date/Time', 'sp' ),
			'mail_status'    => __( 'Status', 'sp' ),
			'mail_to'    => __( 'Mail To', 'sp' ),
			'mail_subject'    => __( 'Subject', 'sp' ),
			'mail_errors'    => __( 'Errors', 'sp' )
		];

		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'etime' => array( 'etime', true ),
			'mail_status' => array( 'mail_status', false )
		);

		return $sortable_columns;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'logs_per_page', 5 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_customers( $per_page, $current_page );
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'resend' === $this->current_action() && class_exists('WPMailMonPro') ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::resend_customer( absint( $_GET['log'] ) );

		                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		                // add_query_arg() return the current url
		                //wp_redirect( esc_url_raw(add_query_arg()) );
				//exit;
			}

		}

		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_customer( absint( $_GET['log'] ) );

		                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		                // add_query_arg() return the current url
		                //wp_redirect( esc_url_raw(add_query_arg()) );
				//exit;
			}

		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_customer( $id );

			}

			// esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		        // add_query_arg() return the current url
		        wp_redirect( esc_url_raw(add_query_arg()) );
			exit;
		}
	}

}
class WPMMThrottle_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Rule', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Rule(s)', 'sp' ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );

	}


	/**
	 * Retrieve customers data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_rules( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}WPMailMon_throttle_rules";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		} else {
			$sql .= ' ORDER BY ID desc';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}


	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function delete_rule( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}WPMailMon_throttle_rules",
			[ 'ID' => $id ],
			[ '%d' ]
		);
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}WPMailMon_throttle_rules";

		return $wpdb->get_var( $sql );
	}


	/** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'No rules set.', 'sp' );
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'address':
			//case 'etime':
				//return self::column_name($item);
			default:
				return $item[ $column_name ];
				//return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}


	function get_columns() {
		$columns = [
			'rule_title'    => __( 'Title', 'sp' ),
			'rule_active'    => __( 'Status', 'sp' ),
			'rule_expires'    => __( 'Expiry', 'sp' ),
			'rule_type'    => __( 'Type', 'sp' ),
			'col_opts'    => __( 'Rule Arguments', 'sp' )
		];

		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'rule_active' => array( 'rule_active', false )
		);

		return $sortable_columns;
	}
		function column_rule_title($item){
		$delete_nonce = wp_create_nonce( 'sp_delete_customer' );

		$title = '<strong>' . $item['rule_title'] . ' (ID: '.$item['ID'].')</strong>';

		$actions = [
			'delete' => sprintf( '<a href="?page=%s&action=%s&rule=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
		];

		return $title . $this->row_actions( $actions );
		}
		function column_rule_active($item){
		if($item['rule_active'] == 1){
		?>
<label class="switch">
  <input type="checkbox" id="" checked="checked" onchange="toggleRuleState(<? echo $item['ID']; ?>);">
  <span class="slider"></span>
</label>
		<?
		} else {
		?>
<label class="switch">
  <input type="checkbox" id="" onchange="toggleRuleState(<? echo $item['ID']; ?>);">
  <span class="slider"></span>
</label>
		<?
		}

		}
		function column_rule_expires($item){
		if($item['rule_expires']<1){
		return "<b>Never</b>";
		} else {
		if($item['rule_expires']<strtotime("now")){
return '<font color="#CC0000"><b>'.date("d-m-Y H:i", $item['rule_expires']).'</b></font>';
		} else {
return date("d-m-Y H:i", $item['rule_expires']);
		}
		
		}

		}

		function column_rule_type($item){

		switch ($item['rule_type']){
		case "flood":
		//$t = new WPMailMon();
		$t = new WPMailMon();
		$ttip = $t->ttip('This is a <b>FLOOD</b> protection rule.');
		$img = '<img src="'.plugins_url('/images/email.png', __FILE__).'"'.$ttip.' width="32">';
		break;

		case "time":
		$t = new WPMailMon();
		$ttip = $t->ttip('This is a <b>TIME</b> restriction rule.');
		$img = '<img src="'.plugins_url('/images/time.png', __FILE__).'"'.$ttip.' width="32">';
		break;
		}

		return $img;
		}

		function column_col_opts($item){
		switch($item['rule_type']){
		
		case "flood":
		$min = $item['rule_min'];
		$hour = $item['rule_hour'];
		$day = $item['rule_day'];
		$maxerrors = $item['rule_maxerrors'];
		

		if($min == 0){
$ttip = WPMailMon::ttip('Unlimited/Disabled');
		$min = '<span'.$ttip.'>UL</span>';
		$min = '<img src="'.plugins_url('/images/disabled.png', __FILE__).'" '.$ttip.'>';
		} else {
		$ttip = WPMailMon::ttip('<b>'.$min.'</b> max email per minute.');
		$min = '<span'.$ttip.'>'.$min.'</span>';
}
		if($hour == 0){
$ttip = WPMailMon::ttip('Unlimited/Disabled');
		$hour = '<span'.$ttip.'>UL</span>';
		$hour = '<img src="'.plugins_url('/images/disabled.png', __FILE__).'" '.$ttip.'>';
		} else {
		$ttip = WPMailMon::ttip('<b>'.$hour.'</b> max emails per hour.');
		$hour = '<span'.$ttip.'>'.$hour.'</span>';
}
		if($day == 0){
$ttip = WPMailMon::ttip('Unlimited/Disabled');
		$day = '<span'.$ttip.'>UL</span>';
		$day = '<img src="'.plugins_url('/images/disabled.png', __FILE__).'" '.$ttip.'>';
		} else {
		$ttip = WPMailMon::ttip('<b>'.$day.'</b> max emails per day.');
		$day = '<span'.$ttip.'>'.$day.'</span>';
}
		if($maxerrors == 0){
$ttip = WPMailMon::ttip('Unlimited/Disabled');
		$maxerrors = '<span'.$ttip.'>UL</span>';
		$maxerrors = '<img src="'.plugins_url('/images/disabled.png', __FILE__).'" '.$ttip.'>';
		} else {
		$ttip = WPMailMon::ttip('<b>'.$maxerrors.'</b> errors allowed before blocking mail.');
		$maxerrors = '<span'.$ttip.'>'.$maxerrors.'</span>';
}

		?>
<div class="container">
    <div class="row" align="center">
        <div class="col-md-3"><strong><? echo $min; ?></strong></div>
        <div class="col-md-3"><strong><? echo $hour; ?></strong></div>
        <div class="col-md-3"><strong><? echo $day; ?></strong></div>
        <div class="col-md-3"><b><? echo $maxerrors; ?></b></div>
    </div>
    <div class="row">
        <div class="col-md-3">/Min</div>
        <div class="col-md-3">/Hour</div>
        <div class="col-md-3">/Day</div>
        <div class="col-md-3">Errors</div>
    </div>
</div>

		<?
		break;

		case "time":
		?>
<div class="container" align="center">
<strong>Start Hour/Min</strong>
    <div class="row">
        <div class="col-md-4" align="right"><? echo $item['time_hour_start']; ?></div>
        <div class="col-md-4"><strong>:</strong></div>
        <div class="col-md-4" align="left"><? echo $item['time_min_start']; ?></div>
    </div>
<strong>End Hour/Min</strong>
    <div class="row">
        <div class="col-md-4" align="right"><? echo $item['time_hour_end']; ?></div>
        <div class="col-md-4"><strong>:</strong></div>
        <div class="col-md-4" align="left"><? echo $item['time_min_end']; ?></div>
    </div>
</div>		<?
		break;
		
		}
			//return $title;
		}

	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'rules_per_page', 5 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_rules( $per_page, $current_page );
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_rule( absint( $_GET['rule'] ) );

		                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		                // add_query_arg() return the current url
		                //wp_redirect( esc_url_raw(add_query_arg()) );
				//exit;
			}

		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_rule( $id );

			}

			// esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		        // add_query_arg() return the current url
		        wp_redirect( esc_url_raw(add_query_arg()) );
			exit;
		}
	}

}
class SP_Plugin {

	// class instance
	static $instance;
	// customer WP_List_Table object
	public $customers_obj;
	public $rules_obj;
	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		//add_action( 'admin_menu', [ $this, 'plugin_menu' ] );
	}


	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	/** Singleton instance */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
if(class_exists('WPMailMonPro')){
new WPMailMonPro();
} else {
new WPMailMon();
}