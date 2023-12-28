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
class Contact_Form extends Widget_Base {

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
        return 'contact-form';
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
        return __( 'Contact Form', 'venus-companion' );
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
        return 'eicon-folder';
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
        return [ 'venus-contact' ];
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
            array(
                'label' => __('Content', 'venus-companion'),
            )
        );

        $this->add_control(
            'title',
            array(
                'label' => __('Form Title', 'venus-companion'),
                'type'  => Controls_Manager::TEXT,
                'label_block' => false,
            )
        );

        $this->add_control(
            'button_title',
            array(
                'label' => __('Button Title', 'venus-companion'),
                'type'  => Controls_Manager::TEXT,
                'label_block' => false,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'field_id', [
                'label' => __( 'Field Id', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'field_placeholder', [
                'label' => __( 'Placeholder Text', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'field_type',
            [
                'label' => __( 'Field Type', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text'  => __( 'Text', 'venus-companion' ),
                    'textarea' => __( 'Textarea', 'venus-companion' ),
                ],
            ]
        );

        $this->add_control(
            'fields',
            [
                'label' => __( 'Fields', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ field_id }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_style',
            array(
                'label' => __('Style', 'venus-companion'),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'form_bg',
            [
                'label' => __( 'Form Background Color', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-wrapper' => 'background: {{VALUE}}',
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
        <div class="form-wrapper">
            <form class="p-4 py-5" >
                <?php
                wp_nonce_field('venus_contact','venus_nonce');
                ?>
                <h5 class="mb-3"><?php echo esc_html($settings['title']) ;?></h5>
                <?php
                foreach($settings['fields'] as $field){
                    if('text'==$field['field_type']){
                        printf('<div class="form-group">
                            <input id="%s" type="text" class="form-control" placeholder="%s">
                        </div>',esc_attr($field['field_id']),esc_attr($field['field_placeholder']));
                    }else{
                        printf('<div class="form-group">
                            <textarea id="%s" class="form-control" rows="4" placeholder="Message"></textarea>
                        </div>',esc_attr($field['field_id']),esc_attr($field['field_placeholder']));
                    }
                }
                ?>
                <button  type="submit" class="contact_button btn btn-pill btn-primary"><?php echo esc_html($settings['button_title']) ;?></button>
            </form>
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
