<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wecode.agency
 * @since      1.0.0
 *
 * @package    petition
 * @subpackage petition/includes
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
 * @package    petition
 * @subpackage petition/includes
 * @author     Tobiasz Gerczuk <tobiasz.gerczuk@wecode.agency>
 */
class Petition {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      petition_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'petition_VERSION' ) ) {
			$this->version = petition_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'petition';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
        $this->run_database_script();

        add_action('admin_menu', array($this, 'add_plugin_page_petition_list'));
        add_action('admin_menu', array($this, 'add_plugin_page_petition_edit'));
        add_action('admin_menu', array($this, 'add_plugin_page_petition_add_user'));


	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - petition_Loader. Orchestrates the hooks of the plugin.
	 * - petition_i18n. Defines internationalization functionality.
	 * - petition_Admin. Defines all hooks for the admin area.
	 * - petition_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

    public function add_plugin_page_petition_list() {
        add_menu_page(
            __('Petitions list','petition'),
            __('Petition','petition'),
            'manage_options',
            'petition',
            array($this, 'petition_list_render'),
            'dashicons-media-spreadsheet'
        );
    }

    public function add_plugin_page_petition_edit() {
        add_submenu_page(
            'petition-edit.php',
            __('Edit petitioner','petition'),
            __('Edit petitioner','petition'),
            'manage_options',
            'petition_edit',
            array($this, 'petition_edit_render')
        );
    }



    public function add_plugin_page_petition_add_user() {
        add_submenu_page(
            'petition',
            __('Add petitioner','petition'),
            __('Add petitioner','petition'),
            'manage_options',
            'petitioner_add',
            array($this, 'petition_add_render')
        );
    }

    public function petition_add_render() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/petition-admin-add.php';
    }

    public function petition_list_render() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/petition-admin-list.php';
    }


    public function petition_edit_render() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/petition-admin-edit.php';
    }


	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-petition-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-petition-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-petition-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-petition-public.php';


        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-petition-database.php';

		$this->loader = new petition_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the petition_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new petition_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

    private function run_database_script() {
        $set_database = new petition_Database();
    }


    /**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new petition_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
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

		$plugin_public = new petition_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
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
	 * @return    petition_Loader    Orchestrates the hooks of the plugin.
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

}
