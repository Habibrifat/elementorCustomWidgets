<?php
namespace VenusCompanion\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Portfolio extends Widget_Base {

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
        return 'Portfolio';
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
        return __( 'Portfolio', 'venus-companion' );
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
        return 'eicon-pencil';
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
        return [ 'venus-portfolio' ];
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
            'show_tags',
            [
                'label' => __( 'Show Tags', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'venus-companion' ),
                'label_off' => __( 'Hide', 'venus-companion' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'portfolio_style',
            [
                'label' => __( 'Portfolio Style', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'masonry',
                'options' => [
                    'masonry' => __( 'Masonry', 'venus-companion' ),
                    'square'  => __( 'Square', 'venus-companion' ),
                ],
            ]
        );
        $this->add_control(
            'portfolio_column',
            [
                'label' => __( 'Portfolio Column', 'venus-companion' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid-3',
                'options' => [
                    'grid-2' => __( 'Grid 2', 'venus-companion' ),
                    'grid-3' => __( 'Grid 3', 'venus-companion' ),
                    'grid-4' => __( 'Grid 4', 'venus-companion' ),
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

        if($settings['show_tags']=='yes'){
            $tags = get_terms([
                'hide_empty'=>true,
                'taxonomy'=>'ptags'
            ]);
            ?>
            <div class="text-center">
                <ul class="portfolio-filter">
                    <li class="active"><a href="#" data-filter="*"> All</a></li>
                    <?php
                    foreach($tags as $tag){
                        printf('<li><a href="#" data-filter=".%s">%s</a></li>',esc_attr($tag->slug),esc_html($tag->name));
                    }
                    ?>
                </ul>
            </div>
            <?php

            $postfolios = new WP_Query([
                'posts_per_page'=>-1,
                'post_type'=>'portfolio',
                'post_status'=>'publish'
            ]);

            echo '<div class="portfolio-grid portfolio-gallery '. $settings['portfolio_column'] .' gutter">';
            while($postfolios->have_posts()){
                $postfolios->the_post();
                $portfolio_tags = $this->get_portfolio_tags(get_the_ID());
                if($settings['portfolio_style']=='square'){
                    $image_url  = get_the_post_thumbnail_url(get_the_ID(),'venus-team');
                }else{
                    $image_url  = get_the_post_thumbnail_url(get_the_ID(),'large');
                }
                ?>
                <div class="portfolio-item <?php echo esc_attr($portfolio_tags) ;?>">
                    <a href="<?php echo esc_url($image_url)  ;?>" class="portfolio-image popup-gallery"
                       title="Venus Product">
                        <img src="<?php echo esc_url($image_url)  ;?>" alt="" />
                        <div class="portfolio-hover-title">
                            <div class="portfolio-content">
                                <h6><?php the_title() ;?></h6>
                                <div class="portfolio-category">
                                    <span><?php the_excerpt() ;?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            echo '</div>';

            wp_reset_query();
        }

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

    private function get_portfolio_tags($post_id){
        $tags = get_the_terms($post_id,'ptags');
        $_tags = [];
        foreach($tags as $tag){
            $_tags[$tag->term_id] = $tag->slug;
        }

        return join(' ',$_tags);
    }
}
