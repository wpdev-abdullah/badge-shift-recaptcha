<?php
/*
 * Plugin Name: BadgeShift for ReCAPTCHA
 * Description: BadgeShift for ReCAPTCHA will <strong>move the Google reCAPTCHA v3 badge to the left side.</strong> Just install and it's done. The plugin is super lightweight so adding it will not slow down your website.
 * Version: 1.0.2
 * Author: WpConsults LLC
 * Author URI: https://www.wpconsults.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


/// Enqueue custom CSS with dynamic values
function badge_shift_enqueue_styles() {
	$plugin_version = '1.0.0'; // Set your plugin version here
	    wp_enqueue_style( 'badge-shift-recaptcha-css', plugins_url( 'badge-shift-recaptcha.css', __FILE__ ), array(), $plugin_version );

    $left_position = get_option( 'badge_shift_left_position', '-2px' );
    $bottom_position = get_option( 'badge_shift_bottom_position', '20px' );
    $z_index = get_option( 'badge_shift_z_index', '9999' ); // Default z-index value
	

    $custom_css = "
        .grecaptcha-badge {
            left: {$left_position} !important;
            bottom: {$bottom_position} !important;
            z-index: {$z_index} !important;
        }
    ";

    wp_add_inline_style( 'badge-shift-recaptcha-css', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'badge_shift_enqueue_styles' );


// Add settings page
function badge_shift_settings_page() {
    add_options_page( 'BadgeShift Settings', 'BadgeShift Settings', 'manage_options', 'badge_shift_settings', 'badge_shift_settings_page_content' );
}
add_action( 'admin_menu', 'badge_shift_settings_page' );



// Register settings
function badge_shift_register_settings() {
    register_setting( 'badge_shift_settings_group', 'badge_shift_left_position' );
    register_setting( 'badge_shift_settings_group', 'badge_shift_bottom_position' );
    register_setting( 'badge_shift_settings_group', 'badge_shift_z_index' );
}
add_action( 'admin_init', 'badge_shift_register_settings' );


// Save settings
function badge_shift_save_settings() {
    // Validation and sanitization can be added here if needed
}


// Settings page content
function badge_shift_settings_page_content() {
    ?>
    <div class="wrap">
        <h2>BadgeShift Settings</h2>
		<p>
			Normally it will work fine, However If you need you can Adjust position by inputing respective values here.
		</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'badge_shift_settings_group' ); ?>
            <?php do_settings_sections( 'badge_shift_settings_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Left Position:</th>
                    <td><input type="text" name="badge_shift_left_position" placeholder="-2px" value="<?php echo esc_attr( get_option( 'badge_shift_left_position' ) ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Bottom Position:</th>
                    <td><input type="text" name="badge_shift_bottom_position" placeholder="20px" value="<?php echo esc_attr( get_option( 'badge_shift_bottom_position' ) ); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Z-Index:</th>
                    <td><input type="text" name="badge_shift_z_index" placeholder="9999" value="<?php echo esc_attr( get_option( 'badge_shift_z_index' ) ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}





