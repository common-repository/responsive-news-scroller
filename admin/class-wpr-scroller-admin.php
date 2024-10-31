<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://beeplugins.com
 * @since      1.0.0
 *
 * @package    Wpr_Scroller
 * @subpackage Wpr_Scroller/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpr_Scroller
 * @subpackage Wpr_Scroller/admin
 * @author     aumsrini <seenu.ceo@gmail.com>
 */
 
 
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://beeplugins.com
 * @since      1.0.0
 *
 * @package    Wpr_Scroller
 * @subpackage Wpr_Scroller/admin/partials
 */
 
 function admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/admin/css/wpr-scroller-admin.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'admin_register_head');

class ScrollerSettingsPage
{

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $scroller_options;

    /**
     * Start up
     */
    public function __construct()
    {
	
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Scoller News', 
            'WPR Scroller Settings', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {

    $prourl = plugins_url( 'img/scroller-pro.jpg', __FILE__ );
        // Set class property
        $this->options = get_option( 'wpr_scroller_option' );
        ?>
		<div class="scroller-admin">
        <div class="wrap">
           
			<a style="float:right;color:#FFFF00" href="http://beeplugins.com/forums/" target="_blank">Need Help ?</a>         
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'wpr_scroller_group' );  
				$options = get_option( 'wpr_scroller_option' ); 
                do_settings_sections( 'wpr-scroller-setting-admin' );
                submit_button(); 
				
            ?>
            </form>
			<div id="upgrade"><a href="#"><img src="<?php  echo $prourl; ?>" /></a></div>
			<div>Powered By <a  style="color:#FFCC00; text-decoration:none;" target="_blank" href="http://www.beeplugins.com">Beeplugins.com</a></div>
        </div>
		</div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'wpr_scroller_group', // Option group
            'wpr_scroller_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'WPR Scroller Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'wpr-scroller-setting-admin' // Page
        );  
		
	

		 add_settings_field(
		 'no_post',
            'How many News  to show ? :', // Title
            array( $this, 'no_post_callback' ), // Callback
            'wpr-scroller-setting-admin',// Page
			 'setting_section_id'
            
        ); 
		
				         
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        
        if( isset( $input['no_post'] ) )
         
			
			 if( isset( $input['no_post'] ) )
            $new_input['no_post'] = sanitize_text_field( $input['no_post'] );
			
					

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter  your options below:';
    }

    
	
	 public function no_post_callback()
    {
        printf(
            '<input type="text" id="no_post" name="wpr_scroller_option[no_post]" value="%s" />',
            isset( $this->options['no_post'] ) ? esc_attr( $this->options['no_post']) : ''
        );
    }

}

if( is_admin() )
    $my_settings_page = new ScrollerSettingsPage();
class Wpr_Scroller_Admin {


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
		 * defined in Wpr_Scroller_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpr_Scroller_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpr-scroller-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wpr_Scroller_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpr_Scroller_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpr-scroller-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	

}
