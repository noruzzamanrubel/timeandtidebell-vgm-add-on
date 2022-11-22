<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://boomdevs.com/
 * @since      1.0.0
 *
 * @package    Timeandtidebell_Vgm_Add_On
 * @subpackage Timeandtidebell_Vgm_Add_On/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Timeandtidebell_Vgm_Add_On
 * @subpackage Timeandtidebell_Vgm_Add_On/public
 * @author     Boomdevs <contact@boomdevs.com>
 */
class Timeandtidebell_Vgm_Add_On_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Timeandtidebell_Vgm_Add_On_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Timeandtidebell_Vgm_Add_On_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/timeandtidebell-vgm-add-on-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Timeandtidebell_Vgm_Add_On_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Timeandtidebell_Vgm_Add_On_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/timeandtidebell-vgm-add-on-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'moment-min', plugin_dir_url( __FILE__ ) . 'js/moment.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-validation', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js' );

		wp_localize_script( $this->plugin_name, 'ttb_vgm_form', [
            'ajaxurl'     => admin_url( 'admin-ajax.php' ),
            'action'      => 'ttb_vgm_form_submit',
            'nonce'       => wp_create_nonce( 'ttb_vgm_form_nonce' ),
			'ttb_marker_date'       => __( 'Please enter date', 'timeandtidebell-vgm-add-on' ),
            'ttb_marker_address'   => __( 'Please enter lat and long', 'timeandtidebell-vgm-add-on' ),
            'ttb_marker_type'       => __( 'Please select type', 'timeandtidebell-vgm-add-on' ),
            'ttb_marker_description'   => __( 'Please enter description. Max character 100 ', 'timeandtidebell-vgm-add-on' ),
        ] );

	}

}
