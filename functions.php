<?php
/**
 * @package WordPress
 * @subpackage Sweetdate
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Sweetdate 1.0
 */


/**
 * Sweetdate Child Theme Functions
 * Add extra code or replace existing functions
*/ 

add_action('after_setup_theme','kleo_my_actions');
 
function kleo_my_actions() 
{
   /* disable matching on member profile */
    remove_action('kleo_bp_before_profile_name', 'kleo_bp_compatibility_match');      
 
    /* Replace the heart over images */
    add_filter('kleo_img_rounded_icon', 'my_custom_icon');
 
    /* Replace the heart from register modal */
    add_filter('kleo_register_button_icon', 'my_custom_icon_register');
 
    /* Replace the heart from About us widget */
    add_filter('kleo_widget_aboutus_icon', 'my_custom_icon_about_widget');
}
 
/* Replace the heart with a camera icon function */
function my_custom_icon () {
    return 'camera';
}
 
/* Replace the heart from register modal with a user icon function */
function my_custom_icon_register () {
    return 'user';
}
/* Replace the heart from about us widget with a user icon function */
function my_custom_icon_about_widget () {
    return 'user';
}


// register custom scripts
function lala_register_js() { 
    if (!is_admin()) { 
        wp_register_script('lala_functions', get_stylesheet_directory_uri() . '/js/functions.js', 'app',true,true);
        wp_enqueue_script('lala_functions');

        wp_register_style( 'lala_fontello',get_stylesheet_directory_uri() . '/css/fontello.css' );
		wp_enqueue_style( 'lala_fontello' );
    }
}
add_action('wp_enqueue_scripts', 'lala_register_js',99);


function kleo_is_user_online($user_id, $time=5)
{
	global $wpdb;
	$sql = $wpdb->prepare( "
		SELECT u.user_login FROM $wpdb->users u JOIN $wpdb->usermeta um ON um.user_id = u.ID
		WHERE u.ID = %d
		AND um.meta_key = 'last_activity'
		AND DATE_ADD( um.meta_value, INTERVAL %d MINUTE ) >= UTC_TIMESTAMP()", $user_id, $time);
	$user_login = $wpdb->get_var( $sql );
	if(isset($user_login) && $user_login !=""){
		return true;
	}
	else {return false;}
}


add_action('bp_members_meta', 'kleo_online_status');
function kleo_online_status() {
	if (kleo_is_user_online(bp_get_member_user_id())) {
		echo "Online"; 
	} else { 
		echo "Offline"; 
	}
}


//Redirect only guests to register page
add_filter('kleo_pmpro_url_redirect', 'kleo_my_custom_guest_redirect');

function kleo_my_custom_guest_redirect($redirect)
{
	if (!is_user_logged_in()){
		return home_url().'/register';
	}
	else
	{
		return $redirect;
	}
}


// cometchat support
add_action('wp_footer', 'lala_head_cometchat',2);
function lala_head_cometchat(){
?>
	<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">	
	<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
<?php	
}


	add_filter('pre_user_display_name', 'lala_pre_user_display_name_pro');
 	

	function lala_pre_user_display_name_pro($nickname){

		if( isset($_POST['user_id']) && bp_get_profile_field_data('field=1047&user_id='.$_POST['user_id'] ) == 'Real Estate Pro'){
			// if user is 'Real estate PRO' we will add ' PRO' at the end of display name
			$subject = "abcdef";
			$pattern = '/PRO$/';
			preg_match($pattern, $nickname, $matches);

			if( !(isset($matches[0]) && 'PRO' == $matches[0]) ){
				$nickname = $nickname.' PRO';
			}

				
		}

		return $nickname;
		
	} 

	add_action('kleo_bp_after_profile_image', 'lala_pro_badge');

	function lala_pro_badge(){
		 
        if(bp_get_profile_field_data('field=1047&user_id='.bp_displayed_user_id() ) == 'Real Estate Pro'){
            $badge_class = 'real-estate-pro-badge';
    ?>	
    		<div class="pro-badge">
    			<i class="fticon-ok-circled2"></i>
    			Verified Real Estate Pro
    		</div>
    		<!-- <img class='pro-badge' src="<?php echo get_stylesheet_directory_uri().'/images/pro_badge_blue.png';  ?>" > -->
    <?php        
        }
            
	}

	// over write parent funtion 

	function kleo_bp_member_buttons() 
    {
    ?>
    
	<div class="two columns pull-two">
		<div id="item-buttons">
		<?php if (!is_user_logged_in()) :?>
			<?php if ( bp_is_active( 'friends' ) ): ?>
			<div id="friendship-button-<?php bp_displayed_user_id(); ?>" class="generic-button friendship-button not_friends">
					<a data-reveal-id="login_panel" class="has-tip tip-right friendship-button not_friends add" data-width="350" rel="add" id="friend-<?php bp_displayed_user_id(); ?>" title="<?php _e("Please Login to Add Friend", 'kleo_framework');?>" href="#"><?php _e("Add Friend",'kleo_framework');?></a>
			</div>
			<?php endif; ?>
			<?php if ( bp_is_active( 'activity' ) ): ?>
			<div id="post-mention" class="generic-button">
					<a data-reveal-id="login_panel" class="has-tip tip-right activity-button mention" data-width="350" title="<?php _e("Please Login to Send a public message", 'kleo_framework');?>" href="#"><?php _e("Public Message", 'kleo_framework');?></a>
			</div>
			<?php endif; ?>
			<?php if ( bp_is_active( 'messages' ) ): ?>
			<div id="send-private-message" class="generic-button">
					<a data-reveal-id="login_panel" class="has-tip tip-right send-message" data-width="350" title="<?php _e("Please Login to Send a private message", 'kleo_framework');?>" href="#"><?php _e("Private Message", 'kleo_framework');?></a>
			</div>
			<?php endif; ?>
		<?php else : ?>
				<?php do_action( 'bp_member_header_actions' ); ?>
		<?php endif; ?>
			<div id="chat-with-me" class="generic-button">
				<a class="chat-with-me" href="javascript:void(0)" onclick="javascript:jqcc.cometchat.chatWith('<?php echo bp_displayed_user_id(); ?>');">Chat with me</a>
			</div>

		</div><!-- #item-buttons -->
	</div>
    <?php 
    }

?>