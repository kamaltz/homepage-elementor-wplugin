jQuery(document).ready(function($) {
    
    // Initialize Category Banner Slider
    function initCategoryBanner() {
        $('.category--banner-list').each(function() {
            const $slider = $(this);
            const slidesToShow = parseInt($slider.data('slides-show')) || 2;
            const slidesToScroll = parseInt($slider.data('slides-scroll')) || 1;
            
            $slider.slick({
                dots: false,
                infinite: true,
                slidesToShow: slidesToShow,
                slidesToScroll: slidesToScroll,
                autoplay: true,
                autoplaySpeed: 4000,
                prevArrow: $slider.closest('.category--banner').find('.category--banner-nav .slick-prev'),
                nextArrow: $slider.closest('.category--banner').find('.category--banner-nav .slick-next'),
                responsive: [
                    {
                        breakpoint: 641,
                        settings: {
                            slidesToShow: 1,
                            dots: true
                        }
                    }
                ]
            });
        });
        

    }
    
    // Initialize on page load
    initCategoryBanner();
    
    // Initialize Steps Section Slider for mobile
    function initStepsSection() {
        if (window.matchMedia('(max-width: 640px)').matches) {
            if (!$('.step--on-list').hasClass('slick-initialized')) {
                $('.step--on-list').slick({
                    dots: false,
                    arrows: false,
                    infinite: false,
                    slidesToShow: 1.5,
                    slidesToScroll: 1
                });
            }
        } else {
            if ($('.step--on-list').hasClass('slick-initialized')) {
                $('.step--on-list').slick('unslick');
            }
        }
    }
    
    initStepsSection();
    
    // Reinitialize on window resize
    $(window).on('resize', function() {
        initStepsSection();
    });
    
    // Reinitialize when Elementor editor updates
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/category_banner.default', function($scope) {
            $scope.find('.category--banner-list').slick('unslick');
            initCategoryBanner();
        });
        
        elementorFrontend.hooks.addAction('frontend/element_ready/steps_section.default', function($scope) {
            initStepsSection();
        });
    }
    
    // Responsive image handling
    function handleResponsiveImages() {
        const $window = $(window);
        const breakpoint = 768;
        
        function toggleImages() {
            if ($window.width() <= breakpoint) {
                $('.hidden-phone').hide();
                $('.hidden-tablet-and-up').show();
            } else {
                $('.hidden-phone').show();
                $('.hidden-tablet-and-up').hide();
            }
        }
        
        toggleImages();
        $window.on('resize', toggleImages);
    }
    
    handleResponsiveImages();
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        
        const target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
    
    // Add loading animation for images
    $('img').on('load', function() {
        $(this).addClass('loaded');
    });
    
    // Lazy loading for better performance
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Add hover effects for interactive elements
    $('.category--banner-item').on('mouseenter', function() {
        $(this).find('img').css('transform', 'scale(1.05)');
    }).on('mouseleave', function() {
        $(this).find('img').css('transform', 'scale(1)');
    });
    
    // Add transition effects for images
    $('.category--banner-item img, .follow--us-banner img').css({
        'transition': 'transform 0.3s ease',
        'transform-origin': 'center center'
    });
    
    // Mobile menu toggle (if needed)
    $('.mobile-menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.mobile-menu').toggleClass('open');
    });
    
    // Form validation and enhancement
    $('form').on('submit', function(e) {
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        
        // Add loading state
        $submitBtn.prop('disabled', true).text('Loading...');
        
        // Re-enable after 3 seconds (adjust as needed)
        setTimeout(() => {
            $submitBtn.prop('disabled', false).text($submitBtn.data('original-text') || 'Submit');
        }, 3000);
    });
    
    // Store original button text
    $('button[type="submit"]').each(function() {
        $(this).data('original-text', $(this).text());
    });
    
    // Add animation classes when elements come into view
    if ('IntersectionObserver' in window) {
        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.1
        });
        
        document.querySelectorAll('.step--on-item, .follow--us-text, .footer--title').forEach(el => {
            animationObserver.observe(el);
        });
    }
    
    // Add CSS for animations
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .step--on-item,
            .follow--us-text,
            .footer--title {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            
            .step--on-item.animate-in,
            .follow--us-text.animate-in,
            .footer--title.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
            
            .step--on-item:nth-child(2) { transition-delay: 0.1s; }
            .step--on-item:nth-child(3) { transition-delay: 0.2s; }
            .step--on-item:nth-child(4) { transition-delay: 0.3s; }
        `)
        .appendTo('head');
});