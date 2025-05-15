<?php

/**
 * Hard Fork from https://wordpress.org/plugins/host-changer/.
 *
 * @see              https://domain-swapper.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Domain swapper - Use and change/swap multiple domains with one WordPress Site
 * Plugin URI: https://wordpress.org/plugins/domain-swapper
 * Description: domain_swapper to access same WordPress site from different domains.
 * Version: 1.0.0
 * Author: Myridia Company
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: domain_swapper
 * Domain Path: /languages
 * Author URI: http://domain-swapper.myridia.com
 * Update URL: https://github.com/myridia/domain-swapper
 * Constant Prefix: WPDS_
 * Prefix: wpds_
 * Option_key: plugin_domain_swapper
 **/
defined('ABSPATH') or exit('Something went wrong');

use WP\Ds\Main\Class01;

// get the metadata from the plugin header
$m_plugin_data = get_file_data(__FILE__, ['name' => 'Plugin Name', 'version' => 'Version', 'text_domain' => 'Text Domain', 'constant_prefix' => 'Constant Prefix', 'prefix' => 'Prefix', 'option_key' => 'Option_key']);

//  Define Plugin specific Constants
m_make_constants('NAME', $m_plugin_data['text_domain'], $m_plugin_data);
m_make_constants('DIR', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('BASE', plugin_basename(__FILE__), $m_plugin_data);
m_make_constants('URL', plugin_dir_url(__FILE__), $m_plugin_data);
m_make_constants('URI', plugin_dir_url(__FILE__), $m_plugin_data);
m_make_constants('PATH', plugin_dir_path(__FILE__), $m_plugin_data);
m_make_constants('SLUG', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('BASENAME', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('VERSION', $m_plugin_data['version'], $m_plugin_data);
m_make_constants('TEXT', $m_plugin_data['text_domain'], $m_plugin_data);
m_make_constants('PREFIX', $m_plugin_data['prefix'], $m_plugin_data);
m_make_constants('OPTION', $m_plugin_data['option_key'], $m_plugin_data);

// Default Plugin activate and deactivate hooks, started in static class functions
register_activation_hook(__FILE__, ['WP\Ds\Main\Class01', 'activate']);
register_deactivation_hook(__FILE__, ['WP\Ds\Main\Class01', 'deactivate']);

// Register to start the Plugin
add_action('init', 'wp_ds_plugin_init');

/*
  Start the the Plugin
*/
function wp_ds_plugin_init()
{
    $plugin = new Class01();
    $plugin->add_menu_setting();
}

/*
  Helper Function to register Classes cleanly with namespaces
*/
spl_autoload_register(function (string $className) {
    if (false === strpos($className, 'WP\\Ds')) {
        return;
    }
    $className = str_replace('WP\\Ds\\', __DIR__.'/src/', $className);
    $classFile = str_replace('\\', '/', $className).'.php';
    require_once $classFile;
});

// Helper Function to create all Constants
function m_make_constants($name, $value, $pdata)
{
    $prefix = $pdata['constant_prefix'];
    $c_name = $prefix.$name;
    // echo $c_name.'<br>';
    // echo $value.'<br>';
    if (!defined($c_name)) {
        define($c_name, $value);
    }
}

// https://developer.wordpress.org/plugins/settings/custom-settings-page/
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings.
 */
function wporg_settings_init()
{
    // Register a new setting for "wporg" page.
    register_setting('wporg', 'wporg_options');

    // Register a new section in the "wporg" page.
    add_settings_section(
        'wporg_section_developers',
        __('The Matrix has you.', 'wporg'), 'wporg_section_developers_callback',
        'wporg'
    );

    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'wporg_field_pill', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Pill', 'wporg'),
        'wporg_field_pill_cb',
        'wporg',
        'wporg_section_developers',
        [
            'label_for' => 'wporg_field_pill',
            'class' => 'wporg_row',
            'wporg_custom_data' => 'custom',
        ]
    );
}

/*
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action('admin_init', 'wporg_settings_init');

/**
 * Custom option and settings:
 *  - callback functions
 */

/**
 * Developers section callback function.
 *
 * @param array $args the settings array, defining title, id, callback
 */
function wporg_section_developers_callback($args)
{
    ?>
	<p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Follow the white rabbit.', 'wporg'); ?></p>
	<?php
}

/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function wporg_field_pill_cb($args)
{
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('wporg_options');
    ?>
	<select
			id="<?php echo esc_attr($args['label_for']); ?>"
			data-custom="<?php echo esc_attr($args['wporg_custom_data']); ?>"
			name="wporg_options[<?php echo esc_attr($args['label_for']); ?>]">
		<option value="red" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'red', false)) : (''); ?>>
			<?php esc_html_e('red pill', 'wporg'); ?>
		</option>
 		<option value="blue" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'blue', false)) : (''); ?>>
			<?php esc_html_e('blue pill', 'wporg'); ?>
		</option>
	</select>
	<p class="description">
		<?php esc_html_e('You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg'); ?>
	</p>
	<p class="description">
		<?php esc_html_e('You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg'); ?>
	</p>
	<?php
}

/**
 * Add the top level menu page.
 */
function wporg_options_page()
{
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html'
    );
}

/*
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action('admin_menu', 'wporg_options_page');

/**
 * Top level menu callback function.
 */
function wporg_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('wporg_messages', 'wporg_message', __('Settings Saved', 'wporg'), 'updated');
    }

    // show error/update messages
    settings_errors('wporg_messages');
    ?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
		<form action="options.php" method="post">
			<?php
            // output security fields for the registered setting "wporg"
            settings_fields('wporg');
    // output setting sections and their fields
    // (sections are registered for "wporg", each field is registered to a specific section)
    do_settings_sections('wporg');
    // output save settings button
    submit_button('Save Settings');
    ?>
		</form>
	</div>
	<?php
}
