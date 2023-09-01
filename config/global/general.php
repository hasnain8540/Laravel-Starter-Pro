<?php
return array(
    // Product
    'product' => array(
        'name'        => 'Milanus Jewelry Wholesal',
        'description' => 'Milanus Jewelry Wholesal',
        'preview'     => env('home' . 'https://milanus.test'),
        'home'        => env('home' . 'https://milanus.test'),
    ),

    // Meta
    'meta'    => array(
        'title'       => 'Milanus Jewelry Wholesale | Oro Laminado | Gold Filled | Gold Layered',
        'description' => 'Milanus Jewelry Wholesale | Oro Laminado | Gold Filled | Gold Layered',
        'keywords'    => 'Milanus Jewelry Wholesale | Oro Laminado | Gold Filled | Gold Layered',
        'canonical'   =>    env('home' . 'https://milanus.test'),
    ),

    // General
    'general' => array(
        'website'             => env('website' . 'https://milanus.test'),
        'about'               => env('about' . 'https://milanus.test'),
        'contact'             => env('contact' . 'mailto:support@milanus.test'),
        'support'             => env('website' . 'https://milanus.test'),
        'social-accounts'     => array(
            array(
                'name' => 'Youtube', 'url' => 'https://www.youtube.com/c/milanusTuts/videos', 'logo' => 'svg/social-logos/youtube.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Github', 'url' => 'https://github.com/milanusHub', 'logo' => 'svg/social-logos/github.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Twitter', 'url' => 'https://twitter.com/milanus', 'logo' => 'svg/social-logos/twitter.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Instagram', 'url' => 'https://www.instagram.com/milanus', 'logo' => 'svg/social-logos/instagram.svg', "class" => "h-20px",
            ),

            array(
                'name' => 'Facebook', 'url' => 'https://www.facebook.com/milanus', 'logo' => 'svg/social-logos/facebook.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Dribbble', 'url' => 'https://dribbble.com/milanus', 'logo' => 'svg/social-logos/dribbble.svg', "class" => "h-20px",
            ),
        ),
    ),

    //assets
    'assets' => array(
        'favicon' => 'media/logos/favicon.ico',
        'fonts'   => array(
            'google' => array(
                'Poppins:300,400,500,600,700',
            ),
        ),
        'css'     => array(
            'plugins/global/plugins.bundle.css',
            'plugins/global/plugins-custom.bundle.css',
            'css/style.bundle.css',
        ),
        'js'      => array(
            'plugins/global/plugins.bundle.js',
            'js/scripts.bundle.js',
            'js/custom/widgets.js',
        ),
    ),

    // Layout
    'layout' => array(
        // Main
        'main'          => array(
            'type'              => 'default', // Set layout type: default|blank|none
            'dark-mode-enabled' => false, // Enable optioanl dark mode mode
            'primary-color'     => '#009EF7', // Primary color used in email templates
            'page-bg-white'     => false, // Set true if page background color is white
        ),

        // Docs
        'docs'          => array(
            'logo-path'  => array(
                'default' => 'logos/logo-1.svg',
                'dark'    => 'logos/logo-1-dark.svg',
            ),
            'logo-class' => 'h-25px',
        ),


        // Illustration
        'illustrations' => array(
            'set' => 'sketchy-1',
        ),

        // Loader
        'loader'        => array(
            'display' => false,
            'type'    => 'default' // Set default|spinner-message|spinner-logo to hide or show page loader
        ),

        // Header
        'header'        => array(
            'width' => 'fluid', // Set header width(fixed|fluid)
            'fixed' => array(
                'tablet-and-mobile' => true // Set fixed header for talet & mobile
            ),
        ),


        // Aside
        'aside'         => array(
            'minimized' => false, // Set aside minimized by default
            'minimize'  => true, // Allow aside minimize toggle
        ),

        // Content
        'content'       => array(
            'width' => 'fixed', // Set content width(fixed|fluid)
        ),

        // Footer
        'footer'        => array(
            'width' => 'fluid' // Set fixed|fluid to change width type
        ),

        // Scrolltop
        'scrolltop'     => array(
            'display' => true // Display scrolltop
        ),


    ),

);
