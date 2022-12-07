<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://boomdevs.com/
 * @since      1.0.0
 *
 * @package    Timeandtidebell_Vgm_Add_On
 * @subpackage Timeandtidebell_Vgm_Add_On/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Timeandtidebell_Vgm_Add_On
 * @subpackage Timeandtidebell_Vgm_Add_On/includes
 * @author     Boomdevs <contact@boomdevs.com>
 */
class Timeandtidebell_Vgm_Add_On {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Timeandtidebell_Vgm_Add_On_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TIMEANDTIDEBELL_VGM_ADD_ON_VERSION' ) ) {
			$this->version = TIMEANDTIDEBELL_VGM_ADD_ON_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'timeandtidebell-vgm-add-on';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->register_shortcode();
		$this->register_ajax_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Timeandtidebell_Vgm_Add_On_Loader. Orchestrates the hooks of the plugin.
	 * - Timeandtidebell_Vgm_Add_On_i18n. Defines internationalization functionality.
	 * - Timeandtidebell_Vgm_Add_On_Admin. Defines all hooks for the admin area.
	 * - Timeandtidebell_Vgm_Add_On_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-timeandtidebell-vgm-add-on-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-timeandtidebell-vgm-add-on-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-timeandtidebell-vgm-add-on-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'libs/codestar-framework/codestar-framework.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-timeandtidebell-vgm-add-on-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-timeandtidebell-vgm-add-on-shortcode.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-timeandtidebell-vgm-add-on-ajax.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-timeandtidebell-vgm-add-on-metabox.php';

		$this->loader = new Timeandtidebell_Vgm_Add_On_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Timeandtidebell_Vgm_Add_On_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Timeandtidebell_Vgm_Add_On_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Timeandtidebell_Vgm_Add_On_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 999 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Timeandtidebell_Vgm_Add_On_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 999 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Timeandtidebell_Vgm_Add_On_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	    /**
     * Register plugin shortcode.
     *
     * @access   private
     */
    private function register_shortcode() {
        $plugin_shortcode = new timeandtidebell_Vgm_Add_Shortcode();
		$this->loader->add_action( 'init', $plugin_shortcode, 'shortcode_generator' );
    }

	/**
     * Register ajax hooks.
     *
     * @access   private
     */
    private function register_ajax_hooks() {

        $plugin_ajax = new Timeandtidebell_Vgm_Add_On_Ajax();
        $this->loader->add_action( 'wp_ajax_ttb_vgm_form_submit', $plugin_ajax, 'ttb_vgm_form_submit' );
        $this->loader->add_action( 'wp_ajax_nopriv_ttb_vgm_form_submit', $plugin_ajax, 'ttb_vgm_form_submit' );

		$this->loader->add_action( 'wp_ajax_ttb_vgb_insert_pic', $plugin_ajax, 'ttb_vgb_insert_pic' );
        $this->loader->add_action( 'wp_ajax_nopriv_ttb_vgb_insert_pic', $plugin_ajax, 'ttb_vgb_insert_pic' );

    }

}
