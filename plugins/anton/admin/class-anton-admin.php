<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       antonstuido.com
 * @since      1.0.0
 *
 * @package    Anton
 * @subpackage Anton/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Anton
 * @subpackage Anton/admin
 * @author     Stanley Lau <stanleyyylau@gmail.com>
 */
class Anton_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/anton-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/anton-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_menu() {
        add_menu_page( 'Anton', 'Anton',
            'manage_options', 'anton-options', array($this, 'render_anton_settings_page'),
            'dashicons-smiley', 99 );

        //create submenu items
        add_submenu_page( 'anton-options', 'About The Anton Plugin', 'About', 'manage_options',
            'anton-about', array($this, 'render_anton_about_page') );
        add_submenu_page( 'anton-options', 'Help With The Anton Plugin', 'Help', 'manage_options',
            'anton-help', array($this, 'render_anton_help_page' ) );
        add_submenu_page( 'anton-options', 'Uninstall The Anton Plugin', 'Uninstall', 'manage_options',
            'anton-uninstall', array($this, 'render_anton_uninstall_page' ) );
    }

    public function register_setting() {
        $args = array(
            'type'=> 'string',
            'sanitize_callback' => array($this, 'anton_plugin_validate_options'),
            'default' => NULL
        );

        //register our settings
        register_setting( 'anton_plugin_options', 'anton_plugin_options', $args );

        //add a settings section
        add_settings_section(
            'anton_plugin_main',
            'Anton Plugin Section title',
            array($this, 'anton_plugin_section_text'),
            'anton-options'
        );

        //create our settings field for name
        add_settings_field(
            'anton_plugin_field_name',
            'Your Name',
            array($this, 'render_anton_plugin_field_name'),
            'anton-options',
            'anton_plugin_main'
        );

        add_settings_field(
            'anton_plugin_field_age',
            'Your age',
            array($this, 'render_anton_plugin_field_age'),
            'anton-options',
            'anton_plugin_main'
        );

        add_settings_field(
            'anton_plugin_field_language',
            'Your language',
            array($this, 'render_anton_plugin_field_language'),
            'anton-options',
            'anton_plugin_main'
        );
    }

    public function render_anton_settings_page() {
        ?>
        <div class="wrap">
            <h2>My plugin</h2>
            <?php settings_errors(); ?>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'anton_plugin_options' );
                do_settings_sections( 'anton-options' );
                submit_button( 'Save Changes', 'primary' );
                ?>
            </form>
        </div>
        <?php
    }

    public function render_anton_about_page() {

    }

    public function render_anton_help_page() {

    }

    public function render_anton_uninstall_page() {

    }

    public function anton_plugin_validate_options($input) {
        $old_option = get_option('anton_plugin_options');

        // Only allow letters and spaces for the name
        $valid['name'] = preg_replace(
            '/[^a-zA-Z\s]/',
            '',
            $input['name'] );

        if( $valid['name'] !== $input['name'] ) {

            add_settings_error(
                'anton_plugin_field_name',
                'pdev_plugin_texterror',
                'Incorrect value entered! Please only input letters and spaces.',
                'error'
            );

            return $old_option;

        }

        return $input;
    }

    public function anton_plugin_section_text() {
        echo '<p>anton_plugin_section_text.</p>';
    }

    public function render_anton_plugin_field_name() {
        // get option 'text_string' value from the database
        $options = get_option( 'anton_plugin_options' );
        $name = $options['name'];

        // echo the field
        echo "<input id='name' name='anton_plugin_options[name]'
        type='text' value='" . esc_attr( $name ) . "' />";
    }

    public function render_anton_plugin_field_age() {
        // get option 'text_string' value from the database
        $options = get_option( 'anton_plugin_options' );
        $age = $options['age'];

        // echo the field
        echo "<input id='age' name='anton_plugin_options[age]'
        type='text' value='" . esc_attr( $age ) . "' />";
    }

    public function render_anton_plugin_field_language() {
        // get option 'text_string' value from the database
        $options = get_option( 'anton_plugin_options' );
        $language = $options['language'];

        // echo the field
        echo "<input id='language' name='anton_plugin_options[language]'
        type='text' value='" . esc_attr( $language   ) . "' />";
    }

}
