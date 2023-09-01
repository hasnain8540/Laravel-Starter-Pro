<?php

return array(
    // Main menu
    'main'          => array(
        // Dashboard
        array(
            'classes' => array('content' => 'pb-4'),
            'title' => 'Dashboard',
            'path'  => '/',
            'middlewares' => ['auth'],
            'icon'  => theme()->getSvgIcon("media/icons/duotune/art/art002.svg", "svg-icon-2"),
        ),


        // Admin
        array(
            'title'      => 'Admin',
            'permission' => ['show module', 'show permission', 'show role', 'show user','show bin','show location group', 'show location'],
            'icon'       => array(
                'svg'  => theme()->getSvgIcon("media/icons/duotune/communication/com006.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-person fs-2"></i>',
            ),
            'classes'    => array('item' => 'menu-accordion'),
            'attributes' => array(
                "data-kt-menu-trigger" => "click",
            ),
            'sub' => array(
                'class' => 'menu-sub menu-sub-accordion menu-active-bg',
                'items' => array(
                    'class' => 'menu-sub-accordion menu-active-bg',
                    array(
                        'title'      => 'ACL',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => ['show module', 'show permission', 'show role', 'show user'],
                        'attributes' => array(
                            "data-kt-menu-trigger" => "click",
                        ),
                        'sub' => array(
                            'class' => 'menu-sub menu-sub-accordion menu-active-bg',
                            'items' => array(
                                'class' => 'menu-item',
                                array(
                                    'title'  => 'Modules',
                                    'permission' => 'show module',
                                    'path'   => 'module/index',
                                    'bullet' => '<span class="bullet bullet-dot"></span>',
                                ),
                                array(
                                    'title'  => 'Permissions',
                                    'permission' => 'show permission',
                                    'path'   => 'permission/index',
                                    'bullet' => '<span class="bullet bullet-dot"></span>',
                                ),
                                array(
                                    'title'      => 'Roles',
                                    'permission' => 'show role',
                                    'path'       => 'role/index',
                                    'bullet'     => '<span class="bullet bullet-dot"></span>',
                                ),
                                array(
                                    'title'  => 'Users',
                                    'permission' => 'show user',
                                    'path'   => 'user/index',
                                    'bullet' => '<span class="bullet bullet-dot"></span>',
                                ),
                            ),
                        ),

                    ),

                ),
            ),
        ),


        // System
        array(
            'title'      => 'System',
            'permission' => ['show system log', 'show audit log', 'show upc', 'show currency', 'show field', 'show storage setting'],
            'icon'       => array(
                'svg'  => theme()->getSvgIcon("media/icons/duotune/general/gen025.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-layers fs-3"></i>',
            ),
            'classes'    => array('item' => 'menu-accordion'),
            'attributes' => array(
                "data-kt-menu-trigger" => "click",
            ),
            'sub'        => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title'  => 'Audit Log',
                        'path'   => 'log/audit',
                        'permission' => 'show audit log',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'System Log',
                        'path'   => 'log/system',
                        'permission' => 'show system log',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                ),
            ),
        ),

    ),

    // Horizontal menu
    'horizontal'    => array(
        // Dashboard
        array(
            'title'   => 'Dashboard',
            'path'  => '/',
            'middlewares' => ['auth'],
            'classes' => array('item' => 'me-lg-1'),
        ),

        // Resources
        array(
            'title'      => 'Resources',
            'classes'    => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-kt-menu-trigger'   => "click",
                'data-kt-menu-placement' => "bottom-start",
            ),
            'sub'        => array(
                'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                'items' => array(
                    // Documentation
                    array(
                        'title' => 'Documentation',
                        'icon'  => theme()->getSvgIcon("media/icons/duotune/abstract/abs027.svg", "svg-icon-2"),
                        'path'  => 'documentation/getting-started/overview',
                    ),

                    // Changelog
                    array(
                        'title' => 'Changelog v' . theme()->getVersion(),
                        'icon'  => theme()->getSvgIcon("media/icons/duotune/general/gen005.svg", "svg-icon-2"),
                        'path'  => 'documentation/getting-started/changelog',
                    ),
                ),
            ),
        ),

        // Account
        array(
            'title'      => 'Account',
            'classes'    => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-kt-menu-trigger'   => "click",
                'data-kt-menu-placement' => "bottom-start",
            ),
            'sub'        => array(
                'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                'items' => array(
                    array(
                        'title'  => 'Overview',
                        'path'   => 'account/overview',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'Settings',
                        'path'   => 'account/settings',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'      => 'Security',
                        'path'       => '#',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "Coming soon",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // System
        array(
            'title'      => 'System',
            'classes'    => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-kt-menu-trigger'   => "click",
                'data-kt-menu-placement' => "bottom-start",
            ),
            'sub'        => array(
                'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                'items' => array(
                    array(
                        'title'      => 'Settings',
                        'path'       => '#',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "Coming soon",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'  => 'Audit Log',
                        'path'   => 'log/audit',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'System Log',
                        'path'   => 'log/system',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                ),
            ),
        ),
    ),
);
