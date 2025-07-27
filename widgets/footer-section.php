<?php
if (!defined('ABSPATH')) {
    exit;
}

class Footer_Section_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'footer_section';
    }
    
    public function get_title() {
        return 'Footer Section';
    }
    
    public function get_icon() {
        return 'eicon-footer';
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
            'footer_title',
            [
                'label' => 'Footer Title',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => 'Need assistance? <a href="https://api.whatsapp.com/send?phone=6282289999707" target="_blank">Contact us.</a>',
            ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'menu_text',
            [
                'label' => 'Menu Text',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Terms and Conditions',
            ]
        );
        
        $repeater->add_control(
            'menu_link',
            [
                'label' => 'Menu Link',
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
            ]
        );
        
        $this->add_control(
            'footer_menu',
            [
                'label' => 'Footer Menu',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'menu_text' => 'Terms and Conditions',
                        'menu_link' => ['url' => '#'],
                    ],
                    [
                        'menu_text' => '7-Day Return policy',
                        'menu_link' => ['url' => '#'],
                    ],
                    [
                        'menu_text' => 'Stores',
                        'menu_link' => ['url' => '#'],
                    ],
                ],
                'title_field' => '{{{ menu_text }}}',
            ]
        );
        
        $this->add_control(
            'social_text',
            [
                'label' => 'Social Text',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '@your_account',
            ]
        );
        
        $this->add_control(
            'social_link',
            [
                'label' => 'Social Link',
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://instagram.com/your_account',
                'default' => [
                    'url' => 'https://instagram.com/your_account',
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
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .Footer' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .footer--title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'menu_color',
            [
                'label' => 'Menu Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .footer--menu-item a' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'social_color',
            [
                'label' => 'Social Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .footer--menu-social a' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .footer--title',
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'label' => 'Menu Typography',
                'selector' => '{{WRAPPER}} .footer--menu-item a',
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <footer class="Footer Footer--center" role="contentinfo">
            <div class="Container">
                <h3 class="footer--title"><?php echo $settings['footer_title']; ?></h3>
                <div class="footer--menu">
                    <div class="footer--menu-detail">
                        <?php foreach ($settings['footer_menu'] as $menu) : ?>
                            <div class="footer--menu-item">
                                <a href="<?php echo esc_url($menu['menu_link']['url']); ?>"
                                   <?php echo $menu['menu_link']['is_external'] ? 'target="_blank"' : ''; ?>
                                   <?php echo $menu['menu_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                    <?php echo esc_html($menu['menu_text']); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="footer--menu-social">
                        <svg class="Icon Icon--instagram" role="presentation" viewBox="0 0 32 32">
                            <path d="M15.994 2.886c4.273 0 4.775.019 6.464.095 1.562.07 2.406.33 2.971.552.749.292 1.283.635 1.841 1.194s.908 1.092 1.194 1.841c.216.565.483 1.41.552 2.971.076 1.689.095 2.19.095 6.464s-.019 4.775-.095 6.464c-.07 1.562-.33 2.406-.552 2.971-.292.749-.635 1.283-1.194 1.841s-1.092.908-1.841 1.194c-.565.216-1.41.483-2.971.552-1.689.076-2.19.095-6.464.095s-4.775-.019-6.464-.095c-1.562-.07-2.406-.33-2.971-.552-.749-.292-1.283-.635-1.841-1.194s-.908-1.092-1.194-1.841c-.216-.565-.483-1.41-.552-2.971-.076-1.689-.095-2.19-.095-6.464s.019-4.775.095-6.464c.07-1.562.33-2.406.552-2.971.292-.749.635-1.283 1.194-1.841s1.092-.908 1.841-1.194c.565-.216 1.41-.483 2.971-.552 1.689-.083 2.19-.095 6.464-.095zm0-2.883c-4.343 0-4.889.019-6.597.095-1.702.076-2.864.349-3.879.743-1.054.406-1.943.959-2.832 1.848S1.251 4.473.838 5.521C.444 6.537.171 7.699.095 9.407.019 11.109 0 11.655 0 15.997s.019 4.889.095 6.597c.076 1.702.349 2.864.743 3.886.406 1.054.959 1.943 1.848 2.832s1.784 1.435 2.832 1.848c1.016.394 2.178.667 3.886.743s2.248.095 6.597.095 4.889-.019 6.597-.095c1.702-.076 2.864-.349 3.886-.743 1.054-.406 1.943-.959 2.832-1.848s1.435-1.784 1.848-2.832c.394-1.016.667-2.178.743-3.886s.095-2.248.095-6.597-.019-4.889-.095-6.597c-.076-1.702-.349-2.864-.743-3.886-.406-1.054-.959-1.943-1.848-2.832S27.532 1.247 26.484.834C25.468.44 24.306.167 22.598.091c-1.714-.07-2.26-.089-6.603-.089zm0 7.778c-4.533 0-8.216 3.676-8.216 8.216s3.683 8.216 8.216 8.216 8.216-3.683 8.216-8.216-3.683-8.216-8.216-8.216zm0 13.549c-2.946 0-5.333-2.387-5.333-5.333s2.387-5.333 5.333-5.333 5.333 2.387 5.333 5.333-2.387 5.333-5.333 5.333zM26.451 7.457c0 1.059-.858 1.917-1.917 1.917s-1.917-.858-1.917-1.917c0-1.059.858-1.917 1.917-1.917s1.917.858 1.917 1.917z"></path>
                        </svg>
                        <a href="<?php echo esc_url($settings['social_link']['url']); ?>"
                           <?php echo $settings['social_link']['is_external'] ? 'target="_blank"' : ''; ?>
                           <?php echo $settings['social_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                            <?php echo esc_html($settings['social_text']); ?>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <?php
    }
}