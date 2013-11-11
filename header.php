<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->

<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/styles/font-awesome-ie7.min.css">
<script src="<?php echo get_template_directory_uri();?>/assets/scripts/ie6/warning.js"></script>
<script>window.onload=function(){e("<?php echo get_template_directory_uri();?>/assets/scripts/ie6/")}</script>
<![endif]-->

<!--Favicons-->
<?php if (sq_option('favicon')) { ?>
<link rel="shortcut icon" href="<?php echo sq_option('favicon'); ?>">
<?php } ?>
<?php if (sq_option('apple57')) { ?>
<link rel="apple-touch-icon" href="<?php echo sq_option('apple57'); ?>">
<?php } ?>   
<?php if (sq_option('apple57')) { ?>
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo sq_option('apple57'); ?>">
<?php } ?>   
<?php if (sq_option('apple72')) { ?>
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo sq_option('apple72'); ?>">
<?php } ?>   
<?php if (sq_option('apple114')) { ?>
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo sq_option('apple114'); ?>">
<?php } ?>   
<?php if (sq_option('apple144')) { ?>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo sq_option('apple144'); ?>">
<?php } ?>  

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
<?php do_action('kleo_after_body');?>

<!-- Page
================================================ -->
<!--Attributes-->
<!--class = kleo-page wide-style / boxed-style-->
<div class="kleo-page <?php echo sq_option('site_style','wide-style'); ?>">

