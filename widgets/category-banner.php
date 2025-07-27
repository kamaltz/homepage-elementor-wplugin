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
        
        $this->add_control(
            'show_arrows',
            [
                'label' => 'Show Arrows',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'show_dots',
            [
                'label' => 'Show Dots',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        
        $this->add_control(
            'arrow_position',
            [
                'label' => 'Arrow Position',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom-right',
                'options' => [
                    'bottom-right' => 'Bottom Right',
                    'bottom-left' => 'Bottom Left',
                    'bottom-center' => 'Bottom Center',
                    'center-sides' => 'Center Sides',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'caption_position',
            [
                'label' => 'Caption Position',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom-left',
                'options' => [
                    'bottom-left' => 'Bottom Left',
                    'bottom-center' => 'Bottom Center',
                    'bottom-right' => 'Bottom Right',
                    'center-left' => 'Center Left',
                    'center-center' => 'Center Center',
                    'center-right' => 'Center Right',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'image_height',
            [
                'label' => 'Image Height',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'vh',
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .category--banner-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'image_object_fit',
            [
                'label' => 'Image Fit',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => 'Cover',
                    'contain' => 'Contain',
                    'fill' => 'Fill',
                    'none' => 'None',
                ],
                'selectors' => [
                    '{{WRAPPER}} .category--banner-item img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'image_object_position',
            [
                'label' => 'Image Position',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'center' => 'Center',
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right',
                    'top left' => 'Top Left',
                    'top right' => 'Top Right',
                    'bottom left' => 'Bottom Left',
                    'bottom right' => 'Bottom Right',
                ],
                'selectors' => [
                    '{{WRAPPER}} .category--banner-item img' => 'object-position: {{VALUE}};',
                ],
                'condition' => [
                    'image_object_fit!' => 'fill',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => 'Border Radius',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category--banner-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
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
        
        // Caption Style Section
        $this->start_controls_section(
            'caption_style_section',
            [
                'label' => 'Caption Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'caption_bg_color',
            [
                'label' => 'Caption Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.7)',
                'selectors' => [
                    '{{WRAPPER}} .category--banner-content' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'caption_padding',
            [
                'label' => 'Caption Padding',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '60',
                    'right' => '0',
                    'bottom' => '40',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .category--banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'caption_text_align',
            [
                'label' => 'Text Alignment',
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => 'Left',
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => 'Center',
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => 'Right',
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .category--banner-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Arrow Style Section
        $this->start_controls_section(
            'arrow_style_section',
            [
                'label' => 'Arrow Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'arrow_size',
            [
                'label' => 'Arrow Size',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 57,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );
        
        $this->add_control(
            'arrow_color',
            [
                'label' => 'Arrow Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow svg path' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'arrow_bg_color',
            [
                'label' => 'Arrow Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.3)',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'arrow_border_color',
            [
                'label' => 'Arrow Border',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255,255,255,0.8)',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'arrow_hover_bg',
            [
                'label' => 'Arrow Hover Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255,255,255,0.9)',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'arrow_hover_color',
            [
                'label' => 'Arrow Hover Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover svg path' => 'stroke: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="category--banner" data-arrow-position="<?php echo esc_attr($settings['arrow_position']); ?>" data-caption-position="<?php echo esc_attr($settings['caption_position']); ?>" data-show-dots="<?php echo esc_attr($settings['show_dots']); ?>">
            <div class="category--banner-wrapper">
                <div class="category--banner-list" data-slides-show="<?php echo esc_attr($settings['slides_to_show']); ?>" data-slides-scroll="<?php echo esc_attr($settings['slides_to_scroll']); ?>" data-show-dots="<?php echo esc_attr($settings['show_dots']); ?>">
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
                <?php if ($settings['show_arrows'] === 'yes') : ?>
                <div class="category--banner-nav">
                    <div class="nav--prev-next">
                        <button class="slick-prev slick-arrow" type="button">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button class="slick-next slick-arrow" type="button">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}