<?php
if (!defined('ABSPATH')) {
    exit;
}

class Follow_Us_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'follow_us';
    }
    
    public function get_title() {
        return 'Follow Us';
    }
    
    public function get_icon() {
        return 'eicon-social-icons';
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
        
        $this->add_control(
            'title',
            [
                'label' => 'Title',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '<p>Ignite the human spirit<br>through a movement.</p>',
            ]
        );
        
        $this->add_control(
            'button_text',
            [
                'label' => 'Button Text',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Follow Us',
            ]
        );
        
        $this->add_control(
            'button_link',
            [
                'label' => 'Button Link',
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://instagram.com/your_account',
                'default' => [
                    'url' => 'https://instagram.com/your_account',
                ],
            ]
        );
        
        $this->add_control(
            'banner_image',
            [
                'label' => 'Banner Image',
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
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
            'background_color',
            [
                'label' => 'Background Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f8f8f8',
                'selectors' => [
                    '{{WRAPPER}} .follow--us' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'title_color',
            [
                'label' => 'Title Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .follow--us-text h3' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'button_color',
            [
                'label' => 'Button Text Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .follow--us-text a' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'button_bg_color',
            [
                'label' => 'Button Background Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .follow--us-text a' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .follow--us-text h3',
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => 'Button Typography',
                'selector' => '{{WRAPPER}} .follow--us-text a',
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="follow--us">
            <div class="follow--us-wrapper">
                <div class="follow--us-content">
                    <div class="follow--us-column follow--us-text">
                        <h3><?php echo $settings['title']; ?></h3>
                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>"
                           <?php echo $settings['button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                           <?php echo $settings['button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    </div>
                    <div class="follow--us-column follow--us-banner">
                        <img src="<?php echo esc_url($settings['banner_image']['url']); ?>" alt="">
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}