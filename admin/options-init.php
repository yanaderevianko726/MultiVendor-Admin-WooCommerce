<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "mstoreapp_flutter_options";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

       // global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => 'Mstoreapp Flutter Options',
        // Name that appears at the top of your panel
        'display_version'      => '0.0.1',
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Flutter Options', 'redux-framework' ),
        'page_title'           => __( 'Flutter Options', 'redux-framework' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.
        'show_options_object' => false,

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
      
    );



    Redux::setArgs( $opt_name, $args );
   

    // -> START Media Uploads
    Redux::setSection( $opt_name, array(
        'title' => __( 'Banner Blocks', 'redux-framework' ),
        'id'    => 'banner_blocks_flutter',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 1', 'redux-framework' ),
        'id'         => 'banner_blocks_1',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_1',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'block_type_1',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_1',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_1',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_1',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_1',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_1',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'slider',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_1',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_1',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_1',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_1',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'borderRadius_1',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'elevation_1',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_1',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_1',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'For Flutter Enter in width in dp. For ionic Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 100,
            ),
            array(
                'id'       => 'sort_1',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_1',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
                /*'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),*/
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 2', 'redux-framework' ),
        'id'         => 'slides_2',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_2',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_2',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_2',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_2',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_2',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_2',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_2',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_2',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_2',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_2',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 10,
            ),
            array(
                'id'       => 'borderRadius_2',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_2',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_2',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_2',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_2',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_2',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_2',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );


Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 3', 'redux-framework' ),
        'id'         => 'slides_3',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_3',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_3',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_3',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_3',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select3'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_3',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_3',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_3',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select3'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_3',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_3',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_3',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_3',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_3',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_3',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_3',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_3',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_3',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_3',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 4', 'redux-framework' ),
        'id'         => 'slides_4',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_4',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_4',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_4',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_4',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select4'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_4',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_4',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_4',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select4'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_4',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_4',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_4',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_4',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_4',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_4',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_4',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_4',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_4',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_4',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 5', 'redux-framework' ),
        'id'         => 'slides_5',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_5',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_5',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_5',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_5',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_5',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_5',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_5',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_5',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_5',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_5',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_5',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_5',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_5',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_5',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_5',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_5',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_5',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 6', 'redux-framework' ),
        'id'         => 'slides_6',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_6',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_6',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_6',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_6',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_6',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_6',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_6',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_6',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_6',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_6',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_6',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_6',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_6',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_6',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_6',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_6',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_6',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 7', 'redux-framework' ),
        'id'         => 'slides_7',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_7',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_7',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_7',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_7',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_7',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_7',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_7',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_7',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_7',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_7',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_7',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_7',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_7',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_7',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_7',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_7',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_7',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 8', 'redux-framework' ),
        'id'         => 'slides_8',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_8',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_8',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_8',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_8',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_8',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_8',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_8',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'scroll'    => 'Scroll',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_8',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_8',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_8',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_8',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_8',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_8',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_8',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_8',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_8',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_8',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 9', 'redux-framework' ),
        'id'         => 'slides_9',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_9',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_9',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_9',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_9',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_9',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_9',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_9',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_9',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_9',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_9',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_9',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_9',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_9',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_9',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_9',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_9',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_9',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Banner Block 10', 'redux-framework' ),
        'id'         => 'slides_10',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_10',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_10',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'banner_block',
            ),
            array(
                'id'       => 'title_10',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_10',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_10',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_10',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_10',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'slider'    => 'Slider',
                    'slider1'   => 'Slider 1',
                    'slider2'   => 'Slider 2',
                    'slider3'   => 'Slider 3',
                    'slider4'   => 'Slider 4',
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select5'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_10',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_10',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_10',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_10',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_10',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_10',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_10',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_10',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_10',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'          => 'slides_10',
                'type'        => 'slides',
                'title'       => __( 'Banners', 'redux-framework' ),
                'subtitle' => 'Add Banners',
                'desc'     => __( 'Add proper link id, category id or products id or post id. Add link type as product or category or post accordingly', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title (e.g., Product, Category, About Us etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., category, product, post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Category id, or Product id, or Post id, or Page id, or url ( url when above type is link ) (e.g., 1, 20, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );



    // -> Category Blocks
    Redux::setSection( $opt_name, array(
        'title' => __( 'Category Blocks', 'redux-framework' ),
        'id'    => 'category_blocks',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Category Block 1', 'redux-framework' ),
        'id'         => 'slides_11',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_11',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'block_type_11',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'category_block',
            ),
            array(
                'id'       => 'title_11',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'link_id_11',
                'type'     => 'text',
                'title'    => 'Main category id',
                'subtitle' => 'Enter main category id',
                'desc'     => __( 'Enter main category id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'header_align_11',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_11',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_11',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_11',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid',
                    'expandable'  => 'Expandable'
                ),
                'default'  => 'grid',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_11',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_11',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '10px', 
                    'padding-right'   => '10px', 
                    'padding-bottom'  => '10px', 
                    'padding-left'    => '10px',
                )
            ),
            array(
                'id'       => 'paddingBetween_11',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 10,
            ),
            array(
                'id'       => 'borderRadius_11',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 4,
            ),
            array(
                'id'       => 'item_per_row_11',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_11',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 1,
            ),
            array(
                'id'       => 'child_height_11',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'child_width_11',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_11',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Category Block 2', 'redux-framework' ),
        'id'         => 'slides_12',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_12',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_12',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'category_block',
            ),
            array(
                'id'       => 'title_12',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'link_id_12',
                'type'     => 'text',
                'title'    => 'Main category id',
                'subtitle' => 'Enter main category id',
                'desc'     => __( 'Enter main category id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'header_align_12',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_12',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_12',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_12',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid',
                    'expandable'  => 'Expandable'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_12',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_12',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_12',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_12',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_12',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_12',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_12',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_12',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_12',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Category Block 3', 'redux-framework' ),
        'id'         => 'slides_13',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_13',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_13',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'category_block',
            ),
            array(
                'id'       => 'title_13',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'link_id_13',
                'type'     => 'text',
                'title'    => 'Main category id',
                'subtitle' => 'Enter main category id',
                'desc'     => __( 'Enter main category id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'header_align_13',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_13',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_13',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_13',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid',
                    'expandable'  => 'Expandable'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_13',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_13',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_13',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_13',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_13',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_13',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_13',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_13',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_13',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Category Block 4', 'redux-framework' ),
        'id'         => 'slides_14',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_14',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_14',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'category_block',
            ),
            array(
                'id'       => 'title_14',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'link_id_14',
                'type'     => 'text',
                'title'    => 'Main category id',
                'subtitle' => 'Enter main category id',
                'desc'     => __( 'Enter main category id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'header_align_14',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_14',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_14',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_14',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid',
                    'expandable'  => 'Expandable'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_14',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_14',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_14',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_14',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_14',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_14',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_14',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_14',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_14',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Category Block 5', 'redux-framework' ),
        'id'         => 'slides_15',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_15',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'block_type_15',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'category_block',
            ),
            array(
                'id'       => 'title_15',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'link_id_15',
                'type'     => 'text',
                'title'    => 'Main category id',
                'subtitle' => 'Enter main category id',
                'desc'     => __( 'Enter main category id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'header_align_15',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_15',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_15',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_15',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid',
                    'expandable'  => 'Expandable'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_15',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_15',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_15',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_15',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_15',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_15',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_15',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_15',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_15',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

// -> Products Block
    Redux::setSection( $opt_name, array(
        'title' => __( 'Products Blocks', 'redux-framework' ),
        'id'    => 'products_blocks',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Products Block 1', 'redux-framework' ),
        'id'         => 'slides_16',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_16',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_16',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_16',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_16',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'product_block',
            ),
            array(
                'id'       => 'title_16',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_16',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_16',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_16',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_16',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_16',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_16',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_16',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_16',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_16',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_16',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_16',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_16',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_16',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Products Block 2', 'redux-framework' ),
        'id'         => 'slides_17',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_17',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_17',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_17',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_17',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'product_block',
            ),
            array(
                'id'       => 'title_17',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_17',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_17',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_17',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_17',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_17',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_17',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_17',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_17',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_17',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_17',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_17',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_17',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_17',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Products Block 3', 'redux-framework' ),
        'id'         => 'slides_18',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_18',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_18',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_18',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_18',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'product_block',
            ),
            array(
                'id'       => 'title_18',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_18',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_18',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_18',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_18',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_18',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_18',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_18',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_18',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_18',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_18',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_18',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_18',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_18',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Products Block 4', 'redux-framework' ),
        'id'         => 'slides_19',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_19',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_19',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_19',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_19',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'product_block',
            ),
            array(
                'id'       => 'title_19',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_19',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_19',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_19',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_19',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_19',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_19',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_19',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_19',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_19',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_19',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_19',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_19',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_19',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Products Block 5', 'redux-framework' ),
        'id'         => 'slides_20',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_20',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_20',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_20',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_20',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'product_block',
            ),
            array(
                'id'       => 'title_20',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_20',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_20',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_20',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_20',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_20',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_20',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_20',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_20',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_20',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_20',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_20',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_20',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_20',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __( 'Splash Screen', 'redux-framework' ),
        'id'    => 'splash_screen_blocks',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Splash Screen (Supports upto 5 Splash Screen)', 'redux-framework' ),
        'id'         => 'splash_screen_section',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'          => 'splash_screens',
                'type'        => 'slides',
                'title'       => __( 'Splash Screen', 'redux-framework' ),
                'subtitle' => 'Add Splash Screen',
                'desc'     => __( 'Add Splash Screen. You can upload 5 splash screens. display randomly. It will dsiplay default splsh screen when empty', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Title', 'redux-framework' ),
                    'description' => __( 'Description', 'redux-framework' ),
                    'url'         => __( 'Url', 'redux-framework' ),
                ),
            ),
        )
    ) );


    // -> Flash Sale BLock
    Redux::setSection( $opt_name, array(
        'title' => __( 'Flash Sale Blocks', 'redux-framework' ),
        'id'    => 'flash_sale_blocks',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Flash Sale BLock 1', 'redux-framework' ),
        'id'         => 'slides_21',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_21',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_21',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_21',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_21',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'flash_sale_block',
            ),
            array(
                'id'       => 'sale_ends_21',
                'type'     => 'date',
                'date-min'      => 0,
                'date-max'      => 30,
                'num-of-months' => 2,
                'title'    => __( 'Flash Sale End Date', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Flash Sale end date', 'redux-framework-demo' ),
                'desc'     => __( 'This will allow you to set end date for flash sale.', 'redux-framework-demo' )
            ),
            array(
                'id'       => 'title_21',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_21',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_21',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_21',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_21',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_21',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_21',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_21',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_21',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_21',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_21',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_21',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_21',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_21',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Flash Sale BLock 2', 'redux-framework' ),
        'id'         => 'slides_22',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_22',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_22',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_22',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_22',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'flash_sale_block',
            ),
            array(
                'id'       => 'sale_ends_22',
                'type'     => 'date',
                'date-min'      => 0,
                'date-max'      => 30,
                'num-of-months' => 2,
                'title'    => __( 'Flash Sale End Date', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Flash Sale end date', 'redux-framework-demo' ),
                'desc'     => __( 'This will allow you to set end date for flash sale.', 'redux-framework-demo' )
            ),
            array(
                'id'       => 'title_22',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_22',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_22',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_22',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_22',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_22',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_22',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_22',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_22',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_22',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_22',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_22',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_22',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_22',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Flash Sale BLock 3', 'redux-framework' ),
        'id'         => 'slides_23',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_23',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_23',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_23',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_23',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'flash_sale_block',
            ),
            array(
                'id'       => 'sale_ends_23',
                'type'     => 'date',
                'date-min'      => 0,
                'date-max'      => 30,
                'num-of-months' => 2,
                'title'    => __( 'Flash Sale End Date', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Flash Sale end date', 'redux-framework-demo' ),
                'desc'     => __( 'This will allow you to set end date for flash sale.', 'redux-framework-demo' )
            ),
            array(
                'id'       => 'title_23',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_23',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_23',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_23',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_23',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_23',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_23',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_23',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_23',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_23',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_23',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_23',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_23',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_23',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Flash Sale BLock 4', 'redux-framework' ),
        'id'         => 'slides_24',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_24',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_24',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_24',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_24',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'flash_sale_block',
            ),
            array(
                'id'       => 'sale_ends_24',
                'type'     => 'date',
                'date-min'      => 0,
                'date-max'      => 30,
                'num-of-months' => 2,
                'title'    => __( 'Flash Sale End Date', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Flash Sale end date', 'redux-framework-demo' ),
                'desc'     => __( 'This will allow you to set end date for flash sale.', 'redux-framework-demo' )
            ),
            array(
                'id'       => 'title_24',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_24',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_24',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_24',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_24',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_24',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_24',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_24',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_24',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_24',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_24',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_24',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_24',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_24',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

Redux::setSection( $opt_name, array(
        'title'      => __( 'Flash Sale BLock 5', 'redux-framework' ),
        'id'         => 'slides_25',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_25',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_25',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'link_id_25',
                'type'     => 'text',
                'title'    => 'Category id or Product tag id',
                'subtitle' => 'Enter category id or product tag id id',
                'desc'     => __( 'This will allow you to filter products by category id or product tag id', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'block_type_25',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'flash_sale_block',
            ),
            array(
                'id'       => 'sale_ends_25',
                'type'     => 'date',
                'date-min'      => 0,
                'date-max'      => 30,
                'num-of-months' => 2,
                'title'    => __( 'Flash Sale End Date', 'redux-framework-demo' ),
                'subtitle' => __( 'Choose Flash Sale end date', 'redux-framework-demo' ),
                'desc'     => __( 'This will allow you to set end date for flash sale.', 'redux-framework-demo' )
            ),
            array(
                'id'       => 'title_25',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_25',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_25',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_25',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_25',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_25',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_25',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'borderRadius_25',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_25',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_25',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_25',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'paddingBetween_25',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_width_25',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_25',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

    // -> Vendor BLock
    Redux::setSection( $opt_name, array(
        'title' => __( 'Vendor Blocks', 'redux-framework' ),
        'id'    => 'vendor_blocks',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Vendor BLock 1', 'redux-framework' ),
        'id'         => 'slides_26',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_26',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_26',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'filter_by_26',
                'type'     => 'text',
                'title'    => 'Type Of Vendor',
                'subtitle' => 'This will allow you to filter vendor by type',
                'desc'     => __( 'Eg. grocery, bakery, restaurant, medical. Type that entered in edit user page. Supports multiple value seperated by space.', 'redux-framework' ),
                'default'  => 'all',
            ),
            array(
                'id'       => 'block_type_26',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'vendor_block',
            ),
            array(
                'id'       => 'title_26',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_26',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_26',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_26',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_26',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_26',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_26',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_26',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_26',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_26',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_26',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_26',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_26',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_26',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Vendor BLock 2', 'redux-framework' ),
        'id'         => 'slides_27',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_27',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_27',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'filter_by_27',
                'type'     => 'text',
                'title'    => 'Type Of Vendor',
                'subtitle' => 'This will allow you to filter vendor by type',
                'desc'     => __( 'Eg. grocery, bakery, restaurant, medical. Type you entered in edit user page. Supports multiple value seperated by space.', 'redux-framework' ),
                'default'  => 'all',
            ),
            array(
                'id'       => 'block_type_27',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'vendor_block',
            ),
            array(
                'id'       => 'title_27',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_27',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_27',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_27',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_27',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_27',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_27',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_27',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_27',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_27',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_27',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_27',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_27',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_27',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Vendor BLock 3', 'redux-framework' ),
        'id'         => 'slides_28',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_28',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_28',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'filter_by_28',
                'type'     => 'text',
                'title'    => 'Type Of Vendor',
                'subtitle' => 'This will allow you to filter vendor by type',
                'desc'     => __( 'Eg. grocery, bakery, restaurant, medical. Type you entered in edit user page. Supports multiple value seperated by space.', 'redux-framework' ),
                'default'  => 'all',
            ),
            array(
                'id'       => 'block_type_28',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'vendor_block',
            ),
            array(
                'id'       => 'title_28',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_28',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_28',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_28',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_28',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_28',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_28',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_28',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_28',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_28',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_28',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_28',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_28',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_28',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Vendor BLock 4', 'redux-framework' ),
        'id'         => 'slides_29',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_29',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_29',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'filter_by_29',
                'type'     => 'text',
                'title'    => 'Type Of Vendor',
                'subtitle' => 'This will allow you to filter vendor by type',
                'desc'     => __( 'Eg. grocery, bakery, restaurant, medical. Type you entered in edit user page. Supports multiple value seperated by space.', 'redux-framework' ),
                'default'  => 'all',
            ),
            array(
                'id'       => 'block_type_29',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'vendor_block',
            ),
            array(
                'id'       => 'title_29',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_29',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_29',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_29',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_29',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_29',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_29',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_29',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_29',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_29',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_29',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_29',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_29',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_29',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Vendor BLock 5', 'redux-framework' ),
        'id'         => 'slides_30',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switch_30',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the block.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'filter_by_30',
                'type'     => 'button_set',
                'title'    => __( 'Filter Products By', 'redux-framework-demo' ),
                'subtitle' => __( 'This will allow you to filter products by category id or tag id.', 'redux-framework-demo' ),
                'options'  => array(
                    'category' => 'Category ID',
                    'tag' => 'Tag ID'
                ),
                'default'  => 'category'
            ),
            array(
                'id'       => 'filter_by_30',
                'type'     => 'text',
                'title'    => 'Type Of Vendor',
                'subtitle' => 'This will allow you to filter vendor by type',
                'desc'     => __( 'Eg. grocery, bakery, restaurant, medical. Type you entered in edit user page. Supports multiple value seperated by space.', 'redux-framework' ),
                'default'  => 'all',
            ),
            array(
                'id'       => 'block_type_30',
                'type'     => 'hidden',
                'readonly' => true,
                'default' => 'vendor_block',
            ),
            array(
                'id'       => 'title_30',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework' ),
                'subtitle' => __( 'Enter block title', 'redux-framework' ),
            ),
            array(
                'id'       => 'header_align_30',
                'type'     => 'select',
                'title'    => 'Title Align',
                'subtitle' => 'Select title align',
                'options'  => array(
                    'top_left'    => 'Left',
                    'top_right'    => 'Right',
                    'top_center'  => 'Middle',
                    'left_floating' => 'Floating Left',
                    'none'  => 'None'
                ),
                'default'  => 'none',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'title_color_30',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Title Color', 'redux-framework' ),
                'subtitle' => __( 'Choose the title color.', 'redux-framework' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'background_color_30',
                'type'     => 'color',
                'output'   => array( '.site-title' ),
                'title'    => __( 'Background color', 'redux-framework' ),
                'subtitle' => __( 'Choose the background color you want.', 'redux-framework' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'style_30',
                'type'     => 'select',
                'title'    => 'Select Style',
                'subtitle' => 'Select a style you want',
                'options'  => array(
                    'scroll'    => 'Scroll',
                    'grid'  => 'Grid'
                ),
                'default'  => 'scroll',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'             => 'margin_30',
                'type'           => 'spacing',
                'mode'           => 'margin',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Margin', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or margin.', 'redux-framework'),
                'default'            => array(
                    'margin-top'     => '0px', 
                    'margin-right'   => '0px', 
                    'margin-bottom'  => '0px', 
                    'margin-left'    => '0px',
                )
            ),
            array(
                'id'             => 'padding_30',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => __('Set Padding', 'redux-framework'),
                'subtitle'           => __('Choose the spacing or padding.', 'redux-framework'),
                'default'            => array(
                    'padding-top'     => '0px', 
                    'padding-right'   => '0px', 
                    'padding-bottom'  => '0px', 
                    'padding-left'    => '0px',
                )
            ),
            array(
                'id'       => 'paddingBetween_30',
                'type'     => 'text',
                'title'    => 'Margin between banners',
                'subtitle' => 'This will allow you to set distance between bannner',
                'desc'     => __( 'This will allow You to set distance between items.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'borderRadius_30',
                'type'     => 'text',
                'title'    => __( 'Enter Border Radius', 'redux-framework' ),
                'subtitle' => __( 'This will allow You to add border radius to banner or product or category.', 'redux-framework' ),
                'desc'     => __( 'This will apply for only flutter app', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'item_per_row_30',
                'type'     => 'select',
                'title'    => 'Item per row',
                'subtitle' => 'Select Item per row',
                'desc' => 'This will allow you to set number of item per line for grid layout',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'elevation_30',
                'type'     => 'text',
                'title'    => 'Set Elevation',
                'subtitle' => 'This will allow you to set box shadow',
                'desc'     => __( 'Enter Elevation 1, 2, 3, 4 or 5.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 0,
            ),
            array(
                'id'       => 'child_height_30',
                'type'     => 'text',
                'title'    => 'Set height',
                'subtitle' => 'This will allow your to set height in cluding padding for block',
                'desc'     => __( 'Enter Height including padding in dp. only applicable for scroll layout', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 300,
            ),
            array(
                'id'       => 'child_width_30',
                'type'     => 'text',
                'title'    => 'Set width',
                'subtitle' => 'This will allow your to set width for banner or product or category',
                'desc'     => __( 'Enter Width in %. 50 for 2, 33 for 3, 25 for 4, 20 for 4 items in a row. For scroll items set 53 for 1 and half and 33 for 2 and half and so on', 'redux-framework' ),
                'default'  => 200,
            ),
            array(
                'id'       => 'sort_30',
                'type'     => 'text',
                'title'    => 'Sort Order',
                'subtitle' => 'Enter sort order',
                'desc'     => __( 'Provide a numerical value for sort order.', 'redux-framework' ),
                'default'  => 0,
            )
        )
    ) );

    // -> Pages
    Redux::setSection( $opt_name, array(
        'title' => __( 'Page Layouts', 'redux-framework' ),
        'id'    => 'opt_page_layout',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Page Layouts', 'redux-framework' ),
        'id'         => 'mstoreapp_page_layout',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'category_page_layout',
                'type'     => 'select',
                'title'    => 'Category Page',
                'subtitle' => 'Select category page layout',
                'options'  => array(
                    'layout1'    => 'Split Layout',
                    'layout2'    => 'List View',
                    'layout3'    => 'List View 2',
                    'layout6'    => 'List View 3',
                    'layout7'    => 'List View 4',
                    'layout8'    => 'List View 5',
                    'layout5'    => 'Split Layout 2',
                    'layout4'    => 'Expandable',
                    'layout9'    => 'Expandable 2',
                ),
                'default'  => 'layout1',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'stores_page_layout',
                'type'     => 'select',
                'title'    => 'Store Page',
                'subtitle' => 'Select store page layout',
                'options'  => array(
                    'layout1'    => 'Grid 1',
                    'layout2'    => 'Grid 2',
                    'layout3'    => 'List View 1',
                    'layout4'    => 'List View 2',
                    'layout5'    => 'List View 3',
                    'layout6'    => 'List View 4',
                    'layout7'    => 'List View 5',
                ),
                'default'  => 'layout1',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'login_page_layout',
                'type'     => 'select',
                'title'    => 'Login Page',
                'subtitle' => 'Select login page layout',
                'options'  => array(
                    'layout1'    => 'Layout 1',
                    'layout2'    => 'Layout 2',
                    'layout3'    => 'Layout 3',
                    'layout4'    => 'Layout 4',
                    'layout5'    => 'Layout 5',
                    'layout6'    => 'Layout 6',
                    'layout7'    => 'Layout 7',
                ),
                'default'  => 'layout1',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'account_page_layout',
                'type'     => 'select',
                'title'    => 'Account Page',
                'subtitle' => 'Select account page layout',
                'options'  => array(
                    'layout1'    => 'Layout 1',
                    'layout2'    => 'Layout 2',
                    'layout3'    => 'Layout 3',
                ),
                'default'  => 'layout1',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'product_page_layout',
                'type'     => 'select',
                'title'    => 'Product Page',
                'subtitle' => 'Select product page layout',
                'options'  => array(
                    'layout1'    => 'Layout 1',
                    'layout2'    => 'Layout 2',
                    'layout3'    => 'Layout 3',
                ),
                'default'  => 'layout1',
                'select2'  => array( 'allowClear' => false )
            ),
        )
    ) );

    // -> Settings
    Redux::setSection( $opt_name, array(
        'title' => __( 'Settings', 'redux-framework' ),
        'id'    => 'settings',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Settings', 'redux-framework' ),
        'id'         => 'mstoreapp_settings',
        'subsection' => true,
        'fields'     => array(
            /*array(
                'id'       => 'app_logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Logo', 'redux-framework' ),
                'compiler' => 'true',
                'desc'     => __( 'Upload Logo.', 'redux-framework-demo' ),
            ),*/
            array(
                'id'       => 'show_best_selling',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable best selling products', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to show best selling products on home page', 'redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'show_onsale',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable on sale products', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to show on sale products on home page', 'redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'show_featured',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable featured products', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to show featured products on home page', 'redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'show_latest',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable latest products', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to show latest products on home page', 'redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'pull_to_refresh',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Pull to refresh', 'redux-framework' ),
                'subtitle' => __( 'This will allow you to enable or disable pull to refrsh in app', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'firebase_web_app_api_key',
                'type'     => 'text',
                'title'    => 'Firebase web app api key',
                'subtitle' => 'Enter Firebase web app api key',
                'placeholder' => 'AIza3sfTgf5MP7dSe_UiZXYhDtsOVPpQnxEHTc',
                'default'  => '',
            ),
            array(
                'id'       => 'firebase_server_key',
                'type'     => 'text',
                'title'    => 'Firebase Server Key',
                'subtitle' => 'Enter Firebase Server Key',
                'placeholder' => 'AAAAu8sIWr0:APA91bG15aYz9iKHcsOskRHjduIjslKoDgErWcrNWVBUoOBFhq9QGsPW4m8LDN5EHr16cu_hxTewzkCJcmmSzfJg3EK4MclC85xe3HuTyDjnOeXNdjenHNIuA',
                'default'  => '',
            ),
            array(
                'id'       => 'google_project_id',
                'type'     => 'text',
                'title'    => 'Firebase sender id',
                'subtitle' => 'Enter Firebase Sender id',
                'placeholder' => '807865301719',
                'default'  => '',
            ),
            array(
                'id'       => 'onesignal_app_id',
                'type'     => 'text',
                'title'    => 'OneSignal app id',
                'subtitle' => 'Enter OneSignal app id',
                'placeholder' => 'YhDtsOVPpQnxEHTcAIza3sfTgf5MP7dSe_UiZX',
                'default'  => '',
            ),
            array(
                'id'       => 'onesignal_app_rest_api_key',
                'type'     => 'text',
                'title'    => 'OneSignal rest api keys',
                'subtitle' => 'This will allow you to sent notification from WordPress admin panel',
                'placeholder' => 'ZXYhDtsOVPpQn_AIza3sfTgf5MP7dSe_UiZXYhDtsOVPpQnxEHTc',
                'default'  => '',
            ),
            array(
                'id'       => 'use_fcm',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Use firebase messaging for notification', 'redux-framework' ),
                'subtitle' => __( 'Enable to use firebase messaging for notification else One Signal is used for notification', 'redux-framework' ),
                'default'  => true,
            ),
            array(
                'id'       => 'send_push_on_product_publish',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Send push on product publish', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to send new push notification when you publsih a new product', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'send_push_on_new_order',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Customer Push Notification for order', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to send push notification to customer for order update and new order', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'vendor_push_on_new_order',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Vendor Push Notification for order', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to send push notification to vendor for order update and new order', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'admin_push_on_new_order',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Admin Push Notification for order', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to send push notification to admin for order update and new order', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'rate_app_ios_id',
                'type'     => 'text',
                'title'    => 'Rate app ios app id',
                'subtitle' => 'Enter Rate app ios app id',
                'default'  => '',
            ),
            array(
                'id'       => 'rate_app_android_id',
                'type'     => 'text',
                'title'    => 'Rate app android app link',
                'subtitle' => 'Enter Rate app android app link',
                'default'  => '',
            ),
            array(
                'id'       => 'rate_app_windows_id',
                'type'     => 'text',
                'title'    => 'Rate app windows app id',
                'subtitle' => 'Enter Rate app windows app id',
                'default'  => '',
            ),
            array(
                'id'       => 'share_app_android_link',
                'type'     => 'text',
                'title'    => 'Share app android link',
                'subtitle' => 'Enter Share app android link',
                'default'  => '',
            ),
            array(
                'id'       => 'share_app_ios_link',
                'type'     => 'text',
                'title'    => 'Share app ios link',
                'subtitle' => 'Enter Share app ios link',
                'default'  => '',
            ),
            array(
                'id'       => 'support_email',
                'type'     => 'text',
                'title'    => 'Support email',
                'subtitle' => 'Enter Support email',
                'validate' => 'email',
                'default'  => '',
            ),
            array(
                'id'       => 'enable_product_chat',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable product page chat', 'redux-framework' ),
                'subtitle' => __( 'This will allow you to enbale chat button in product page', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'enable_home_chat',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable home page chat', 'redux-framework' ),
                'subtitle' => __( 'This will allow you to enbale chat button in home page', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'country_dial_code',
                'type'     => 'text',
                'title'    => 'Default Country Phone Dial Code',
                'subtitle' => 'Enter Default Country Phone Dial Code',
                'validate' => 'text',
                'default'  => '+91',
            ),
            array(
                'id'       => 'whatsapp_number',
                'type'     => 'text',
                'title'    => 'Whatsapp number',
                'subtitle' => 'Enter Whatsapp number for chat',
                'validate' => 'text',
                'default'  => '+91XXXXXXXX',
            ),
            array(
                'id'       => 'show_blog',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable blog', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to show blog on account page', 'redux-framework' ),
                'desc'     => __( 'Make sure you install and activate json api plugins <a href="' . 'https://' . 'wordpress.org/plugins/json-api/" target="_blank">' . 'wordpress.org/plugins/json-api</a>', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'enable_wallet',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable Wallet', 'redux-framework' ),
                'subtitle' => __( 'This will allow you to add wallet to mobile app', 'redux-framework' ),
                'desc'     => __( 'Make sure you install woo wallet plugin <a href="' . 'https://' . 'wordpress.org/plugins/woo-wallet/" target="_blank">' . 'wordpress.org/plugins/woo-wallet</a>', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'enable_refund',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable Refund', 'redux-framework' ),
                'subtitle' => __( 'This will allow you to add refund request to mobile app', 'redux-framework' ),
                'desc' => __( 'Make sure you install yith advanced refund plugin (free version) <a href="' . 'https://' . 'yithemes.com/themes/plugins/yith-advanced-refund-system-for-woocommerce/" target="_blank">' . 'yithemes.com/themes/plugins/yith-advanced-refund-system-for-woocommerce</a>', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switchWpml',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'WPML', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable WordPress Multilingual Plugin.', 'redux-framework' ),
                'desc'     => __( 'Make sure you install wpml plugin <a href="' . 'https://' . 'wpml.org/" target="_blank">' . 'wpml.org</a>', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switchCurrrencies',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'WPML Multi Currency', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable WPML Multi Currency.', 'redux-framework' ),
                'desc'     => __( 'Make sure you install wpml plugin and enable multicurrency <a href="' . 'https://' . 'wpml.org/" target="_blank">' . 'wpml.org</a>', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'disableGuestCheckout',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Disable Guest Checkout', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable Guest Checkout.', 'redux-framework' ),
                'desc'     => __( 'This will enable Guest checkout. will be asked to login or register during checkout', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switchWebViewCheckout',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Webview Checkout', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable Webview Checkout.', 'redux-framework' ),
                'desc'     => __( 'This will enable webview checkout. checkout will be proccessed in the webview', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switchRewardPoints',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable or Reard Points', 'redux-framework' ),
                'subtitle' => __( 'WooCommerce  .', 'redux-framework' ),
                'desc'     => __( 'Make sure you install WooCommerce Points and Rewards plugin <a href="' . 'https://' . 'woocommerce.com/products/woocommerce-points-and-rewards/?aff=7531" target="_blank">' . 'https://' . 'woocommerce.com/products/woocommerce-points-and-rewards</a>

', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switchAddons',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable or Product Add-Ons', 'redux-framework' ),
                'subtitle' => __( 'WooCommerce Product Add-Ons.', 'redux-framework' ),
                'desc'     => __( 'Make sure you install Product Add-Ons plugin <a href="' . 'https://' . 'woocommerce.com/products/product-add-ons/?aff=7531" target="_blank">' . 'https://' . 'woocommerce.com/products/product-add-ons</a>', 'redux-framework' ),
                'default'  => false,
            ),
        )
    ) );

    // -> Pages
    Redux::setSection( $opt_name, array(
        'title' => __( 'Pages', 'redux-framework' ),
        'id'    => 'opt_pages',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Pages', 'redux-framework' ),
        'id'         => 'mstoreapp_pages',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'          => 'pages',
                'type'        => 'slides',
                'title'       => __( 'Pages', 'redux-framework' ),
                'subtitle' => 'Add Pages',
                'desc'     => __( 'This will allow you to add additional pages. Page link will apear on account screen', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Name (e.g., About Us, Privacy Policy, Terms & Conditions etc)', 'redux-framework' ),
                    'description' => __( 'Type (e.g., post, page, link)', 'redux-framework' ),
                    'url'         => __( 'Post id or url link ( url when above type is link ) (e.g., 1, https://example.com/privacy-policy)', 'redux-framework' ),
                ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Geo Location Filter', 'redux-framework' ),
        'id'         => 'geo_location_filter',
        'desc'  => __( 'Geo Location works for location based app only', 'redux-framework' ),
        //'subsection' => true,
        'fields'     => array(
            /*array(
                'id'       => 'switch_geo_location_filter',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable location filter', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the location filter.', 'redux-framework' ),
                'desc' => __( 'This will allow customer to select address', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switch_store_location_filter',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Store Locations', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the store location filter.', 'redux-framework' ),
                'desc' => __( 'This will enable to filter store based on geo location', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switch_category_location_filter',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Category Locations', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the categories location filter.', 'redux-framework' ),
                'desc' => __( 'This will enable to filter categories based on geo location', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'switch_products_location_filter',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Products Locations', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the products location filter.', 'redux-framework' ),
                'desc' => __( 'This will enable to filter products based on geo location', 'redux-framework' ),
                'default'  => false,
            ),*/
            array(
                'id'       => 'distance',
                'type'     => 'text',
                'title'    => 'Distance in km',
                'subtitle' => 'Radius distance to filter',
                'desc' => __( 'This will enable to filter store, products, categories with in the given radius', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 10,
            ),
        )
    ) );

/*    // -> Theme
    Redux::setSection( $opt_name, array(
        'title' => __( 'Theme', 'redux-framework' ),
        'id'    => 'theme',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    // -> Dimensions
    Redux::setSection( $opt_name, array(
        'title' => __( 'Dimensions', 'redux-framework' ),
        'id'    => 'dimensions',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Dimensions', 'redux-framework' ),
        'id'         => 'mstoreapp_dimensions',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'imageHeight',
                'type'     => 'text',
                'title'    => 'Product image height ratio',
                'subtitle' => 'Enter in % Product image height ratio',
                'desc' => __( 'Image (height/width) x 100', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 100,
            ),
            array(
                'id'       => 'productSliderWidth',
                'type'     => 'text',
                'title'    => 'Width of product in scroll',
                'subtitle' => 'Enter in % Width of product in scroll',
                'desc' => __( 'This will allow you to adjust width of products (Related, Up-Sell etc)', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 42,
            ),
            array(
                'id'       => 'latestPerRow',
                'type'     => 'select',
                'title'    => 'Latest product per row in home screen',
                'subtitle' => 'Select Latest products per row',
                'desc' => 'This will allow you to set number of product per line on home screen',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'productsPerRow',
                'type'     => 'select',
                'title'    => 'Product per row in products screen',
                'subtitle' => 'Select products per row',
                'desc' => 'This will allow you to set number of product per line on products screen',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'searchPerRow',
                'type'     => 'select',
                'title'    => 'Product per row in search screen',
                'subtitle' => 'Select search products per row',
                'desc' => 'This will allow you to set number of product per line on search screen',
                'options'  => array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
                'default'  => 2,
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'       => 'productBorderRadius',
                'type'     => 'text',
                'title'    => 'Product border radius',
                'subtitle' => 'Enter product border radius in px',
                'desc' => __( 'This will allow you to set rounded corner for product images. If you set radius, Set padding between product below', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 5,
            ),
            array(
                'id'       => 'suCatBorderRadius',
                'type'     => 'text',
                'title'    => 'Sub category border radius',
                'subtitle' => 'Enter product border radius in px',
                'desc' => __( 'This will allow you to set rounded corner for sub category images.', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 5,
            ),
            array(
                'id'       => 'productPadding',
                'type'     => 'text',
                'title'    => 'Padding between products',
                'subtitle' => 'Enter padding between products in px',
                'desc' => __( 'This will allow you to set gap between products', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 8,
            ),
            array(
                'id'       => 'product_shadow',
                'type'     => 'select',
                'title'    => 'Box shadow',
                'subtitle' => 'Select product box shadow',
                'desc' => __( 'Do not use Apply shadow when product padding 0', 'redux-framework' ),
                'options'  => array(
                    'shadow'    => 'Apply shadow',
                    'border'    => 'Apply border',
                    'no-shadow'    => 'None',
                ),
                'default'  => 'shadow',
                'select2'  => array( 'allowClear' => false )
            ),
        )
    ) );

    // -> Dimensions
    Redux::setSection( $opt_name, array(
        'title' => __( 'Map Locations', 'redux-framework' ),
        'id'    => 'opt_locations',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Map Locations', 'redux-framework' ),
        'id'         => 'mstoreapp_locations',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'switchLocations',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Status', 'redux-framework' ),
                'subtitle' => __( 'Enable or disable the map location.', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'mapApiKey',
                'type'     => 'text',
                'title'    => 'Google map api key',
                'subtitle' => 'Enter Google map api key',
                'placeholder' => 'QPazGyB8pf6ZdFTj5qw7rc_HSGrhUwqKfIe9Qzd',
                'default'  => '',
            ),
            array(
                'id'       => 'mapZoom',
                'type'     => 'text',
                'title'    => 'Map zoom',
                'subtitle' => 'Enter map zoom',
                'desc' => __( 'This will allow you to set map zoom', 'redux-framework' ),
                'validate' => 'numeric',
                'default'  => 16,
            ),
            array(
                'id'          => 'locations',
                'type'        => 'slides',
                'title'       => __( 'Locations', 'redux-framework' ),
                'subtitle' => 'Add Locations',
                'desc'     => __( 'Enter Location Name, Location, Latitude and Longitude', 'redux-framework' ),
                'placeholder' => array(
                    'title'       => __( 'Name (e.g., New York City)', 'redux-framework' ),
                    'description' => __( 'Latitude (e.g., 43.071584)', 'redux-framework' ),
                    'url'         => __( 'Longitude (e.g., -89.38012)', 'redux-framework' ),
                ),
            ),
        )
    ) );
*/
   
    // -> Vendor Settings
    Redux::setSection( $opt_name, array(
        'title' => __( 'Vendor', 'redux-framework' ),
        'id'    => 'vendor_details',
        'desc'  => __( '', 'redux-framework' ),
        'icon'  => 'el el-picture'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Settings', 'redux-framework' ),
        'id'         => 'mstoreapp_vendor_settings',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'enable_sold_by',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable Sold by in listing page', 'redux-framework' ),
                'subtitle' => __( 'This will allow you to enbale sold by in product listing page', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'enable_sold_by_product',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable Sold by in product detail page', 'redux-framework' ),
                'subtitle' => __( 'This will allow you to enbale sold by in product detail page', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'enable_vendor_chat',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Enable vendor chat', 'redux-framework' ),
                'subtitle' => __( 'This will allow user to chat with vendor', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'enable_vendor_map',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Show vendor map location', 'redux-framework' ),
                'subtitle' => __( 'This will allow user to see vendor location', 'redux-framework' ),
                'default'  => false,
            ),
            array(
                'id'       => 'vendor_push_on_new_order',
                'type'     => 'switch',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'title'    => __( 'Vendor Push Notification for order', 'redux-framework' ),
                'subtitle' => __( 'Enbaling this will allow you to send push notification to vendor for order update and new order', 'redux-framework' ),
                'default'  => false,
            )
        )
    ) );


    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'redux-framework' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 15 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 15, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'redux-framework' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

