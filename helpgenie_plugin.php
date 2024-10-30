<?php
/**
 * Plugin Name: HelpGenie Customer Support Widget
 * Description: HelpGenie.io makes useful information easily accessible to your visitors and help boost your website conversions.
 * Version: 1.0.3
 * Author: HelpGenie.io
 * Author URI: https://helpgenie.io
 */
if (!defined('ABSPATH')) die ('No direct access allowed');

if(!class_exists('HelpGenieIO'))
{
    class HelpGenieIO
    {
		private $options;

		public function __construct() {
    		add_action( 'admin_init', array($this, 'init_settings') );
			add_action('admin_menu', array($this, 'helpgenie_config') );
			add_action('wp_footer', array($this, 'add_helpgenie_code') );
		}
		
		public static function init_settings() {
			register_setting('helpgenie', 'helpgenie-jscode');
		}
		
		public static function uninstall() {
			self::delete_options();
		}
		
		
		public static function delete_options() {
			unregister_setting('helpgenie', 'helpgenie-jscode');
			delete_option('helpgenie-jscode');
		}

		public function helpgenie_config()
		{
			add_menu_page(__('HelpGenie', 'helpgenie'), __('HelpGenie', 'helpgenie'), 'manage_options', basename(__FILE__), array($this, 'helpgenie_create_settings'), plugin_dir_url( __FILE__ ) . 'images/icon.png');
		}

		public function helpgenie_create_settings()
		{
			$logo = plugin_dir_url(__FILE__) . 'images/helpgenie-io-logo.png';

			echo '<div id="helpgeniepost" style="padding:20px;">';
			echo '<a href="https://helpgenie.io" target="_blank"><img src="'.htmlspecialchars($logo).'" style="height:auto;width:100%;max-width:300px;"></a>';

			if (get_option('helpgenie-jscode')) {
				echo '<p>You can alway reinstall the widget code at <a target="_blank" href="https://helpgenie.io?install=wp">https://helpgenie.io</a></p>';
			} else {
				echo '<p>Get your free widget code at <a target="_blank" href="https://helpgenie.io?install=wp">https://helpgenie.io</a></p>';
			}

			echo '<form action="options.php" method="POST">';
			settings_fields('helpgenie');
			do_settings_sections('helpgenie');
			echo '<textarea rows="15" name="helpgenie-jscode" style="width:100%;" placeholder="Copy and Paste Widget Codes Here">' . esc_attr(get_option('helpgenie-jscode')) . '</textarea>';
			submit_button('Save');
			echo '</form>';
			echo '</div>';
		}

		function add_helpgenie_code()
		{
			echo get_option('helpgenie-jscode');
		}
	}
}

if(class_exists('HelpGenieIO')) {
	register_uninstall_hook(__FILE__, array('HelpGenieIO', 'uninstall'));
	$hgwidget = new HelpGenieIO();
}

?>