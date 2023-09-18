<?php

/*
Plugin Name: RM Plugin
Description:
Version: 1.0.0
Author:
Author URI:
*/

defined('ABSPATH') or die('die');

if (!class_exists('RMPlugin')) {

	class RMPlugin
	{

		public $callbacks;
		public $plugin_path;
		public $plugin_url;
		public $plugin;

		public function __construct()
		{
			$this->plugin_path = plugin_dir_path(__FILE__);
			$this->plugin_url = plugin_dir_url(__FILE__);
			$this->plugin = plugin_basename(__FILE__) . '/rm-plugin.php';
		}

		function register()
		{

			require_once plugin_dir_path(__FILE__) . 'class/rm-admin.php';

			$this->callbacks = new AdminCallbacks();

			add_action('admin_enqueue_scripts', array($this, 'enqueue'));

			add_action('admin_menu', array($this, 'add_admin_pages'));

			add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
		}

		public function settings_link($links)
		{
			$settings_link = '<a href="admin.php?page=rm_plugin">Settings</a>';
			array_push($links, $settings_link);
			return $links;
		}

		public function add_admin_pages()
		{
			add_menu_page('RM Plugin', 'Añadir RM', 'manage_options', 'rm_plugin', array($this->callbacks, 'home'), plugin_dir_url(__FILE__) . '/admin/img/icon.svg', 1);
			add_submenu_page('rm_plugin', 'Importar CSV', 'Importar CSV', 'manage_options', 'rm_importexcel', array($this->callbacks, 'importexcel'));
		}
		
		function activate()
		{
			require_once plugin_dir_path(__FILE__) . 'class/rm-activate.php';
			RMPluginActivate::activate();
		}

		function enqueue()
		{
			wp_enqueue_style('rmstyles', plugins_url('admin/css/rm-plugin.css', __FILE__));
			wp_enqueue_script('rmscripts', plugins_url('admin/js/rm-plugin.js', __FILE__));
			wp_enqueue_script('bootstrapjs', plugins_url('admin/bootstrap/js/bootstrap.min.js', __FILE__));
			wp_enqueue_style('bootstrapcss', plugins_url('admin/bootstrap/css/bootstrap.min.css', __FILE__));
		}
	}

	$rmplugin = new RMPlugin();
	$rmplugin->register();

	register_activation_hook(
		__FILE__,
		array($rmplugin, 'activate')
	);

	require_once plugin_dir_path(__FILE__) . 'class/rm-deactivate.php';
	register_deactivation_hook(
		__FILE__,
		array('RMPluginDeactivate', 'deactivate')
	);
}
