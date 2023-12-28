<?php

namespace VenusCompanion\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Team_Carousel extends Widget_Base {

    public function get_name() {
        return 'team-carousel';
    }

    public function get_title() {
        return __('Team Carousel', 'venus-companion');
    }

    public function get_icon() {
        return 'eicon-cogs';
    }

    public function get_categories() {
        return array('venus_category');
    }

    public function get_script_depends() {
        return array('venus-team-carousel');
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __('Content', 'venus-companion'),
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'photo', [
                'label' => __( 'Photo', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'name', [
                'label' => __( 'Name', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'designation', [
                'label' => __( 'Designation', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


        $this->add_control(
            'team_members',
            [
                'label' => __( 'Team Members', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
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

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        echo '<div class="owl-carousel owl-theme dot-style-2 nav-inside nav-circle-solid-light px-md-0 px-3" data-items="[4,2]" data-margin="30" data-autoplay="true" data-center="true" data-loop="true" data-nav="true" data-dots="true">';
        foreach($settings['team_members'] as $team_member){
            $image = wp_get_attachment_image_url($team_member['photo']['id'], 'venus-team');
            ?>
            <div class="item">
                <div class="card border-0 mb-md-0 mb-3">
                    <img class="card-img-top" src="<?php echo esc_url($image) ;?>" alt="">
                    <div class="card-footer border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <?php echo esc_html($team_member['name']) ;?>
                                <span class="text-muted d-block font-size-14">
                                    <?php echo esc_html($team_member['designation']) ;?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    }

    /* protected function _content_template() {
    ?>
        <div class="title">
            {{{ settings.title }}}
        </div>
    <?php
    } */
}
