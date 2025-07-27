<?php
if (!defined('ABSPATH')) {
    exit;
}

class Steps_Section_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'steps_section';
    }
    
    public function get_title() {
        return 'Steps Section';
    }
    
    public function get_icon() {
        return 'eicon-number-field';
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
            'main_title',
            [
                'label' => 'Main Title',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Simple steps to get your On.',
            ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'step_number',
            [
                'label' => 'Step Number',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '1',
            ]
        );
        
        $repeater->add_control(
            'step_description',
            [
                'label' => 'Step Description',
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Browse our catalog, and choose products you like to save to your wishlist.',
            ]
        );
        
        $this->add_control(
            'steps',
            [
                'label' => 'Steps',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'step_number' => '1',
                        'step_description' => 'Browse our catalog, and choose products you like to save to your wishlist.',
                    ],
                    [
                        'step_number' => '2',
                        'step_description' => 'Fill in your data and you\'ll be redirected to our Personal Shopper team on WhatsApp.',
                    ],
                    [
                        'step_number' => '3',
                        'step_description' => 'Our Personal Shopper team will assist your wishlist availability, product advice and payment.',
                    ],
                    [
                        'step_number' => '4',
                        'step_description' => 'Once payment is processed, prompt delivery will be arranged (same day service possible in Jakarta).',
                    ],
                ],
                'title_field' => 'Step {{{ step_number }}}',
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
            'main_title_color',
            [
                'label' => 'Main Title Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .step--title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'step_number_color',
            [
                'label' => 'Step Number Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .step--on-number' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'step_number_bg_color',
            [
                'label' => 'Step Number Background',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .step--on-number' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'step_description_color',
            [
                'label' => 'Step Description Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .step--on-detail p' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'main_title_typography',
                'label' => 'Main Title Typography',
                'selector' => '{{WRAPPER}} .step--title',
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'step_description_typography',
                'label' => 'Step Description Typography',
                'selector' => '{{WRAPPER}} .step--on-detail p',
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="step--on">
            <div class="step--on-wrapper">
                <div class="Container">
                    <h2 class="step--title"><?php echo esc_html($settings['main_title']); ?></h2>
                </div>
                <div class="Container Container-step">
                    <div class="step--on-list">
                        <?php foreach ($settings['steps'] as $step) : ?>
                            <div class="step--on-item">
                                <div class="step--on-content">
                                    <span class="step--on-number"><?php echo esc_html($step['step_number']); ?></span>
                                    <div class="step--on-detail">
                                        <p><?php echo esc_html($step['step_description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}