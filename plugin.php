<?php
namespace VenusCompanion;

use VenusCompanion\PageSettings\Page_Settings;
use VenusCompanion\Widgets\Hello_World;
use VenusCompanion\Widgets\Inline_Editing;
use VenusCompanion\Widgets\Image_Hover;
use VenusCompanion\Widgets\Icon_Text;
use VenusCompanion\Widgets\Portfolio;
use VenusCompanion\Widgets\Team_Member;
use VenusCompanion\Widgets\Testimonial;
use VenusCompanion\Widgets\Service_Widget;
use VenusCompanion\Widgets\Bullet_List;
use VenusCompanion\Widgets\Client_Logo;
use VenusCompanion\Widgets\Team_Carousel;
use VenusCompanion\Widgets\Minimal_Team_Member;
use VenusCompanion\Widgets\Contact_Form;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class VenusPlugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		wp_register_script( 'elementor-hello-world', plugins_url( '/assets/js/hello-world.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'venus-portfolio', plugins_url( '/assets/js/venus-portfolio.js', __FILE__ ), [ 'jquery','imagesloaded-js','isotope-js' ], false, true );
        wp_register_script( 'venus-carousel', plugins_url( '/assets/js/venus-carousel.js', __FILE__ ), [ 'jquery','imagesloaded-js','isotope-js' ], time(), true );
        wp_register_script( 'venus-client-logo', plugins_url( '/assets/js/venus-client-logo.js', __FILE__ ), [ 'jquery','imagesloaded-js','isotope-js' ], time(), true );
        wp_register_script( 'venus-team-carousel', plugins_url( '/assets/js/venus-team-carousel.js', __FILE__ ), [ 'jquery','imagesloaded-js','isotope-js' ], time(), true );
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );

		wp_enqueue_script(
			'elementor-hello-world-editor',
			plugins_url( '/assets/js/editor/editor.js', __FILE__ ),
			[
				'elementor-editor',
			],
			'1.2.1',
			true
		);
	}

	/**
	 * Force load editor script as a module
	 *
	 * @since 1.2.1
	 *
	 * @param string $tag
	 * @param string $handle
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'elementor-hello-world-editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		// Its is now safe to include Widgets files
		require_once( __DIR__ . '/widgets/hello-world.php' );
		require_once( __DIR__ . '/widgets/inline-editing.php' );
		require_once( __DIR__ . '/widgets/image_hover.php' );
		require_once( __DIR__ . '/widgets/icon-text.php' );
		require_once( __DIR__ . '/widgets/portfolio.php' );
		require_once( __DIR__ . '/widgets/team-member.php' );
		require_once( __DIR__ . '/widgets/testimonial-widget.php' );
		require_once( __DIR__ . '/widgets/service-widget.php' );
		require_once( __DIR__ . '/widgets/bullet-list.php' );
		require_once( __DIR__ . '/widgets/client-logo.php' );
		require_once( __DIR__ . '/widgets/team-carousel.php' );
		require_once( __DIR__ . '/widgets/minimal-team-member.php' );
		require_once( __DIR__ . '/widgets/contact-form.php' );

		// Register Widgets
		$widgets_manager->register( new Widgets\Hello_World() );
		$widgets_manager->register( new Widgets\Inline_Editing() );
		$widgets_manager->register( new Widgets\Image_Hover() );
		$widgets_manager->register( new Widgets\Icon_Text() );
		$widgets_manager->register( new Widgets\Portfolio() );
		$widgets_manager->register( new Widgets\Team_Member() );
		$widgets_manager->register( new Widgets\Testimonial() );
		$widgets_manager->register( new Widgets\Service_Widget() );
		$widgets_manager->register( new Widgets\Bullet_List() );
		$widgets_manager->register( new Widgets\Client_Logo() );
		$widgets_manager->register( new Widgets\Team_Carousel() );
		$widgets_manager->register( new Widgets\Minimal_Team_Member() );
		$widgets_manager->register( new Widgets\Contact_Form() );

	}

	/**
	 * Add page settings controls
	 *
	 * Register new settings for a document page settings.
	 *
	 * @since 1.2.1
	 * @access private
	 */
	private function add_page_settings_controls() {
		require_once( __DIR__ . '/page-settings/manager.php' );
		new Page_Settings();
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

        add_action( 'elementor/elements/categories_registered', [$this,'add_elementor_widget_categories'] );

        add_action('wp_ajax_nopriv_venus_contact',[$this,'process_contact_form']);
        add_action('wp_ajax_venus_contact',[$this,'process_contact_form']);
		
		$this->add_page_settings_controls();
	}

    function add_elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'venus_category',
            [
                'title' => esc_html__( 'Venus Widget', 'venus-companion' ),
                'icon' => 'fa fa-plug',
            ],
        );

    }

    public function process_contact_form(){
        if(wp_verify_nonce($_POST['nonce'],'venus_contact')){
            $email = get_option('admin_email');
            $data = "";
            foreach($_POST['formdata'] as $key=>$val){
                $data .= sprintf("%s = %s<br/>",$key,sanitize_text_field($val));
            }
            wp_mail($email,__("Contact Form Submission","venus-companion"),$data);
            echo "sent";
        }
        die();
    }
}




// Instantiate Plugin Class
VenusPlugin::instance();