<!-- HEADER SECTION
================================================ -->
<header>
	<div class="header-bg clearfix">

		<?php if(sq_option('social_top') == 1) :?>
		<!--Top links-->
		<div class="top-links">
				<div class="row">
						<ul class="no-bullet">
								<li class="nine columns">
										<?php do_action('kleo_before_top_links');?>

										<?php if(sq_option('owner_email')): ?>
										<a class="mail-top" href="mailto:<?php echo sq_option('owner_email'); ?>"><i class="icon-envelope"></i> &nbsp; <?php echo sq_option('owner_email'); ?></a>
										<?php endif; ?>
								</li>

								<li class="three columns hide-for-small">
										<?php _e("Find us on", 'kleo_framework'); ?>: &nbsp;
										<?php if (sq_option('twitter')): ?>
										<a href="<?php echo sq_option('twitter');?>" class="has-tip tip-bottom" data-width="210" title="<?php _e("Follow us on", 'kleo_framework');?> Twitter"><i class="icon-twitter icon-large"></i></a>
										<?php endif;?>
										<?php if (sq_option('facebook')): ?>
										<a href="<?php echo sq_option('facebook');?>" class="has-tip tip-bottom" data-width="210" title="<?php _e("Find us on", 'kleo_framework');?> Facebook"><i class="icon-facebook icon-large"></i></a>
										<?php endif;?>
										<?php if (sq_option('googleplus')): ?>
										<a href="<?php echo sq_option('googleplus');?>" class="has-tip tip-bottom" data-width="210" title="<?php _e("Find us on", 'kleo_framework');?> Google+"><i class="icon-google-plus icon-large"></i></a>
										<?php endif; ?>
										<?php if (sq_option('pinterest')): ?>
										<a href="<?php echo sq_option('pinterest');?>" class="has-tip tip-bottom" data-width="210" title="<?php _e("Pin us on", 'kleo_framework');?> Pinterest"><i class="icon-pinterest icon-large"></i></a>
										<?php endif; ?>
										<?php if (sq_option('linkedin')): ?>
										<a href="<?php echo sq_option('linkedin');?>" class="has-tip tip-bottom" data-width="210" title="<?php _e("Find us on", 'kleo_framework');?> LinkedIn"><i class="icon-linkedin icon-large"></i></a>
										<?php endif; ?>
										
										<?php do_action('kleo_extra_social_icons'); ?>
								</li>
						</ul>
			</div>
		</div>
		<!--end top-links-->
		<?php endif; ?>

		<div id="header">
			<div class="row">

				<!-- Logo -->
				<div class="four columns">
					<h1 id="logo"><?php bloginfo('name'); ?>
							<a href="<?php echo get_home_url(); ?>"><img id="logo_img" src="<?php echo sq_option('logo',get_template_directory_uri().'/assets/images/logo.png'); ?>" width="294" height="108" alt="<?php bloginfo('name'); ?>"></a>
					</h1>
				</div>
				<!--end logo-->
				<!-- Main Navigation -->
				<div class="five columns">
					<div class="contain-to-grid<?php if (sq_option('sticky_menu', 1) == 1) echo ' sticky'; ?>">
						<nav class="top-bar">
								<a href="<?php echo get_home_url(); ?>" class="small-logo"><img src="<?php echo sq_option('small_logo',get_template_directory_uri().'/assets/images/small_logo.png'); ?>" height="43" alt="<?php bloginfo('name'); ?>"></a>
							<ul>
								<!-- Toggle Button Mobile -->
								<li class="name">
									<h1><a href="#"><?php _e("Please select your page", 'kleo_framework'); ?></a></h1>
								</li>
								<li class="toggle-topbar"><a href="#"><i class="icon-reorder"></i></a></li>
								<!-- End Toggle Button Mobile -->
							</ul>

							<section><!-- Nav Section -->
									<?php wp_nav_menu( array( 'container' => false, 'menu_class' => 'left', 'theme_location' => 'primary', 'fallback_cb' => 'sweetdate_main_nav', 'walker' => new sweetdate_walker_nav_menu) ); ?>
							</section><!-- End Nav Section -->

						</nav>
					</div><!--end contain-to-grid sticky-->
				</div>
				<!-- end Main Navigation -->
				<!-- Login/Register/Forgot username/password Modal forms
					-  Hidden by default to be opened through modal
					-  For faster loading we put all forms at the bottom of page -->

				<!--Login buttons-->  
				<div class="three columns login-buttons">
					<ul class="button-group radius right">
						<?php if (is_user_logged_in()): ?>
							<?php /* Only show if Buddypress is installed */ ?>
								<?php if (function_exists('bp_is_active')): ?>
								<li class="relative"><a href="<?php bp_loggedin_user_link(); ?>" class="tiny secondary button radius"><i class="icon-user hide-for-medium-down"></i> <?php _e("PROFILE", 'kleo_framework'); ?></a><div class="kleo-notifications"><?php if( bp_is_active('messages') && messages_get_unread_count() > 0 ) { ?><a href="<?php echo bp_loggedin_user_domain().'messages/'; ?>" data-width="210" title="<?php _e("New messages", 'kleo_framework');?>" class="kleo-message-count has-tip tip-left"><?php echo messages_get_unread_count(); ?></a><?php } ?><?php if (bp_is_active('friends') && bp_friend_get_total_requests_count() > 0): ?> <a href="<? echo bp_loggedin_user_domain().'friends/requests'; ?>" data-width="210" title="<?php _e("Friend requests", 'kleo_framework');?>" class="kleo-friends-req has-tip tip-right"><?php echo bp_friend_get_total_requests_count(); ?></a><?php endif; ?> </div></li>
								<?php endif; ?>
						<li><a href="<?php echo wp_logout_url(get_bloginfo('url')); ?> " class="tiny button radius"><i class="icon-off hide-for-medium-down"></i> <?php _e("LOG OUT", 'kleo_framework'); ?></a></li>
						<?php else: ?>
						<li><a href="#" data-reveal-id="login_panel" class="tiny secondary button radius"><i class="icon-user hide-for-medium-down"></i> <?php _e("LOG IN", 'kleo_framework'); ?></a></li>
						<?php if(get_option('users_can_register')) { ?>
								<li><a href="<?php if (function_exists('bp_is_active')) bp_signup_page(); else echo get_bloginfo('url')."/wp-login.php?action=register"; ?>"  class="tiny button radius"><i class="icon-group hide-for-medium-down"></i> <?php _e("SIGN UP", 'kleo_framework'); ?></a></li>
						<?php } ?>
						<?php endif; ?>
					</ul>
				</div>
				<!--end login buttons-->


				
			</div><!--end row-->
			
			<?php if (sq_option('home_rev',0) == 1 && function_exists('putRevSlider')) { /*Fix for Safari on MacOs */ ?>
			
			</div><!--end #header-->
			
			<?php } ?>
			
			<div class="row just-after-header">
			<?php
			/**
			 * after_header_content
			 * 
			 * @hooked render_user_search - only if is Front-page Template
			 */
			do_action('after_header_content');
			?>
			</div>
			
			<?php if (sq_option('home_rev',0) == 0) { /*Fix for Safari on MacOs */ ?>
			
			</div><!--end #header-->
			
			<?php } ?>
		
		<?php
		/**
		 * kleo_after_header
		 * 
		 */
		do_action('kleo_after_header');
		?>
		

	</div><!--end header-bg-->
</header>
<!--END HEADER SECTION-->

<?php
/**
 * kleo_before_page
 * 
 * @hooked kleo_show_breadcrumb - 9
 */
do_action( 'kleo_before_page' ); 
?>
