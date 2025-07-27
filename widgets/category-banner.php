<?php
if (!defined('ABSPATH')) {
    exit;
}

class Category_Banner_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'category_banner';
    }
    
    public function get_title() {
        return 'Category Banner';
    }
    
    public function get_icon() {
        return 'eicon-slider-push';
    }
    
    public function get_categories() {
        return ['homepage-elements'];
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Content',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'image',
            [
                'label' => 'Image',
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $repeater->add_control(
            'title',
            [
                'label' => 'Title',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Performance',
            ]
        );
        
        $repeater->add_control(
            'subtitle',
            [
                'label' => 'Subtitle',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'All Day',
            ]
        );
        
        $repeater->add_control(
            'link',
            [
                'label' => 'Link',
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
            ]
        );
        
        $this->add_control(
            'banners',
            [
                'label' => 'Category Banners',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => 'Performance',
                        'subtitle' => 'All Day',
                    ],
                    [
                        'title' => 'Performance',
                        'subtitle' => 'Running',
                    ],
                ],
                'title_field' => '{{{ title }}} {{{ subtitle }}}',
            ]
        );
        
        $this->add_control(
            'slides_to_show',
            [
                'label' => 'Slides to Show',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2,
                'min' => 1,
                'max' => 6,
            ]
        );
        
        $this->add_control(
            'slides_to_scroll',
            [
                'label' => 'Slides to Scroll',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 6,
            ]
        );
        
        $this->end_controls_section();
        
        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'title_color',
            [
                'label' => 'Title Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .category--banner-heading' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'subtitle_color',
            [
                'label' => 'Subtitle Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .category--banner-subheading' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .category--banner-heading',
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => 'Subtitle Typography',
                'selector' => '{{WRAPPER}} .category--banner-subheading',
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="category--banner">
            <div class="category--banner-wrapper">
                <div class="category--banner-list" data-slides-show="<?php echo esc_attr($settings['slides_to_show']); ?>" data-slides-scroll="<?php echo esc_attr($settings['slides_to_scroll']); ?>">
                    <?php foreach ($settings['banners'] as $banner) : ?>
                        <div class="category--banner-item">
                            <?php if (!empty($banner['link']['url'])) : ?>
                                <a href="<?php echo esc_url($banner['link']['url']); ?>" 
                                   <?php echo $banner['link']['is_external'] ? 'target="_blank"' : ''; ?>
                                   <?php echo $banner['link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                            <?php endif; ?>
                            
                            <img src="<?php echo esc_url($banner['image']['url']); ?>" 
                                 alt="<?php echo esc_attr($banner['title']); ?>">
                            
                            <?php if (!empty($banner['link']['url'])) : ?>
                                </a>
                            <?php endif; ?>
                            
                            <div class="category--banner-content">
                                <div class="Container">
                                    <?php if (!empty($banner['link']['url'])) : ?>
                                        <a href="<?php echo esc_url($banner['link']['url']); ?>" 
                                           <?php echo $banner['link']['is_external'] ? 'target="_blank"' : ''; ?>
                                           <?php echo $banner['link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                    <?php endif; ?>
                                    
                                    <h3 class="category--banner-heading"><?php echo esc_html($banner['title']); ?></h3>
                                    <p class="category--banner-subheading"><?php echo esc_html($banner['subtitle']); ?></p>
                                    
                                    <?php if (!empty($banner['link']['url'])) : ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="category--banner-nav">
                    <div class="Container">
                        <div class="nav--prev-next">
                            <button class="slick-prev slick-arrow">
                                <svg width="57" height="57" viewBox="0 0 57 57" fill="none">
                                    <circle cx="28.5" cy="28.5" r="28" stroke="white" fill="rgba(0,0,0,0.3)"/>
                                    <path d="M32 20L24 28L32 36" stroke="white" stroke-width="2" fill="none"/>
                                </svg>
                            </button>
                            <button class="slick-next slick-arrow">
                                <svg width="57" height="57" viewBox="0 0 57 57" fill="none">
                                    <circle cx="28.5" cy="28.5" r="28" stroke="white" fill="rgba(0,0,0,0.3)"/>
                                    <path d="M25 20L33 28L25 36" stroke="white" stroke-width="2" fill="none"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}