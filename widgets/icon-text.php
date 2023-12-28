<?php
namespace VenusCompanion\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Icon_Text extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'icon-text';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Icon Text', 'venus-companion' );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-text';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'venus_category' ];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'venus-companion' ];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'venus-companion' ),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'venus-companion' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __( 'Description', 'venus-companion' ),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'venus-companion' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_alignment',
            [
                'label' => __( 'Text Alignment', 'venus-companion' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'center' => __( 'Center', 'venus-companion' ),
                    'left' => __( 'Left', 'venus-companion' ),
                    'right' => __( 'Right', 'venus-companion' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-hover' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_transform',
            [
                'label' => __( 'Text Transform', 'venus-companion' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __( 'None', 'venus-companion' ),
                    'uppercase' => __( 'UPPERCASE', 'venus-companion' ),
                    'lowercase' => __( 'lowercase', 'venus-companion' ),
                    'capitalize' => __( 'Capitalize', 'venus-companion' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="blurb blurb-border box-hover mb-4">
            <i class="<?php echo esc_attr($settings['icon']['value']) ;?> text-primary"></i>
            <h6 class="mb-2">
                <?php echo esc_html($settings['title']) ;?>
            </h6>
            <p class="text-muted mb-0">
                <?php echo esc_html($settings['description']) ;?>
            </p>
        </div>
        <?php
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
//    protected function content_template() {
//
//        <div class="title">
//            {{{ settings.title }}}
//        </div>
//
//    }
}
