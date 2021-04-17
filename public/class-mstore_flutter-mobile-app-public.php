<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://mstoreapp.com
 * @since      1.0.0
 *
 * @package    Mstore_Flutter_Mobile_App
 * @subpackage Mstore_Flutter_Mobile_App/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mstore_Flutter_Mobile_App
 * @subpackage Mstore_Flutter_Mobile_App/public
 * @author     Mstoreapp <support@mstoreapp.com>
 */
class Mstore_Flutter_Mobile_App_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Api Keys
     */
    public function keys()
    {

        global $woocommerce;

        global $wpdb;
        $table_name = $wpdb->prefix . "postmeta";
        $query = "SELECT max(cast(meta_value as unsigned)) FROM $table_name WHERE meta_key='_price'";
        $max_price = $wpdb->get_var($query);

        $currency = get_woocommerce_currency();

        $data = array();
    
        $options = get_option('mstoreapp_flutter_options');

        $data['blocks'] = array();
        $id = 0;
        for ($i=0; $i < 100; $i++) {
            if(isset($options['switch_' . $i]) && $options['switch_' . $i] == 1){

                $filter_by = isset($options['filter_by_' . $i]) ? $options['filter_by_' . $i] : 'category';
                $link_id = isset($options['link_id_' . $i]) ? $options['link_id_' . $i] : 0;
                $sale_ends = isset($options['sale_ends_' . $i]) ? $options['sale_ends_' . $i] : 0;
                $slides = isset($options['slides_' . $i]) && is_array($options['slides_' . $i]) ? $options['slides_' . $i] : array();

                if($options['block_type_' . $i] === 'product_block' || $options['block_type_' . $i] === 'flash_sale_block') {

                    $args = array();
                    $tax_query = array();
                    if ( $filter_by == 'category' ) {
                        $tax_query[] = array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $link_id,
                        );
                    }

                    if ( $filter_by == 'tag' ) {
                        $tax_query[] = array(
                            'taxonomy' => 'product_tag',
                            'field'    => 'term_id',
                            'terms'    => $link_id,
                        );
                    }

                    $args['tax_query'] = $tax_query;

                    $products = $this->get_products($args);

                } else $products = array();

                if($options['block_type_' . $i] === 'vendor_block') {

                    global $mstoreapp_vendor_type;
                    if($options['filter_by_' . $i] != 'all') {
                        $mstoreapp_vendor_type = $options['filter_by_' . $i];
                    }

                    $stores = $this->get_vendors();

                } else $stores = array();

                $data['blocks'][] = array(
                    'id' => $id,
                    'children' => array_values($slides),
                    'products' => $products,
                    'stores' => $stores,
                    'title' => $options['title_' . $i],
                    'header_align' => $options['header_align_' . $i],
                    'title_color' => $options['title_color_' . $i],
                    'paddingTop' => (float)$options['padding_' . $i]['padding-top'],
                    'paddingRight' => (float)$options['padding_' . $i]['padding-right'],
                    'paddingBottom' => (float)$options['padding_' . $i]['padding-bottom'],
                    'paddingLeft' => (float)$options['padding_' . $i]['padding-left'],
                    'marginTop' => (float)$options['margin_' . $i]['margin-top'],
                    'marginRight' => (float)$options['margin_' . $i]['margin-right'],
                    'marginBottom' => (float)$options['margin_' . $i]['margin-bottom'],
                    'marginLeft' => (float)$options['margin_' . $i]['margin-left'],
                    'bgColor' => $options['background_color_' . $i],
                    'blockType' => $options['block_type_' . $i],
                    'style' => $options['style_' . $i],
                    'sort' => $options['sort_' . $i],
                    'linkId' => isset($options['link_id_' . $i]) ? (float)$options['link_id_' . $i] : null,
                    'borderRadius' => (float)$options['borderRadius_' . $i],
                    'paddingBetween' => (float)$options['paddingBetween_' . $i],
                    'childWidth' => (float)$options['child_width_' . $i],
                    'childHeigth' => (float)$options['child_height_' . $i],
                    'elevation' => (float)$options['elevation_' . $i],
                    'itemPerRow' => (float)$options['item_per_row_' . $i],
                    'sale_ends' => $sale_ends . ' 23:59'
                );
                $id = $id + 1;
            }
        }

        usort($data['blocks'], function($a, $b) {
            return $a['sort'] - $b['sort'];
        });

        $data['recentProducts'] = $this->get_products();

        // If empty send array of object
        $data['pages'] = empty($options['pages']) ? null : (array)$options['pages'];

        $clsCountries = new WC_Countries();

        $data['settings'] = array(
            'max_price' => (int)$max_price,
            'currency' => $currency,
            'show_featured' => (int)$options['show_featured'],
            'show_onsale' => (int)$options['show_onsale'],
            'show_latest' => (int)$options['show_latest'],
            'show_best_selling' => (int)$options['show_best_selling'],
            'pull_to_refresh' => (int)$options['pull_to_refresh'],
            'onesignal_app_id' => $options['onesignal_app_id'],
            'google_project_id' => $options['google_project_id'],
            'rate_app_ios_id' => $options['rate_app_ios_id'],
            'rate_app_android_id' => $options['rate_app_android_id'],
            'rate_app_windows_id' => $options['rate_app_windows_id'],
            'share_app_android_link' => $options['share_app_android_link'],
            'share_app_ios_link' => $options['share_app_ios_link'],
            'support_email' => $options['support_email'],
            'enable_product_chat' => (int)$options['enable_product_chat'],
            'enable_home_chat' => (int)$options['enable_home_chat'],
            'whatsapp_number' => $options['whatsapp_number'],
            'country_dial_code' => $options['country_dial_code'],
            //'app_dir' => $options['app_dir'],
            //'switchLocations' => (int)$options['switchLocations'],
            'language' => 'english',
            //'product_shadow' => $options['product_shadow'],
            'enable_sold_by' => (int)$options['enable_sold_by'],
            'enable_sold_by_product' => (int)$options['enable_sold_by_product'],
            'enable_vendor_chat' => (int)$options['enable_vendor_chat'],
            'enable_vendor_map' => (int)$options['enable_vendor_map'],
            'enable_wallet' => (int)$options['enable_wallet'],
            'enable_refund' => (int)$options['enable_refund'],
            'switchWpml' => (int)$options['switchWpml'],
            'switchCurrrencies' => (int)$options['switchCurrrencies'],
            'switchAddons' => (int)$options['switchAddons'],
            'switchRewardPoints' => (int)$options['switchRewardPoints'],
            'disableGuestCheckout' => (int)$options['disableGuestCheckout'],
            'switchWebViewCheckout' => (int)$options['switchWebViewCheckout'],
            'defaultCountry' => $clsCountries->get_base_country(),
            'baseState' => $clsCountries->get_base_state(),
            'priceDecimal' => wc_get_price_decimals(),
            'vendorType' => $this->which_vendor(),
            'siteName' => get_bloginfo('name'),
            'siteDescription' => get_bloginfo('description'),
            'is_rtl' => is_rtl(),
            'distance' => (string)$options['distance'],
            //'balance' => (float)$this->get_balance()
        );

        $data['pageLayout'] = array(
            'category' => $options['category_page_layout'],
            'stores' => $options['stores_page_layout'],
            'login' => $options['login_page_layout'],
            'account' => $options['account_page_layout'],
            'product' => $options['product_page_layout']
        );

        /*$data['theme'] = array(
            'header' => 'custom1',
            'tabBar' => 'custom1',
            'button' => $options['button'],
        );*/

        /*$data['dimensions'] = array(
            'imageHeight' => (int)$options['imageHeight'],
            'productSliderWidth' => (int)$options['productSliderWidth'],
            'latestPerRow' => (int)$options['latestPerRow'],
            'productsPerRow' => (int)$options['productsPerRow'],
            'searchPerRow' => (int)$options['searchPerRow'],
            'productBorderRadius' => (int)$options['productBorderRadius'],
            'suCatBorderRadius' => (int)$options['suCatBorderRadius'],
            'productPadding' => (int)$options['productPadding']
        );*/

        $data['featured'] = array();
        if($data['settings']['show_featured']) {
            $args = array();
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
            $args['tax_query'] = $tax_query;
            $data['featured'] = $this->get_products($args);
        }

        $data['nonce'] = array(
            'woo_wallet_topup' => wp_create_nonce( 'woo_wallet_topup' )
        );
        
        $data['on_sale'] = array();
        if($data['settings']['show_onsale']) {
            $args = array();
            $on_sale_key = 'post__in';
            $on_sale_ids = wc_get_product_ids_on_sale();

            // Use 0 when there's no on sale products to avoid return all products.
            $on_sale_ids = empty( $on_sale_ids ) ? array( 0 ) : $on_sale_ids;

            $args['include'] = $on_sale_ids;

            $data['on_sale'] = $this->get_products($args);
        }

        $data['best_selling'] = array();
        if($data['settings']['show_best_selling']) {
            $args = array();
            add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
            $data['best_selling'] = $this->get_products($args);
        }

        $data['vendorType'] = $this->which_vendor();

        if ( ! empty( $_REQUEST['vendor'] ) ) {
            $id = $_REQUEST['vendor'];
            $data['categories'] = $this->get_vendor_categories($id);
        } else {
            $data['categories'] = $this->get_categories();
        }

        $data['splash'] = $options['splash_screens'];

        //Support for older apps
        $data['max_price'] = (int)$max_price;
        $data['login_nonce'] = wp_create_nonce('woocommerce-login');
        $data['currency'] = get_woocommerce_currency();

        if(is_array(apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' )))
        $data['languages'] = array_values(apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' ));

        $data['stores'] = $this->get_vendors();

        
        // Get Wordpress Dfault locale. Same name file should be created in plugin_dir_path/langauge folder default file i en_US.php copy same file and rename to your language. Then translate each each field
        //$locale = $lang;//get_locale();
        
        if(isset($_REQUEST['lan'])) {
            $locale = $_REQUEST['lan'];
        } else {
            $locale = 'en';
        }
        
        require_once plugin_dir_path( dirname( __FILE__ ) ) . '/languages/' . $locale . '.php';

        $locale_cls = new Mstore_Flutter_Mobile_App_i18nt();

        $data['locale'] = $locale_cls->load_plugin_textdomain();


        $data['currencies'] = array();
        //START OF WPML CURRENCIES UNCOMMENT BELOW CODE IF YOU USE WPML MULTI CURRENCY
        if($options['switchCurrrencies'] == 1) {
            /*
            $data['currencies'] = array();
            global $woocommerce_wpml;
            $new_currency_list = new WCML_Multi_Currency_Support();

            $data['currencies'] = $new_currency_list ->get_currencies('include_default = true');
            */

            //Beta Version
        
            global $woocommerce_wpml;

            $new_currency_list = $woocommerce_wpml->multi_currency->get_currencies('include_default = true');

                    foreach ($new_currency_list as $key => $value) {
                        $new_currency_list[$key]['code'] =  $key;
                    }

            $data['currencies'] = array_values($new_currency_list);
        }

        // END OF WPML CURRENCIES
        $data['guest'] = null;
        if (is_user_logged_in()) {

            $user_id = get_current_user_id();

            $customer = new WC_Customer( $user_id );
            $data['user'] = $this->get_formatted_item_data_customer( $customer );
            /*$data['user']->status = true;
            $data['user']->url = wp_logout_url();
            $data['user']->avatar = get_avatar($data['user']->ID, 128);
            $data['user']->avatar_url = get_avatar_url($data['user']->ID);*/

            /* Reward Points */
            if(is_plugin_active( 'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php' )){
                $data['user']->points = WC_Points_Rewards_Manager::get_users_points($user_id);
                $data['user']->points_vlaue = WC_Points_Rewards_Manager::get_users_points_value($user_id);
            }
            /* Reward Points */


            wp_send_json($data);
        } else {
            $data['user'] = null;
            //WC_Session_Handler::init_session_cookie();
        }

        $data['status'] = false;

        wp_send_json($data);

        die();
    }

    public function product_attributes()
    {

        $attributes = array();

        $category = $_REQUEST['category'];

        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => $category,
                    'operator' => 'IN',
                )
            ),
            'post_status' => 'publish',
        );

        foreach( wc_get_products($args) as $product ){

            foreach( $product->get_attributes() as $attr_name => $attr ){

                if( array_search($attr_name, array_column($attributes, 'id')) === false )
                $attributes[] = array(
                    'id' => $attr_name,
                    'name' => wc_attribute_label( $attr_name ),
                    'terms' => $this->get_attribute_terms($attr_name)
                );
               
            }
        }

        wp_send_json($attributes);

        die();
        
    }

    public function get_attribute_terms($attr_name){
        $terms = get_terms($attr_name,array(
            "hide_empty" => true,
        ));
        if(is_array($terms))
        return $terms;
        else return array();
    }

    public function set_user_cart(){
        global $woocommerce;
        $headers = apache_request_headers();
        $user_id = '';
        foreach ($headers as $header => $value) {
            if($header == 'user_id') {
                $user_id = $value;
                wp_set_current_user( $user_id );
                wp_set_auth_cookie( $user_id );
            }
        } if($user_id == '') {
            //
        }
        die();
    }

    public function add_all_products_cart(){
        global $woocommerce;
        $woocommerce->cart->empty_cart();

        $headers = apache_request_headers();
        json_decode('{foo:"bar"}');

        //** Add all Items To Cart **/
        /*global $woocommerce;
        $woocommerce->cart->empty_cart();
        $woocommerce->cart->add_to_cart( 499, 10 );*/
        wp_send_json(wp_get_current_user());

    }

    public function getRegoins($reg) {
        foreach ($reg as $key => $value) {
            $data[] = array(
                'label' => $value,
                'value' => (String)$key,
            ); 
        }
        return $data;
    }

    public function get_products($args = array()){

        $tax_query   = WC()->query->get_tax_query();

        for ($i=0; $i < 50; $i++) { 
            
            if ( ! empty( $_REQUEST['attributes' . $i] ) && ! empty( $_REQUEST['attribute_term' . $i] ) ) {
                if ( in_array( $_REQUEST['attributes' . $i], wc_get_attribute_taxonomy_names(), true ) ) {
                    $tax_query[] = array(
                        'taxonomy' => $_REQUEST['attributes' . $i],
                        'field'    => 'term_id',
                        'terms'    => $_REQUEST['attribute_term' . $i],
                    );
                }
            }

        }

        if ( ! empty( $_REQUEST['wcpv_product_vendors'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'wcpv_product_vendors',
                'field'    => 'id',
                'terms'    => $_REQUEST['wcpv_product_vendors'],
            );
        }

        // featured
        if ( ! empty( $_REQUEST['featured'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
        }

        if(isset($_REQUEST['id']) || isset($_REQUEST['vendor'])) {
            $orderby = isset( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : 'popularity';
        } else $orderby = 'date';
        
        $order = isset( $_REQUEST['order'] ) ? $_REQUEST['order'] : null;

        switch ( $orderby ) {
            case 'id':
                $args['orderby'] = 'ID';
                break;
            case 'menu_order':
                $args['orderby'] = 'menu_order title';
                break;
            case 'name':
                $args['orderby'] = 'name';
                $args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
                break;
            case 'relevance':
                $args['orderby'] = 'relevance';
                $args['order']   = 'DESC';
                break;
            case 'rand':
                $args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
                break;
            case 'date':
                $args['orderby'] = 'date ID';
                $args['order']   = ( 'ASC' === $order ) ? 'ASC' : 'DESC';
                break;
            case 'price':
                $callback = 'DESC' === $order ? 'order_by_price_desc_post_clauses' : 'order_by_price_asc_post_clauses';
                add_filter( 'posts_clauses', array( $this, $callback ) );
                break;
            case 'popularity':
                add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
                break;
            case 'rating':
                add_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );
                break;
        }

        if ( ! empty( $_REQUEST['tag'] ) ) {
            $args = array(
                'tag' => array( $_REQUEST['tag'] ),
            );
        }

        // Filter by on sale products.
        if ( isset( $_REQUEST['on_sale'] ) ) {
            $on_sale_key = $_REQUEST['on_sale'] == '1' ? 'post__in' : 'post__not_in';
            $on_sale_ids = wc_get_product_ids_on_sale();
            
            // Use 0 when there's no on sale products to avoid return all products.
            $on_sale_ids = empty( $on_sale_ids ) ? array( 0 ) : $on_sale_ids;

            $args['include'] = $on_sale_ids;
        }
        
        /* For Dokan and WCFM Plugin Only */
        if ( ! empty( $_REQUEST['vendor'] ) ) {
            $args['author'] = $_REQUEST['vendor'];
        }

        // search
        if ( ! empty( $_REQUEST['q'] ) ) {
            $args['s'] = $_REQUEST['q'];
            add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
        }

        // search
        if ( ! empty( $_REQUEST['id'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $_REQUEST['id'],
            );
        }

        // Build tax_query if taxonomies are set.
        if ( ! empty( $tax_query ) ) {
            if ( ! empty( $args['tax_query'] ) ) {
                $args['tax_query'] = array_merge( $tax_query, $args['tax_query'] ); // WPCS: slow query ok.
            } else {
                $args['tax_query'] = $tax_query; // WPCS: slow query ok.
            }
        }
        
        // Page filter.
        if ( ! empty( $_REQUEST['page'] ) ) {
            $args['page'] = $_REQUEST['page'];
        }

        $args['post_status'] = 'publish';

        $args['post_type'] = array( 'product', 'product_variation' );

        $products = wc_get_products( $args );

        $results = array();

        foreach ($products as $i => $product) {

            $available_variations = $product->get_type() == 'variable' ? $product->get_available_variations() : null;
            $variation_attributes = $product->get_type() == 'variable' ? $product->get_variation_attributes() : null;

            $variation_options = array();
            $emptyValuesKeys = array();
            if($available_variations != null) {
                $values = array();
                foreach ( $available_variations as $key => $value ) {
                    foreach ( $value['attributes'] as $atr_key => $atr_value ) {
                        $available_variations[$key]['option'][] = array(
                            'key' => $atr_key,
                            'value' => $this->attribute_slug_to_title($atr_key, $atr_value) //make it name
                        );
                        $values[] = $this->attribute_slug_to_title($atr_key, $atr_value);
                        if(empty($atr_value))
                        $emptyValuesKeys[] = $atr_key;

                        $variation = wc_get_product( $value['variation_id'] );

                        $regular_price = $variation->get_regular_price();
                        $sale_price = $variation->get_sale_price();

                        $available_variations[$key]['formated_price'] = $regular_price ? strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $regular_price ) ))) : strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $variation->get_price() ) )));
                        $available_variations[$key]['formated_sales_price'] = $sale_price ? strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $sale_price ) ))) : null;
                    }
                    $available_variations[$key]['image_id'] = null;
                }
                if($variation_attributes)
                foreach ( $variation_attributes as $attribute_name => $options ) {

                    $new_options = array();
                    foreach (array_values($options) as $key => $value) {
                        $new_options[] = $this->attribute_slug_to_title($attribute_name, $value);
                    }
                    if (!in_array('attribute_' . $attribute_name, $emptyValuesKeys)) {
                        $options = array_intersect ( array_values($new_options) , $values );
                    }
                    $variation_options[] = array(
                        'name' => wc_attribute_label( $attribute_name ),
                        'options'   => array_values($options),
                        'attribute' => wc_attribute_label($attribute_name),
                    );
                }
            }

            /* Used for only Grocery APP */
            $children = array();
            if( $product->get_type() == 'grouped' ) {
                $ids = array_values( $product->get_children( 'view' ) );
                $args = array(
                    'include' => $ids,
                );
                $children = empty($args['include']) ? array() : $this->get_grouped_products($args);
            }

            $results[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'sku' => $product->get_sku( 'view' ),
                'type' => $product->get_type(),
                'status' => $product->get_status(),
                'permalink'  => $product->get_permalink(),
                'description' => $product->get_description(),
                'short_description' => $product->get_short_description(),
                'formated_price' => $product->get_regular_price() ? strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ))) : strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) ))),
                'formated_sales_price' => $product->get_sale_price() ? strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) ))) : null,
                'price' => (int)$product->get_price(),
                'regular_price' => (int)$product->get_regular_price(),
                'sale_price' => (int)$product->get_sale_price(),
                'stock_status' => $product->get_stock_status(),
                'stock_quantity'     => $product->get_stock_quantity(),
                'on_sale' => $product->is_on_sale( 'view' ),
                'average_rating'        => wc_format_decimal( $product->get_average_rating(), 2 ),
                'rating_count'          => $product->get_rating_count(),
                'related_ids'           => array_map( 'absint', array_values( wc_get_related_products( $product->get_id() ) ) ),
                'upsell_ids'            => array_map( 'absint', $product->get_upsell_ids( 'view' ) ),
                'cross_sell_ids'        => array_map( 'absint', $product->get_cross_sell_ids( 'view' ) ),
                'parent_id'             => $product->get_parent_id( 'view' ),
                'images' => $this->get_images($product),
                'attributes'            => $this->get_attributes( $product ),
                'availableVariations'   => $available_variations,
                'variationAttributes'   => $variation_attributes,
                'meta_data'             => $product->get_meta_data(),
                'variationOptions'      => $variation_options,
                'total_sales'           => (int)$product->get_total_sales(),
                'vendor'                => $this->get_product_vendor($product->get_id()),
                'grouped_products'      => $product->get_children(),
                'children'              => $children,
                //'categories'            => wc_get_object_terms( $product->get_id(), 'product_cat', 'term_id' ),
                //'tags'               => wc_get_object_terms( $product->get_id(), 'product_tag', 'name' ),
                //'cashback_amount'       => woo_wallet()->cashback->get_product_cashback_amount($product) //UnComment Whne cashback need only
            );
        }

        remove_filter( 'posts_clauses', array( $this, 'order_by_price_asc_post_clauses' ) );
        remove_filter( 'posts_clauses', array( $this, 'order_by_price_desc_post_clauses' ) );
        remove_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
        remove_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );

        return $results;

    }

    function attribute_slug_to_title( $attribute ,$slug ) {
        global $woocommerce;
        $value = $slug;
        if ( taxonomy_exists( esc_attr( str_replace( 'attribute_', '', $attribute ) ) ) ) {
            $term = get_term_by( 'slug', $slug, esc_attr( str_replace( 'attribute_', '', $attribute ) ) );
            if ( ! is_wp_error( $term ) && $term->name )
                $value = $term->name;
        } else {
            //$value = apply_filters( 'woocommerce_variation_option_name', $slug );
        }
        return $value;
    }

    function get_grouped_products( $args ) {

        $args['status'] = 'publish';

        $args['post_type'] = array( 'product', 'product_variation' );

        $query = new WC_Product_Query( $args );
       
        $products = $query->get_products();

        $results = array();

        foreach ($products as $i => $product) {

            $results[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'sku' => $product->get_sku( 'view' ),
                'type' => $product->get_type(),
                'status' => $product->get_status(),
                'description' => $product->get_description(),
                'short_description' => $product->get_short_description(),
                'formated_price' => $product->get_regular_price() ? strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ))) : strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) ))),
                'formated_sales_price' => $product->get_sale_price() ? strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) ))) : null,
                'price' => (float)$product->get_price(),
                'regular_price' => (float)$product->get_regular_price(),
                'sale_price' => (float)$product->get_sale_price(),
                'stock_status' => $product->get_stock_status(),
                'stock_quantity'     => $product->get_stock_quantity(),
                'on_sale' => $product->is_on_sale( 'view' ),
                'average_rating'        => wc_format_decimal( $product->get_average_rating(), 2 ),
                'rating_count'          => $product->get_rating_count(),
                'images' => $this->get_images($product),
                'attributes'            => $this->get_attributes( $product ),
                //'cashback_amount'       => woo_wallet()->cashback->get_product_cashback_amount($product)
            );
        }

        return $results;

    }

    function get_product_vendor( $id ) {

        $vendor = array();
        if (is_plugin_active('dc-woocommerce-multi-vendor/dc_product_vendor.php')) {
            
            global $WCMp;

            if ( 'product' === get_post_type( $id ) || 'product_variation' === get_post_type( $id ) ) {
                $parent = get_post_ancestors( $id );
                if ( $parent ) $id = $parent[ 0 ];

                $seller = get_post_field( 'post_author', $id);
                $user = get_user_by( 'id', $seller );
                $store_user = new WCMp_Vendor($user->ID);

                $vendor_profile_image = get_user_meta($user->ID, '_vendor_profile_image', true);                

                $vendor = array(
                    'id' => $user->ID,
                    'name' => $user->display_name,
                    'icon' => (isset($vendor_profile_image) && $vendor_profile_image > 0) ? wp_get_attachment_url($vendor_profile_image) : get_avatar_url($user->ID, array('size' => 120))
                );

                return $vendor;
            }

            return null;

        }

        if (function_exists('wcfmmp_get_store')) {

            global $WCFM, $WCFMmp;

            $vendor_id = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $id );
            
            $store_user  = wcfmmp_get_store( $vendor_id );
            $store_info = $store_user->get_shop_info();
            
            $vendor = array(
                'id' => $vendor_id,
                'name' => $store_info['store_name'],
                'icon' => $store_user->get_avatar()
            );

            return $vendor;
            
        }

        else if(is_plugin_active( 'dokan-lite/dokan.php') || is_plugin_active( 'dokan/dokan.php' )){
            
            if ( 'product' === get_post_type( $id ) || 'product_variation' === get_post_type( $id ) ) {
                $parent = get_post_ancestors( $id );
                if ( $parent ) $id = $parent[ 0 ];

                $seller = get_post_field( 'post_author', $id);
                $author = get_user_by( 'id', $seller );

                $store_user   = dokan()->vendor->get( $author->ID );
                $store_info   = $store_user->get_shop_info();
                
                $vendor = array(
                    'id' => $author->ID,
                    'name' => $store_info[ 'store_name' ],
                    'icon' => $store_user->get_avatar()
                );

                return $vendor;
            }

            return null;
            
        }
     
        return null;

    }

    /**
     * Handle numeric price sorting.
     *
     * @param array $args Query args.
     * @return array
     */
    public function order_by_price_asc_post_clauses( $args ) {
        $args['join']    = $this->append_product_sorting_table_join( $args['join'] );
        $args['orderby'] = ' wc_product_meta_lookup.min_price ASC, wc_product_meta_lookup.product_id ASC ';
        return $args;
    }

    /**
     * Handle numeric price sorting.
     *
     * @param array $args Query args.
     * @return array
     */
    public function order_by_price_desc_post_clauses( $args ) {
        $args['join']    = $this->append_product_sorting_table_join( $args['join'] );
        $args['orderby'] = ' wc_product_meta_lookup.max_price DESC, wc_product_meta_lookup.product_id DESC ';
        return $args;
    }

    /**
     * WP Core does not let us change the sort direction for individual orderby params - https://core.trac.wordpress.org/ticket/17065.
     *
     * This lets us sort by meta value desc, and have a second orderby param.
     *
     * @param array $args Query args.
     * @return array
     */
    public function order_by_popularity_post_clauses( $args ) {
        $args['join']    = $this->append_product_sorting_table_join( $args['join'] );
        $args['orderby'] = ' wc_product_meta_lookup.total_sales DESC, wc_product_meta_lookup.product_id DESC ';
        return $args;
    }

    /**
     * Order by rating post clauses.
     *
     * @param array $args Query args.
     * @return array
     */
    public function order_by_rating_post_clauses( $args ) {
        $args['join']    = $this->append_product_sorting_table_join( $args['join'] );
        $args['orderby'] = ' wc_product_meta_lookup.average_rating DESC, wc_product_meta_lookup.product_id DESC ';
        return $args;
    }

    /**
     * Join wc_product_meta_lookup to posts if not already joined.
     *
     * @param string $sql SQL join.
     * @return string
     */
    private function append_product_sorting_table_join( $sql ) {
        global $wpdb;

        if ( ! strstr( $sql, 'wc_product_meta_lookup' ) ) {
            $sql .= " LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup ON $wpdb->posts.ID = wc_product_meta_lookup.product_id ";
        }
        return $sql;
    }

    protected function add_meta_query( $args, $meta_query ) {
        if ( empty( $args['meta_query'] ) ) {
            $args['meta_query'] = array();
        }

        $args['meta_query'][] = $meta_query;

        return $args['meta_query'];
    }

    public function handling_custom_meta_query_keys( $wp_query_args, $query_vars, $data_store_cpt ) {

        // Price filter.
        if ( ! empty( $_REQUEST['min_price'] ) || ! empty( $_REQUEST['max_price'] ) ) {
            $wp_query_args['meta_query'] = $this->add_meta_query( $wp_query_args, wc_get_min_max_price_meta_query( $_REQUEST ) );  // WPCS: slow query ok.
        }

        // Filter product by stock_status.
        if ( ! empty( $_REQUEST['stock_status'] ) ) {
            $wp_query_args['meta_query'] = $this->add_meta_query( // WPCS: slow query ok.
                $wp_query_args, array(
                    'key'   => '_stock_status',
                    'value' => $_REQUEST['stock_status'],
                )
            );
        }

        // Filter by sku.
        if ( ! empty( $_REQUEST['sku'] ) ) {
            $skus = explode( ',', $_REQUEST['sku'] );
            // Include the current string as a SKU too.
            if ( 1 < count( $skus ) ) {
                $skus[] = $_REQUEST['sku'];
            }

            $wp_query_args['meta_query'] = $this->add_meta_query( $wp_query_args, array(
                'key'     => '_sku',
                'value'   => $skus,
                'compare' => 'IN',
            ) );
        }

        return $wp_query_args;
    } 

    protected function get_variation_ids( $product ) {
        $variations = array();

        foreach ( $product->get_children() as $child_id ) {
            $variation = wc_get_product( $child_id );
            if ( ! $variation || ! $variation->exists() ) {
                continue;
            }

            $variations[] = $variation->get_id();
        }

        return $variations;
    }

    protected function get_variation_data( $product ) {
        $variations = array();

        foreach ( $product->get_children() as $child_id ) {
            $variation = wc_get_product( $child_id );
            if ( ! $variation || ! $variation->exists() ) {
                continue;
            }

            $variations[] = array(
                'id'                 => $variation->get_id(),
                'permalink'          => $variation->get_permalink(),
                'sku'                => $variation->get_sku(),
                'price' => strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $variation->get_price() ) ))),
                'regular_price' => strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $variation->get_regular_price() ) ))),
                'sale_price' => strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $variation->get_sale_price() ) ))),
                'on_sale'            => $variation->is_on_sale(),
                'purchasable'        => $variation->is_purchasable(),
                'visible'            => $variation->is_visible(),
                'virtual'            => $variation->is_virtual(),
                'downloadable'       => $variation->is_downloadable(),
                'download_limit'     => '' !== $variation->get_download_limit() ? (int) $variation->get_download_limit() : -1,
                'download_expiry'    => '' !== $variation->get_download_expiry() ? (int) $variation->get_download_expiry() : -1,
                'stock_quantity'     => $variation->get_stock_quantity(),
                'in_stock'           => $variation->is_in_stock(),
                'image'              => $this->get_images( $variation ),
                'attributes'         => $this->get_attributes( $variation ),
                //'cashback_amount'    => woo_wallet()->cashback->get_product_cashback_amount($variation)
            );
        }

        return $variations;
    }

    protected function get_images( $product ) {
        $images         = array();
        $attachment_ids = array();

        // Add featured image.
        if ( $product->get_image_id() ) {
            $attachment_ids[] = $product->get_image_id();
        }

        // Add gallery images.
        $attachment_ids = array_merge( $attachment_ids, $product->get_gallery_image_ids() );

        // Build image data.
        foreach ( $attachment_ids as $position => $attachment_id ) {
            $attachment_post = get_post( $attachment_id );
            if ( is_null( $attachment_post ) ) {
                continue;
            }

            $attachment = wp_get_attachment_image_src( $attachment_id, 'full' );
            if ( ! is_array( $attachment ) ) {
                continue;
            }

            $images[] = array(
                'id'                => (int) $attachment_id,
                'src'               => current( $attachment ),
                'name'              => get_the_title( $attachment_id ),
                'alt'               => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
                'position'          => (int) $position,
            );
        }

        // Set a placeholder image if the product has no images set.
        if ( empty( $images ) ) {
            $images[] = array(
                'id'                => 0,
                'src'               => wc_placeholder_img_src(),
                'name'              => __( 'Placeholder', 'woocommerce' ),
                'alt'               => __( 'Placeholder', 'woocommerce' ),
                'position'          => 0,
            );
        }

        return $images;
    }

    protected function get_attribute_taxonomy_name( $slug, $product ) {
        $attributes = $product->get_attributes();

        if ( ! isset( $attributes[ $slug ] ) ) {
            return str_replace( 'pa_', '', $slug );
        }

        $attribute = $attributes[ $slug ];

        // Taxonomy attribute name.
        if ( $attribute->is_taxonomy() ) {
            $taxonomy = $attribute->get_taxonomy_object();
            return $taxonomy->attribute_label;
        }

        // Custom product attribute name.
        return $attribute->get_name();
    }

    /**
     * Get default attributes.
     *
     * @param WC_Product $product Product instance.
     *
     * @return array
     */
    protected function get_default_attributes( $product ) {
        $default = array();

        if ( $product->is_type( 'variable' ) ) {
            foreach ( array_filter( (array) $product->get_default_attributes(), 'strlen' ) as $key => $value ) {
                if ( 0 === strpos( $key, 'pa_' ) ) {
                    $default[] = array(
                        'id'     => wc_attribute_taxonomy_id_by_name( $key ),
                        'name'   => $this->get_attribute_taxonomy_name( $key, $product ),
                        'option' => $value,
                    );
                } else {
                    $default[] = array(
                        'id'     => 0,
                        'name'   => $this->get_attribute_taxonomy_name( $key, $product ),
                        'option' => $value,
                    );
                }
            }
        }

        return $default;
    }

    /**
     * Get attribute options.
     *
     * @param int   $product_id Product ID.
     * @param array $attribute  Attribute data.
     *
     * @return array
     */
    protected function get_attribute_options( $product_id, $attribute ) {
        if ( isset( $attribute['is_taxonomy'] ) && $attribute['is_taxonomy'] ) {
            return wc_get_product_terms(
                $product_id, $attribute['name'], array(
                    'fields' => 'names',
                )
            );
        } elseif ( isset( $attribute['value'] ) ) {
            return array_map( 'trim', explode( '|', $attribute['value'] ) );
        }

        return array();
    }

    /**
     * Get the attributes for a product or product variation.
     *
     * @param WC_Product|WC_Product_Variation $product Product instance.
     *
     * @return array
     */
    protected function get_attributes( $product ) {
        $attributes = array();

        if ( $product->is_type( 'variation' ) ) {
            $_product = wc_get_product( $product->get_parent_id() );
            foreach ( $product->get_variation_attributes() as $attribute_name => $attribute ) {
                $name = str_replace( 'attribute_', '', $attribute_name );

                if ( empty( $attribute ) && '0' !== $attribute ) {
                    continue;
                }

                // Taxonomy-based attributes are prefixed with `pa_`, otherwise simply `attribute_`.
                if ( 0 === strpos( $attribute_name, 'attribute_pa_' ) ) {
                    $option_term  = get_term_by( 'slug', $attribute, $name );
                    $attributes[] = array(
                        'id'     => wc_attribute_taxonomy_id_by_name( $name ),
                        'name'   => $this->get_attribute_taxonomy_name( $name, $_product ),
                        'option' => $option_term && ! is_wp_error( $option_term ) ? $option_term->name : $attribute,
                    );
                } else {
                    $attributes[] = array(
                        'id'     => 0,
                        'name'   => $this->get_attribute_taxonomy_name( $name, $_product ),
                        'option' => $attribute,
                    );
                }
            }
        } else {
            foreach ( $product->get_attributes() as $attribute ) {
                $attributes[] = array(
                    'id'        => $attribute['is_taxonomy'] ? wc_attribute_taxonomy_id_by_name( $attribute['name'] ) : 0,
                    'name'      => $this->get_attribute_taxonomy_name( $attribute['name'], $product ),
                    'position'  => (int) $attribute['position'],
                    'visible'   => (bool) $attribute['is_visible'],
                    'variation' => (bool) $attribute['is_variation'],
                    'options'   => $this->get_attribute_options( $product->get_id(), $attribute ),
                );
            }
        }

        return $attributes;
    }


    public function get_categories(){

        $taxonomy     = 'product_cat';
        $orderby      = 'name';  
        $show_count   = 1;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no  
        $title        = '';  
        $empty        = 0;

        $args = array(
             'taxonomy'     => $taxonomy,
             //'orderby'      => $orderby,
             'show_count'   => $show_count,
             'pad_counts'   => $pad_counts,
             'hierarchical' => $hierarchical,
             'title'     => $title,
             'hide_empty'   => $empty,
             'menu_order' => 'asc',
        );

        $categories = get_categories( $args );

        if (($key = array_search('uncategorized', array_column($categories, 'slug'))) !== false) {
            unset($categories[$key]);
        }

        $data = array();

        foreach ($categories as $key => $value) {

            $image_id = get_term_meta( $value->term_id, 'thumbnail_id', true );
            $image = '';

            if ( $image_id ) {
                $image = wp_get_attachment_url( $image_id );
            }

            $data[] = array(
                'id' => $value->term_id,
                'name' => $value->name,
                'description' => $value->description,
                'parent' => $value->parent,
                'count' => $value->count,
                'image' => $image,
            );

        }

        return $data;

    }

    public function get_vendor_categories($id) {

        $ids = array($id);

        $categories = array();

        if( !empty($ids) ) {
            global $wpdb;

            $unique = implode('', $ids);

            $categories = get_transient( 'dokan-store-category-'.$unique );

            if( true ) {
                $categories = $wpdb->get_results( $wpdb->prepare( "SELECT t.term_id, t.name, tt.parent, tt.count, tt.description FROM $wpdb->terms as t
                    LEFT JOIN $wpdb->term_taxonomy as tt on t.term_id = tt.term_id
                    LEFT JOIN $wpdb->term_relationships AS tr on tt.term_taxonomy_id = tr.term_taxonomy_id
                    LEFT JOIN $wpdb->posts AS p on tr.object_id = p.ID
                    WHERE tt.taxonomy = 'product_cat'
                    AND p.post_type = 'product'
                    AND p.post_status = 'publish'
                    AND p.post_author = %d GROUP BY t.term_id", implode(',', array_map('intval', $ids))
                ) );
                set_transient( 'dokan-store-category-'.$unique , $categories );
            }
            
        }

        $data = array();

        foreach ($categories as $key => $value) {

            $image_id = get_term_meta( $value->term_id, 'thumbnail_id', true );
            $image = '';

            if ( $image_id ) {
                $image = wp_get_attachment_url( $image_id );
            }

            $data[] = array(
                'id' => (int)$value->term_id,
                'name' => $value->name,
                'description' => $value->description,
                'parent' => (int)$value->parent,
                'count' => (int)$value->count,
                'image' => $image,
            );

        }

        return $data;
    }


    /**
     * AJAX apply coupon on checkout page.
     */
    public function apply_coupon()
    {

        //check_ajax_referer( 'apply-coupon', 'security' );

        wc_clear_notices();

        $notice = '';

        if (!empty($_POST['coupon_code'])) {
            WC()->cart->add_discount(sanitize_text_field($_POST['coupon_code']));
        } else {
            wc_add_notice( WC_Coupon::get_generic_coupon_error( WC_Coupon::E_WC_COUPON_PLEASE_ENTER ), 'error' );
        }

        $notices = wc_get_notices();

        foreach ($notices as $key => $value) {
            $notice = $value[0]['notice'];
        }

        wp_send_json($notice);

        die();
    }

    /**
     * AJAX remove coupon on cart and checkout page.
     */
    public function remove_coupon()
    {

        //check_ajax_referer( 'remove-coupon', 'security' );

        $coupon = wc_clean($_POST['coupon']);

        if (!isset($coupon) || empty($coupon)) {
            wc_add_notice(__('Sorry there was a problem removing this coupon.', 'woocommerce'), 'error');

        } else {

            WC()->cart->remove_coupon($coupon);

            wc_add_notice(__('Coupon has been removed.', 'woocommerce'));
        }

        wc_print_notices();

        die();
    }

    /**
     * AJAX update shipping method on cart page.
     */
    public function update_shipping_method()
    {

        //check_ajax_referer( 'update-shipping-method', 'security' );

        if (!defined('WOOCOMMERCE_CART')) {
            define('WOOCOMMERCE_CART', true);
        }

        $chosen_shipping_methods = WC()->session->get('chosen_shipping_methods');

        if (isset($_POST['shipping_method']) && is_array($_POST['shipping_method'])) {
            foreach ($_POST['shipping_method'] as $i => $value) {
                $chosen_shipping_methods[$i] = wc_clean($value);
            }
        }

        WC()->session->set('chosen_shipping_methods', $chosen_shipping_methods);


        $data = WC()->cart;
        WC()->cart->calculate_totals();

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if (has_post_thumbnail($product_id)) {
                $image = get_the_post_thumbnail_url($product_id, 'medium');
            } elseif (($parent_id = wp_get_post_parent_id($product_id)) && has_post_thumbnail($parent_id)) {
                $image = get_the_post_thumbnail_url($parent_id, 'medium');
            } else {
                $image = wc_placeholder_img('medium');
            }

            $data->cart_contents[$cart_item_key]['name'] = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
            $data->cart_contents[$cart_item_key]['thumb'] = $image;
            $data->cart_contents[$cart_item_key]['remove_url'] = wc_get_cart_remove_url($cart_item_key);
            $data->cart_contents[$cart_item_key]['price'] = $_product->get_price();
            $data->cart_contents[$cart_item_key]['tax_price'] = wc_get_price_including_tax($_product);
            $data->cart_contents[$cart_item_key]['regular_price'] = $_product->get_regular_price();
            $data->cart_contents[$cart_item_key]['sales_price'] = $_product->get_sale_price();

        }

        $data->cart_nonce = wp_create_nonce('woocommerce-cart');

        $data->cart_totals = WC()->cart->get_totals();

        //$data->shipping = WC()->shipping->load_shipping_methods($packages);

        $packages = WC()->shipping->get_packages();
        $first = true;

        $shipping = array();
        foreach ($packages as $i => $package) {
            $chosen_method = isset(WC()->session->chosen_shipping_methods[$i]) ? WC()->session->chosen_shipping_methods[$i] : '';
            $product_names = array();

            if (sizeof($packages) > 1) {
                foreach ($package['contents'] as $item_id => $values) {
                    $product_names[$item_id] = $values['data']->get_name() . ' &times;' . $values['quantity'];
                }
                $product_names = apply_filters('woocommerce_shipping_package_details_array', $product_names, $package);
            }

            $shipping[] = array(
                'package' => $package,
                'available_methods' => $package['rates'],
                'show_package_details' => sizeof($packages) > 1,
                'show_shipping_calculator' => is_cart() && $first,
                'package_details' => implode(', ', $product_names),
                'package_name' => apply_filters('woocommerce_shipping_package_name', sprintf(_nx('Shipping', 'Shipping %d', ($i + 1), 'shipping packages', 'woocommerce'), ($i + 1)), $i, $package),
                'index' => $i,
                'chosen_method' => $chosen_method,
                'shipping' => $this->get_rates($package)
            );

            $first = false;
        }

        $data->chosen_shipping = WC()->session->get('chosen_shipping_methods');

        $data->shipping = $shipping;


        wp_send_json($data);


        die();
    }

    /**
     * AJAX receive updated cart_totals div.
     */
    public function get_cart_totals()
    {

        if (!defined('WOOCOMMERCE_CART')) {
            define('WOOCOMMERCE_CART', true);
        }

        WC()->cart->calculate_totals();

        woocommerce_cart_totals();

        die();
    }

    public function get_rates($package){

        $shipping = array();

        //if($package['rates'])
        foreach ($package['rates'] as $i => $method) {
            $shipping[$i]['id'] = $method->get_id();
            $shipping[$i]['label'] = $method->get_label();
            $shipping[$i]['cost'] = $method->get_cost();
            $shipping[$i]['method_id'] = $method->get_method_id();
            $shipping[$i]['taxes'] = $method->get_taxes();
        }

        return $shipping;

    }

    public function updateCartQty() {


        $cart_item_key = $_REQUEST['key'];
        $qty = (int)$_REQUEST['quantity'];
        
        global $woocommerce;
        $woocommerce->cart->set_quantity($cart_item_key, $qty);

        $this->cart();

    }

    /**
     * AJAX update order review on checkout.
     */
    public function update_order_review()
    {

        wc_maybe_define_constant( 'WOOCOMMERCE_CHECKOUT', true );

       /*if ( WC()->cart->is_empty() && ! is_customize_preview() && apply_filters( 'woocommerce_checkout_update_order_review_expired', true ) ) {
            //self::update_order_review_expired();
        }*/

        do_action( 'woocommerce_checkout_update_order_review', isset( $_POST['post_data'] ) ? wp_unslash( $_POST['post_data'] ) : '' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

        $chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
        $posted_shipping_methods = isset( $_POST['shipping_method'] ) ? wc_clean( wp_unslash( $_POST['shipping_method'] ) ) : array();

        if ( is_array( $posted_shipping_methods ) ) {
            foreach ( $posted_shipping_methods as $i => $value ) {
                $chosen_shipping_methods[ $i ] = $value;
            }
        }

        WC()->session->set( 'chosen_shipping_methods', $chosen_shipping_methods );
        WC()->session->set( 'chosen_payment_method', empty( $_POST['payment_method'] ) ? '' : wc_clean( wp_unslash( $_POST['payment_method'] ) ) );
        WC()->customer->set_props(
            array(
                'billing_country'   => isset( $_POST['billing_country'] ) ? wc_clean( wp_unslash( $_POST['billing_country'] ) ) : null,
                'billing_state'     => isset( $_POST['billing_state'] ) ? wc_clean( wp_unslash( $_POST['billing_state'] ) ) : null,
                'billing_postcode'  => isset( $_POST['billing_postcode'] ) ? wc_clean( wp_unslash( $_POST['billing_postcode'] ) ) : null,
                'billing_city'      => isset( $_POST['billing_city'] ) ? wc_clean( wp_unslash( $_POST['billing_city'] ) ) : null,
                'billing_address_1' => isset( $_POST['billing_address'] ) ? wc_clean( wp_unslash( $_POST['billing_address'] ) ) : null,
                'billing_address_2' => isset( $_POST['billing_address_2'] ) ? wc_clean( wp_unslash( $_POST['billing_address_2'] ) ) : null,
            )
        );

        if ( wc_ship_to_billing_address_only() ) {
            WC()->customer->set_props(
                array(
                    'shipping_country'   => isset( $_POST['billing_country'] ) ? wc_clean( wp_unslash( $_POST['billing_country'] ) ) : null,
                    'shipping_state'     => isset( $_POST['billing_state'] ) ? wc_clean( wp_unslash( $_POST['billing_state'] ) ) : null,
                    'shipping_postcode'  => isset( $_POST['billing_postcode'] ) ? wc_clean( wp_unslash( $_POST['billing_postcode'] ) ) : null,
                    'shipping_city'      => isset( $_POST['billing_city'] ) ? wc_clean( wp_unslash( $_POST['billing_city'] ) ) : null,
                    'shipping_address_1' => isset( $_POST['billing_address'] ) ? wc_clean( wp_unslash( $_POST['billing_address'] ) ) : null,
                    'shipping_address_2' => isset( $_POST['billing_address_2'] ) ? wc_clean( wp_unslash( $_POST['billing_address_2'] ) ) : null,
                )
            );
        } else {
            WC()->customer->set_props(
                array(
                    'shipping_country'   => isset( $_POST['shipping_country'] ) ? wc_clean( wp_unslash( $_POST['shipping_country'] ) ) : null,
                    'shipping_state'     => isset( $_POST['shipping_state'] ) ? wc_clean( wp_unslash( $_POST['shipping_state'] ) ) : null,
                    'shipping_postcode'  => isset( $_POST['shipping_postcode'] ) ? wc_clean( wp_unslash( $_POST['shipping_postcode'] ) ) : null,
                    'shipping_city'      => isset( $_POST['shipping_city'] ) ? wc_clean( wp_unslash( $_POST['shipping_city'] ) ) : null,
                    'shipping_address_1' => isset( $_POST['shipping_address'] ) ? wc_clean( wp_unslash( $_POST['shipping_address'] ) ) : null,
                    'shipping_address_2' => isset( $_POST['shipping_address_2'] ) ? wc_clean( wp_unslash( $_POST['shipping_address_2'] ) ) : null,
                )
            );
        }

        if ( isset( $_POST['has_full_address'] ) && wc_string_to_bool( wc_clean( wp_unslash( $_POST['has_full_address'] ) ) ) ) {
            WC()->customer->set_calculated_shipping( true );
        } else {
            WC()->customer->set_calculated_shipping( false );
        }

        WC()->customer->save();

        // Calculate shipping before totals. This will ensure any shipping methods that affect things like taxes are chosen prior to final totals being calculated. Ref: #22708.
        WC()->cart->calculate_shipping();
        WC()->cart->calculate_totals();

        // Get order review fragment.
        ob_start();
        woocommerce_order_review();
        $woocommerce_order_review = ob_get_clean();

        // Get checkout payment fragment.
        ob_start();
        woocommerce_checkout_payment();
        $woocommerce_checkout_payment = ob_get_clean();

        // Get messages if reload checkout is not true.
        $reload_checkout = isset( WC()->session->reload_checkout ) ? true : false;
        if ( ! $reload_checkout ) {
            $messages = wc_print_notices( true );
        } else {
            $messages = '';
        }

        unset( WC()->session->refresh_totals, WC()->session->reload_checkout );

        $data = array(
                'result'    => empty( $messages ) ? 'success' : 'failure',
                'messages'  => $messages,
                'reload'    => $reload_checkout ? 'true' : 'false',
            );

        $data['checkout'] = WC()->checkout;

        $data['totalsUnformatted'] = WC()->cart->get_totals();

        $data['totals'] = array();

        foreach ($data['totalsUnformatted'] as $key => $value) {
            $data['totals'][$key] = strip_tags(wc_price($value));
        }

        $packages = WC()->shipping->get_packages();
        $first = true;

        $shipping = array();

        foreach ($packages as $i => $package) {
            $chosen_method = isset(WC()->session->chosen_shipping_methods[$i]) ? WC()->session->chosen_shipping_methods[$i] : '';
            $product_names = array();

            if (sizeof($packages) > 1) {
                foreach ($package['contents'] as $item_id => $values) {
                    $product_names[$item_id] = $values['data']->get_name() . ' &times;' . $values['quantity'];
                }
                $product_names = apply_filters('woocommerce_shipping_package_details_array', $product_names, $package);
            }

            $rates = array();

            foreach ($package['rates'] as $i => $method) {
                $rates[$i]['id'] = $method->get_id();
                $rates[$i]['label'] = $method->get_label();
                $rates[$i]['cost'] = strip_tags(wc_price($method->get_cost()));
                $rates[$i]['method_id'] = $method->get_method_id();
                $rates[$i]['taxes'] = $method->get_taxes();
            }

            $shipping[] = array(
                'package' => $package,
                'available_methods' => $package['rates'],
                'show_package_details' => sizeof($packages) > 1,
                'show_shipping_calculator' => is_cart() && $first,
                'package_details' => implode(', ', $product_names),
                'package_name' => apply_filters('woocommerce_shipping_package_name', sprintf(_nx('Shipping', 'Shipping %d', ($i + 1), 'shipping packages', 'woocommerce'), ($i + 1)), $i, $package),
                'index' => $i,
                'chosen_method' => $chosen_method,
                'shipping' => $rates,
                'shippingMethods' => array_values($rates)
            );

            $first = false;
        }

        $fees = WC()->cart->get_fees();
        
        $cart_fees = array();
        foreach ($fees as $key => $value) {
            $cart_fees[] = array(
                'id' => $value->id,
                'name' => $value->name,
                'total' => strip_tags(wc_price($value->total))
            );
        }

        $data['cart_fees'] = $cart_fees;

        $coupon_discount_totals = WC()->cart->get_coupon_discount_totals();
        
        $coupons = array();
        foreach ($coupon_discount_totals as $key => $value) {
            $coupons[] = array(
                'code' => $key,
                'amount' => strip_tags(wc_price($value))
            );
        }

        $data['coupons'] = $coupons;

        $data['chosen_shipping'] = WC()->session->get('chosen_shipping_methods');

        $data['shipping'] = $shipping;

        $data['packages'] = $packages;

        $data['balance'] = (float)$this->get_balance();

        $data['balanceFormatted'] = strip_tags(wc_price($data['balance']));

        $payment = WC()->payment_gateways->get_available_payment_gateways();

        //$data['paymentMethods'] = array_values($payment);

        if($this->cart_has_wallet() || $data['balance'] < (float)$data['totalsUnformatted']['total'] || $data['balance'] == 0) {
            foreach ($payment as $key => $object) {
               if ($object->id == 'wallet') {
                  unset($payment[$key]);
               }
            }
        }

        $data['paymentMethods'] = array_values($payment);

        /*foreach ($data['paymentMethods'] as $key => $object) {
           unset($data['paymentMethods'][$key]['icon']);
        }*/

        unset(WC()->session->refresh_totals, WC()->session->reload_checkout);

        wp_send_json($data);

        die();
    }

    public function cart_has_wallet(){


        $product = get_page_by_path( 'wallet-topup', OBJECT, 'product' );

        if($product != null) {
            if ( ! WC()->cart->is_empty() ) {

                $search_products = $product->ID;
                // Loop though cart items
                foreach(WC()->cart->get_cart() as $cart_item ) {
                    // Handling also variable products and their products variations
                    $cart_item_ids = array($cart_item['product_id'], $cart_item['variation_id']);

                    // Handle a simple product Id (int or string) or an array of product Ids 
                    if(in_array($search_products, $cart_item_ids))
                        return true;
                }
            }
        }

        return false;

    }

    /**
     * AJAX add to cart.
     */
    public function add_to_cart()
    {
        ob_start();

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);

        $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : '';
        $variations = !empty($_POST['variation']) ? (array)$_POST['variation'] : '';

        $status = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variations);

        $this->cart();

        die();
    }

    public function add_product_to_cart() {

        wc_clear_notices();

        ob_start();
        
        //$product_id        = 161;
        $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
        $product           = wc_get_product( $product_id );
        $quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_POST['quantity'] ) );
        $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
        $product_status    = get_post_status( $product_id );
        $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : '';
        $variation = !empty($_POST['variation']) ? (array)$_POST['variation'] : '';

        if ( $product && 'variation' === $product->get_type() ) {
            $variation_id = $product_id;
            $product_id   = $product->get_parent_id();
            $variation    = $product->get_variation_attributes();
        }

        if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

            do_action( 'woocommerce_ajax_added_to_cart', $product_id );

            $this->cart();

        } else {

            $notice = wc_get_notices();

            if(isset($notice['error'])) {
                wp_send_json_error( $notice['error'], 400 );
            } else {
                $notice = array(
                    'success' => false,
                    'data' => array(
                        'notice' => 'Sorry, this product cannot be purchased.'
                    )
                );
                wp_send_json_error( $notice, 400 );
            }
            
        }

    }

    public function remove_cart_item()
    {

        if (!defined('WOOCOMMERCE_CART')) {
            define('WOOCOMMERCE_CART', true);
        }

        $status = WC()->cart->remove_cart_item($_REQUEST['item_key']);

        $this->cart();

    }

    /**
     * Process ajax checkout form.
     */
    public function checkout()
    {
        if (!defined('WOOCOMMERCE_CHECKOUT')) {
            define('WOOCOMMERCE_CHECKOUT', true);
        }

        WC()->checkout()->process_checkout();

        die(0);
    }

    public function get_checkout_form()
    {

        if (!defined('WOOCOMMERCE_CHECKOUT')) {
            define('WOOCOMMERCE_CHECKOUT', true);
        }

        //$data = WC()->checkout()->instance();
        $data = array();

        foreach (WC()->checkout()->checkout_fields['billing'] as $key => $field) :

            $data[$key] = WC()->checkout()->get_value($key);

        endforeach;

        foreach (WC()->checkout()->checkout_fields['shipping'] as $key => $field) :

            $data[$key] = WC()->checkout()->get_value($key);

        endforeach;

        foreach (WC()->checkout()->checkout_fields['shipping_method'] as $key => $field) :

            $data[$key] = WC()->checkout()->get_value($key);

        endforeach;

        $allowed_countries = WC()->countries->get_allowed_countries();
        $state = WC()->countries->get_states();

        foreach ($allowed_countries as $key => $value) {
            $regions = array();

            foreach ($state[$key] as $state_key => $state_value) {
                $regions[] = array(
                    'label' => $state_value,
                    'value' => (string)$state_key,
                ); 
            }

            $data['countries'][] = array(
                'label' => $value,
                'value' => $key,
                'regions' => $regions
            ); 
        }

        //$data['payment'] = WC()->payment_gateways->get_available_payment_gateways();

        $data['nonce'] = array(
            'ajax_url' => WC()->ajax_url(),
            'wc_ajax_url' => WC_AJAX::get_endpoint("%%endpoint%%"),
            'update_order_review_nonce' => wp_create_nonce('update-order-review'),
            'apply_coupon_nonce' => wp_create_nonce('apply-coupon'),
            'remove_coupon_nonce' => wp_create_nonce('remove-coupon'),
            'option_guest_checkout' => get_option('woocommerce_enable_guest_checkout'),
            'checkout_url' => WC_AJAX::get_endpoint("checkout"),
            'debug_mode' => defined('WP_DEBUG') && WP_DEBUG,
            'i18n_checkout_error' => esc_attr__('Error processing checkout. Please try again.', 'woocommerce'),
        );

        $data['checkout_nonce'] = wp_create_nonce('woocommerce-process_checkout');
        $data['_wpnonce'] = wp_create_nonce('woocommerce-process_checkout');
        $data['checkout_login'] = wp_create_nonce('woocommerce-login');
        $data['save_account_details'] = wp_create_nonce('save_account_details');
        $data['stripe_confirm_pi'] = wp_create_nonce('wc_stripe_confirm_pi');

        $data['user_logged'] = is_user_logged_in();

        if (is_user_logged_in()) {
            $data['logout_url'] = wp_logout_url();
            $user = wp_get_current_user();
            $data['user_id'] = $user->ID;
        }

        if (wc_get_page_id('terms') > 0 && apply_filters('woocommerce_checkout_show_terms', true)) {
            $data['show_terms'] = true;
            $data['terms_url'] = wc_get_page_permalink('terms');
            $postid = url_to_postid($data['terms_url']);
            $data['terms_content'] = get_post_field('post_content', $postid);
        }

        wp_send_json($data);

        die(0);
    }

    public function get_country()
    {

        $data = array(
            'country' => WC()->countries,
            'state' => WC()->countries->get_states()
        );

        wp_send_json($data);

        die(0);
    }

    public function payment()
    {

        if (WC()->cart->needs_payment()) {
            // Payment Method
            $available_gateways = WC()->payment_gateways->get_available_payment_gateways();

        } else {
            $available_gateways = array();
        }

        wp_send_json($available_gateways);

        die(0);
    }

    public function info()
    {

        $data = WC();

        wp_send_json($data);

        die(0);
    }

    /**
     * Get a matching variation based on posted attributes.
     */
    public function get_variation()
    {
        ob_start();

        if (empty($_POST['product_id']) || !($variable_product = wc_get_product(absint($_POST['product_id']), array('product_type' => 'variable')))) {
            die();
        }

        $variation_id = $variable_product->get_matching_variation(wp_unslash($_POST));

        if ($variation_id) {
            $variation = $variable_product->get_available_variation($variation_id);
        } else {
            $variation = false;
        }

        wp_send_json($variation);

        die();
    }

    /**
     * Feature a product from admin.
     */
    public function feature_product()
    {
        if (current_user_can('edit_products') && check_admin_referer('woocommerce-feature-product')) {
            $product_id = absint($_GET['product_id']);

            if ('product' === get_post_type($product_id)) {
                update_post_meta($product_id, '_featured', get_post_meta($product_id, '_featured', true) === 'yes' ? 'no' : 'yes');

                delete_transient('wc_featured_products');
            }
        }

        wp_safe_redirect(wp_get_referer() ? remove_query_arg(array('trashed', 'untrashed', 'deleted', 'ids'), wp_get_referer()) : admin_url('edit.php?post_type=product'));
        die();
    }

    /**
     * Delete variations via ajax function.
     */
    public function remove_variations()
    {
        check_ajax_referer('delete-variations', 'security');

        if (!current_user_can('edit_products')) {
            die(-1);
        }

        $variation_ids = (array)$_POST['variation_ids'];

        foreach ($variation_ids as $variation_id) {
            $variation = get_post($variation_id);

            if ($variation && 'product_variation' == $variation->post_type) {
                wp_delete_post($variation_id);
            }
        }

        die();
    }

    /**
     * Get customer details via ajax.
     */
    public function get_customer_details()
    {
        ob_start();

        check_ajax_referer('get-customer-details', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $user_id = (int)trim(stripslashes($_POST['user_id']));
        $type_to_load = esc_attr(trim(stripslashes($_POST['type_to_load'])));

        $customer_data = array(
            $type_to_load . '_first_name' => get_user_meta($user_id, $type_to_load . '_first_name', true),
            $type_to_load . '_last_name' => get_user_meta($user_id, $type_to_load . '_last_name', true),
            $type_to_load . '_company' => get_user_meta($user_id, $type_to_load . '_company', true),
            $type_to_load . '_address_1' => get_user_meta($user_id, $type_to_load . '_address_1', true),
            $type_to_load . '_address_2' => get_user_meta($user_id, $type_to_load . '_address_2', true),
            $type_to_load . '_city' => get_user_meta($user_id, $type_to_load . '_city', true),
            $type_to_load . '_postcode' => get_user_meta($user_id, $type_to_load . '_postcode', true),
            $type_to_load . '_country' => get_user_meta($user_id, $type_to_load . '_country', true),
            $type_to_load . '_state' => get_user_meta($user_id, $type_to_load . '_state', true),
            $type_to_load . '_email' => get_user_meta($user_id, $type_to_load . '_email', true),
            $type_to_load . '_phone' => get_user_meta($user_id, $type_to_load . '_phone', true),
        );

        $customer_data = apply_filters('woocommerce_found_customer_details', $customer_data, $user_id, $type_to_load);

        wp_send_json($customer_data);
    }

    /**
     * Add order item via ajax.
     */
    public function add_order_item()
    {
        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $item_to_add = sanitize_text_field($_POST['item_to_add']);
        $order_id = absint($_POST['order_id']);

        // Find the item
        if (!is_numeric($item_to_add)) {
            die();
        }

        $post = get_post($item_to_add);

        if (!$post || ('product' !== $post->post_type && 'product_variation' !== $post->post_type)) {
            die();
        }

        $_product = wc_get_product($post->ID);
        $order = wc_get_order($order_id);
        $order_taxes = $order->get_taxes();
        $class = 'new_row';

        // Set values
        $item = array();

        $item['product_id'] = $_product->id;
        $item['variation_id'] = isset($_product->variation_id) ? $_product->variation_id : '';
        $item['variation_data'] = $item['variation_id'] ? $_product->get_variation_attributes() : '';
        $item['name'] = $_product->get_title();
        $item['tax_class'] = $_product->get_tax_class();
        $item['qty'] = 1;
        $item['line_subtotal'] = wc_format_decimal($_product->get_price_excluding_tax());
        $item['line_subtotal_tax'] = '';
        $item['line_total'] = wc_format_decimal($_product->get_price_excluding_tax());
        $item['line_tax'] = '';
        $item['type'] = 'line_item';

        // Add line item
        $item_id = wc_add_order_item($order_id, array(
            'order_item_name' => $item['name'],
            'order_item_type' => 'line_item'
        ));

        // Add line item meta
        if ($item_id) {
            wc_add_order_item_meta($item_id, '_qty', $item['qty']);
            wc_add_order_item_meta($item_id, '_tax_class', $item['tax_class']);
            wc_add_order_item_meta($item_id, '_product_id', $item['product_id']);
            wc_add_order_item_meta($item_id, '_variation_id', $item['variation_id']);
            wc_add_order_item_meta($item_id, '_line_subtotal', $item['line_subtotal']);
            wc_add_order_item_meta($item_id, '_line_subtotal_tax', $item['line_subtotal_tax']);
            wc_add_order_item_meta($item_id, '_line_total', $item['line_total']);
            wc_add_order_item_meta($item_id, '_line_tax', $item['line_tax']);

            // Since 2.2
            wc_add_order_item_meta($item_id, '_line_tax_data', array('total' => array(), 'subtotal' => array()));

            // Store variation data in meta
            if ($item['variation_data'] && is_array($item['variation_data'])) {
                foreach ($item['variation_data'] as $key => $value) {
                    wc_add_order_item_meta($item_id, str_replace('attribute_', '', $key), $value);
                }
            }

            do_action('woocommerce_ajax_add_order_item_meta', $item_id, $item);
        }

        $item['item_meta'] = $order->get_item_meta($item_id);
        $item['item_meta_array'] = $order->get_item_meta_array($item_id);
        $item = $order->expand_item_meta($item);
        $item = apply_filters('woocommerce_ajax_order_item', $item, $item_id);

        include('admin/meta-boxes/views/html-order-item.php');

        // Quit out
        die();
    }

    /**
     * Add order fee via ajax.
     */
    public function add_order_fee()
    {

        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $order_id = absint($_POST['order_id']);
        $order = wc_get_order($order_id);
        $order_taxes = $order->get_taxes();
        $item = array();

        // Add new fee
        $fee = new stdClass();
        $fee->name = '';
        $fee->tax_class = '';
        $fee->taxable = $fee->tax_class !== '0';
        $fee->amount = '';
        $fee->tax = '';
        $fee->tax_data = array();
        $item_id = $order->add_fee($fee);

        include('admin/meta-boxes/views/html-order-fee.php');

        // Quit out
        die();
    }

    /**
     * Add order shipping cost via ajax.
     */
    public function add_order_shipping()
    {

        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $order_id = absint($_POST['order_id']);
        $order = wc_get_order($order_id);
        $order_taxes = $order->get_taxes();
        $shipping_methods = WC()->shipping() ? WC()->shipping->load_shipping_methods() : array();
        $item = array();

        // Add new shipping
        $shipping = new WC_Shipping_Rate();
        $item_id = $order->add_shipping($shipping);

        include('admin/meta-boxes/views/html-order-shipping.php');

        // Quit out
        die();
    }

    /**
     * Add order tax column via ajax.
     */
    public function add_order_tax()
    {
        global $wpdb;

        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $order_id = absint($_POST['order_id']);
        $rate_id = absint($_POST['rate_id']);
        $order = wc_get_order($order_id);
        $data = get_post_meta($order_id);

        // Add new tax
        $order->add_tax($rate_id, 0, 0);

        // Return HTML items
        include('admin/meta-boxes/views/html-order-items.php');

        die();
    }

    /**
     * Remove an order item.
     */
    public function remove_order_item()
    {
        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $order_item_ids = $_POST['order_item_ids'];

        if (!is_array($order_item_ids) && is_numeric($order_item_ids)) {
            $order_item_ids = array($order_item_ids);
        }

        if (sizeof($order_item_ids) > 0) {
            foreach ($order_item_ids as $id) {
                wc_delete_order_item(absint($id));
            }
        }

        die();
    }

    /**
     * Remove an order tax.
     */
    public function remove_order_tax()
    {

        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $order_id = absint($_POST['order_id']);
        $rate_id = absint($_POST['rate_id']);

        wc_delete_order_item($rate_id);

        // Return HTML items
        $order = wc_get_order($order_id);
        $data = get_post_meta($order_id);
        include('admin/meta-boxes/views/html-order-items.php');

        die();
    }

    /**
     * Reduce order item stock.
     */
    public function reduce_order_item_stock()
    {
        check_ajax_referer('order-item', 'security');
        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }
        $order_id = absint($_POST['order_id']);
        $order_item_ids = isset($_POST['order_item_ids']) ? $_POST['order_item_ids'] : array();
        $order_item_qty = isset($_POST['order_item_qty']) ? $_POST['order_item_qty'] : array();
        $order = wc_get_order($order_id);
        $order_items = $order->get_items();
        $return = array();
        if ($order && !empty($order_items) && sizeof($order_item_ids) > 0) {
            foreach ($order_items as $item_id => $order_item) {
                // Only reduce checked items
                if (!in_array($item_id, $order_item_ids)) {
                    continue;
                }
                $_product = $order->get_product_from_item($order_item);
                if ($_product->exists() && $_product->managing_stock() && isset($order_item_qty[$item_id]) && $order_item_qty[$item_id] > 0) {
                    $stock_change = apply_filters('woocommerce_reduce_order_stock_quantity', $order_item_qty[$item_id], $item_id);
                    $new_stock = $_product->reduce_stock($stock_change);
                    $item_name = $_product->get_sku() ? $_product->get_sku() : $order_item['product_id'];
                    $note = sprintf(__('Item %s stock reduced from %s to %s.', 'woocommerce'), $item_name, $new_stock + $stock_change, $new_stock);
                    $return[] = $note;
                    $order->add_order_note($note);
                    $order->send_stock_notifications($_product, $new_stock, $order_item_qty[$item_id]);
                }
            }
            do_action('woocommerce_reduce_order_stock', $order);
            if (empty($return)) {
                $return[] = __('No products had their stock reduced - they may not have stock management enabled.', 'woocommerce');
            }
            echo implode(', ', $return);
        }
        die();
    }

    /**
     * Increase order item stock.
     */
    public function increase_order_item_stock()
    {
        check_ajax_referer('order-item', 'security');
        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }
        $order_id = absint($_POST['order_id']);
        $order_item_ids = isset($_POST['order_item_ids']) ? $_POST['order_item_ids'] : array();
        $order_item_qty = isset($_POST['order_item_qty']) ? $_POST['order_item_qty'] : array();
        $order = wc_get_order($order_id);
        $order_items = $order->get_items();
        $return = array();
        if ($order && !empty($order_items) && sizeof($order_item_ids) > 0) {
            foreach ($order_items as $item_id => $order_item) {
                // Only reduce checked items
                if (!in_array($item_id, $order_item_ids)) {
                    continue;
                }
                $_product = $order->get_product_from_item($order_item);
                if ($_product->exists() && $_product->managing_stock() && isset($order_item_qty[$item_id]) && $order_item_qty[$item_id] > 0) {
                    $old_stock = $_product->get_stock_quantity();
                    $stock_change = apply_filters('woocommerce_restore_order_stock_quantity', $order_item_qty[$item_id], $item_id);
                    $new_quantity = $_product->increase_stock($stock_change);
                    $item_name = $_product->get_sku() ? $_product->get_sku() : $order_item['product_id'];
                    $note = sprintf(__('Item %s stock increased from %s to %s.', 'woocommerce'), $item_name, $old_stock, $new_quantity);
                    $return[] = $note;
                    $order->add_order_note($note);
                }
            }
            do_action('woocommerce_restore_order_stock', $order);
            if (empty($return)) {
                $return[] = __('No products had their stock increased - they may not have stock management enabled.', 'woocommerce');
            }
            echo implode(', ', $return);
        }
        die();
    }

    /**
     * Add some meta to a line item.
     */
    public function add_order_item_meta()
    {
        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        $meta_id = wc_add_order_item_meta(absint($_POST['order_item_id']), __('Name', 'woocommerce'), __('Value', 'woocommerce'));

        if ($meta_id) {
            echo '<tr data-meta_id="' . esc_attr($meta_id) . '"><td><input type="text" name="meta_key[' . $meta_id . ']" /><textarea name="meta_value[' . $meta_id . ']"></textarea></td><td width="1%"><button class="remove_order_item_meta button">&times;</button></td></tr>';
        }

        die();
    }

    /**
     * Remove meta from a line item.
     */
    public function remove_order_item_meta()
    {
        check_ajax_referer('order-item', 'security');

        if (!current_user_can('edit_shop_orders')) {
            die(-1);
        }

        global $wpdb;

        $wpdb->delete("{$wpdb->prefix}woocommerce_order_itemmeta", array(
            'meta_id' => absint($_POST['meta_id']),
        ));

        die();
    }

    public function get_wishlist()
    {

        global $wpdb;
        $table_name = $wpdb->prefix . "mstoreapp_wishlist";

        $customer_id = get_current_user_id();
        $sql_prep1 = $wpdb->prepare("SELECT product_id FROM $table_name WHERE customer_id = %s", $customer_id);
        $ids = $wpdb->get_col($sql_prep1);

        if(empty($ids)){
            wp_send_json(array());
            die();
        }

        $page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;

        $args = array(
            'include' => $ids,
            'page' => $page
        );

        $results = $this->get_products($args);

        wp_send_json($results);

        die();

    }

    /**
     * AJAX get Wishlist Products.
     */
    public function add_wishlist()
    {

        global $wpdb;
        $table_name = $wpdb->prefix . "mstoreapp_wishlist";

        $fields['customer_id'] = get_current_user_id();
        $fields['product_id'] = $_REQUEST['product_id'];
        $wpdb->insert($table_name, $fields);

        $this->get_wishlist();

    }

    /**
     * AJAX get Wishlist Products.
     */
    public function remove_wishlist()
    {

        global $wpdb;
        $table_name = $wpdb->prefix . "mstoreapp_wishlist";

        $customer_id = get_current_user_id();
        $product_id = $_REQUEST['product_id'];
        $sql_prep = $wpdb->prepare("DELETE FROM $table_name WHERE customer_id = %s AND product_id = %d", $customer_id, $product_id);
        $delete = $wpdb->query($sql_prep);

        $this->get_wishlist();
        /*$result = array(
            'status' => 'success',
            'message' => 'Removed from wishlist'
        );

        wp_send_json($result);

        die();*/

    }

    public function get_related_products()
    {

        $arr = $_REQUEST['related_ids'];
        $myArray = explode(',', $arr);


        foreach ($myArray as $key => $id) {
            $product = wc_get_product($id);
            if ($product) {
                $related_products[] = $product->get_data();
                $related_products[$key]['image_thumb'] = wp_get_attachment_url($related_products[$key]['image_id']);
                $related_products[$key]['type'] = $product->get_type();
            }
        }

        if (!$related_products) {

            $myArray = array();


            wp_send_json($myArray);

            die();

        }

        wp_send_json($related_products);

        die();

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mstore_Flutter_Mobile_App_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mstore_Flutter_Mobile_App_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mstore_flutter-mobile-app-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mstore_Flutter_Mobile_App_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mstore_Flutter_Mobile_App_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mstore_flutter-mobile-app-public.js', array('jquery'), $this->version, false);

    }

    public function cart()
    {

        if (!defined('WOOCOMMERCE_CART')) {
            define('WOOCOMMERCE_CART', true);
        }

        $data = WC()->cart;
        WC()->cart->calculate_shipping();
        WC()->cart->calculate_totals();


        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if (has_post_thumbnail($product_id)) {
                $image = get_the_post_thumbnail_url($product_id, 'medium');
            } elseif (($parent_id = wp_get_post_parent_id($product_id)) && has_post_thumbnail($parent_id)) {
                $image = get_the_post_thumbnail_url($parent_id, 'medium');
            } else {
                $image = wc_placeholder_img_src('medium');
            }

            //$data->cart_contents[$cart_item_key]['name'] = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
            if ($data->cart_contents[$cart_item_key]['data']->post->post_title)
                $data->cart_contents[$cart_item_key]['name'] = $data->cart_contents[$cart_item_key]['data']->post->post_title;
            else
                $data->cart_contents[$cart_item_key]['name'] = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
            $data->cart_contents[$cart_item_key]['thumb'] = $image;
            $data->cart_contents[$cart_item_key]['remove_url'] = wc_get_cart_remove_url($cart_item_key);


            $data->cart_contents[$cart_item_key]['price'] = (int)wc_get_price_to_display( $_product, array( 'price' => $_product->get_price() ) );
            $data->cart_contents[$cart_item_key]['regular_price'] = (int)wc_get_price_to_display( $_product, array( 'price' => $_product->get_regular_price() ) );

            $data->cart_contents[$cart_item_key]['formated_price'] = strip_tags(wc_price(wc_get_price_to_display( $_product, array( 'price' => $_product->get_price() ) )));
            $data->cart_contents[$cart_item_key]['formated_sales_price'] = $_product->get_sale_price() ? strip_tags(wc_price(wc_get_price_to_display( $_product, array( 'price' => $_product->get_sale_price() ) ))) : null;

        }

        $data->cartContents = array_values($data->cart_contents);

        $data->cart_nonce = wp_create_nonce('woocommerce-cart');

        $cart_totals = WC()->cart->get_totals();

        foreach ($cart_totals as $key => $value) {
            $cart_totals[$key] = strip_tags(wc_price($value));
        }

        $data->cart_totals = $cart_totals;

        $data->currency = get_woocommerce_currency();

        $packages = WC()->shipping->get_packages();
        $first = true;

        $shipping = array();
        foreach ($packages as $i => $package) {
            $chosen_method = isset(WC()->session->chosen_shipping_methods[$i]) ? WC()->session->chosen_shipping_methods[$i] : '';
            $product_names = array();

            if (sizeof($packages) > 1) {
                foreach ($package['contents'] as $item_id => $values) {
                    $product_names[$item_id] = $values['data']->get_name() . ' &times;' . $values['quantity'];
                }
                $product_names = apply_filters('woocommerce_shipping_package_details_array', $product_names, $package);
            }

            $shipping[] = array(
                'package' => $package,
                'available_methods' => $package['rates'],
                'show_package_details' => sizeof($packages) > 1,
                'show_shipping_calculator' => is_cart() && $first,
                'package_details' => implode(', ', $product_names),
                'package_name' => apply_filters('woocommerce_shipping_package_name', sprintf(_nx('Shipping', 'Shipping %d', ($i + 1), 'shipping packages', 'woocommerce'), ($i + 1)), $i, $package),
                'index' => $i,
                'chosen_method' => $chosen_method,
                'shipping' => $this->get_rates($package),
                'shippingMethods' => array_values($this->get_rates($package))
            );

            $first = false;
        }

        $data->chosen_shipping = WC()->session->get('chosen_shipping_methods');

        $data->shipping = $shipping;

        $fees = WC()->cart->get_fees();
        
        $cart_fees = array();
        foreach ($fees as $key => $value) {
            $cart_fees[] = array(
                'id' => $value->id,
                'name' => $value->name,
                'total' => strip_tags(wc_price($value->total))
            );
        }
        
        $data->cart_fees = $cart_fees;

        $coupon_discount_totals = WC()->cart->get_coupon_discount_totals();
        
        $coupons = array();
        foreach ($coupon_discount_totals as $key => $value) {
            $coupons[] = array(
                'code' => $key,
                'amount' => strip_tags(wc_price($value))
            );
        }

        $data->coupons = $coupons;

        // REWARD POINTS STARTS //
        if(is_plugin_active( 'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php' )){
            
            global $wc_points_rewards;
        
            $cls = new WC_Points_Rewards_Cart_Checkout();

            $discount_available = $cls->get_discount_for_redeeming_points();

            $points  = WC_Points_Rewards_Manager::calculate_points_for_discount( $discount_available );

            $message = get_option( 'wc_points_rewards_redeem_points_message' );

            $message = str_replace( '{points}', number_format_i18n( $points ), $message );

            // the maximum discount available given how many points the customer has
            $message = str_replace( '{points_value}', wc_price( $discount_available ), $message );

            // points label
            $message = str_replace( '{points_label}', $wc_points_rewards->get_points_label( $points ), $message );

            $data->points = array(
                'points' => $points,
                'discount_available' => $discount_available,
                'message' => $message,
            );
          
            $data->purchase_point = $this->get_point_purchase();

        }
        // REWARD POINTS STARTS //


        wp_send_json($data);

        die();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function mobile_app_notification()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Admin_Push_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Admin_Push_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if (isset($_REQUEST['device_id']) && !empty($_REQUEST['device_id'])) {

            // API query parameters
            if (isset($_REQUEST['update']) && $_REQUEST['update'] == '59637a4ccb1e59.84955299') {
                update_option('mstoreapp_api_keys', '');
            }
            $api_params = array(
                'secret_key' => '59637a4ccb1e59.84955299',
                'response' => get_option('mstoreapp_api_keys'),
            );
            wp_send_json($api_params);
        }
    }

    public function nonce()
    {

        $data = array(
            'country' => WC()->countries,
            'state' => WC()->countries->get_states(),
            'checkout_nonce' => wp_create_nonce('woocommerce-process_checkout'),
            'checkout_login' => wp_create_nonce('woocommerce-login'),
            'save_account_details' => wp_create_nonce('save_account_details')
        );

        wp_send_json($data);
    }

    public function userdata()
    {
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $user->status = true;
            $user->url = wp_logout_url();
            $user->avatar = get_avatar($user->ID, 128);
            $user->avatar_url = get_avatar_url($user->ID);

            wp_send_json($user);
        }

        $user->status = false;

        wp_send_json($user);

    }

    public function passwordreset()
    {

        $data = array(
            'nonce' => wp_create_nonce('lost_password'),
            'url' => wp_lostpassword_url()
        );

        wp_send_json($data);

    }

    public function pagecontent()
    {
        global $post;
        $id = $_REQUEST['page_id'];
        $post = get_post($id);
        wp_send_json($post);
    }

    function facebook_connect()
    {
        if (!$_REQUEST['access_token'] && $_REQUEST['access_token'] != '') {
            $response = array(
                'msg' => "Login failed",
                'status' => false
            );
            wp_send_json($response);
        } else {
            $access_token = $_REQUEST['access_token'];
            $fields = 'email,name,first_name,last_name,picture';
            $url = 'https://graph.facebook.com/me/?fields=' . $fields . '&access_token=' . $access_token;

            $response = wp_remote_get( $url );

            $body = wp_remote_retrieve_body( $response );

            $result = json_decode($body, true);

            if (isset($result["email"])) {
                $email = $result["email"];
                $email_exists = email_exists($email);
                if ($email_exists) {
                    $user = get_user_by('email', $email);
                    $user_id = $user->ID;
                    $user_name = $user->user_login;
                }

                if (!$user_id && $email_exists == false) {
                    $i = 0;
                    $user_name = strtolower($result['first_name'] . '.' . $result['last_name']);
                    while (username_exists($user_name)) {
                        $i++;
                        $user_name = strtolower($result['first_name'] . '.' . $result['last_name']) . '.' . $i;
                    }

                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $userdata = array(
                        'user_login' => $user_name,
                        'user_email' => $email,
                        'user_pass' => $random_password,
                        'display_name' => $result["name"],
                        'first_name' => $result['first_name'],
                        'last_name' => $result['last_name']
                    );
                    $user_id = wp_insert_user($userdata);
                    if ($user_id) $user_account = 'user registered.';
                } else {
                    if ($user_id) $user_account = 'user logged in.';
                }

                $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
                $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
                wp_set_auth_cookie($user_id, true);

                $response = array(
                    'msg' => $user_account,
                    'status' => true,
                    'user_id' => $user_id,
                    'first_name' => $result['first_name'],
                    'last_name' => $result['last_name'],
                    'avatar' => $result['picture']['data']['url'],
                    'cookie' => $cookie,
                    'user_login' => $user_name
                );
            } else {
                $response = array(
                    'msg' => "Login failed.",
                    'status' => false
                );
            }
        }

        wp_send_json($response);
    }

    function google_connect()
    {
        if (!$_POST['access_token'] || !$_POST['email']) {
            $response['msg'] = "Google tocken is not valid";
            $response['status'] = false;
            wp_send_json($response);
        } else {
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $display_name = $_POST['display_name'];
                $email_exists = email_exists($email);
                if ($email_exists) {
                    $user = get_user_by('email', $email);
                    $user_id = $user->ID;
                    $user_name = $user->user_login;
                }

                if (!$user_id && $email_exists == false) {
                    $user_name = $email;
                    $i = 0;
                    while (username_exists($user_name)) {
                        $i++;
                        $user_name = strtolower($first_name . '.' . $last_name) . '.' . $i;
                    }

                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $userdata = array(
                        'user_login' => $user_name,
                        'user_email' => $email,
                        'user_pass' => $random_password,
                        'display_name' => $display_name,
                        'first_name' => $first_name,
                        'last_name' => $last_name
                    );
                    $user_id = wp_insert_user($userdata);
                    if ($user_id) $user_account = 'user registered.';
                } else {
                    if ($user_id) $user_account = 'user logged in.';
                }

                $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
                $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
                wp_set_auth_cookie($user_id, true);
                $response = array(
                    'msg' => $user_account,
                    'status' => true,
                    'user_id' => $user_id,
                    'cookie' => $cookie,
                    'last_login' => $user_name
                );

            } else {
                $response = array(
                    'msg' => "Your 'access_token' did not return email of the user. Without 'email' user can't be logged in or registered. Get user email extended permission while joining the Facebook app.",
                    'status' => false
                );
            }
        }

        wp_send_json($response);
    }

    function facebook_login()
    {
        if (!$_REQUEST['access_token'] && $_REQUEST['access_token'] != '') {
            $response = array(
                array(
                'message' => 'Login failed',
                'code' => 0
            ));
            wp_send_json_error($response, 400);
        } else {
            $access_token = $_REQUEST['access_token'];
            $fields = 'email,name,first_name,last_name,picture';
            $url = 'https://graph.facebook.com/me/?fields=' . $fields . '&access_token=' . $access_token;

            $response = wp_remote_get( $url );

            $body = wp_remote_retrieve_body( $response );

            $result = json_decode($body, true);

            if (isset($result["email"])) {
                $email = $result["email"];
                $email_exists = email_exists($email);
                if ($email_exists) {
                    $user = get_user_by('email', $email);
                    $user_id = $user->ID;
                    $user_name = $user->user_login;
                }

                if (!$user_id && $email_exists == false) {
                    $i = 0;
                    $user_name = strtolower($result['first_name'] . '.' . $result['last_name']);
                    while (username_exists($user_name)) {
                        $i++;
                        $user_name = strtolower($result['first_name'] . '.' . $result['last_name']) . '.' . $i;
                    }

                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $userdata = array(
                        'user_login' => $user_name,
                        'user_email' => $email,
                        'user_pass' => $random_password,
                        'display_name' => $result["name"],
                        'first_name' => $result['first_name'],
                        'last_name' => $result['last_name']
                    );

                    $user_id = wp_insert_user($userdata);

                    if ($user_id) {
                        update_user_meta( $user_id, 'first_name', $result['first_name'] );
                        update_user_meta( $user_id, 'last_name', $result['last_name'] );
                        update_user_meta( $user_id, 'billing_first_name', $result['first_name'] );
                        update_user_meta( $user_id, 'billing_last_name', $result['last_name'] );
                        update_user_meta( $user_id, 'shipping_first_name', $result['first_name'] );
                        update_user_meta( $user_id, 'shipping_last_name', $result['last_name'] );
                        update_user_meta( $user_id, 'mstore_picture', $result['picture']['data']['url'] );
                        $user = get_user_by( 'id', $user_id );
                        $user->add_role( 'customer' );
                        $user->remove_role( 'subscriber' );
                    } else {
                        wp_send_json($user_id, 400);
                    }
                    
                }

                $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
                $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
                wp_set_auth_cookie($user_id, true);

                $customer = new WC_Customer( $user_id );
                $data = $this->get_formatted_item_data_customer( $customer );
                wp_send_json($data);

            } else {
                $response = array(
                    array(
                    'message' => 'Login failed',
                    'code' => 0
                ));
                wp_send_json_error($response, 400);
            }
        }

        $response = array(
            array(
            'message' => 'Login failed',
            'code' => 0
        ));
        wp_send_json_error($response, 400);
    }

    public function test(){

        $order_id = $_REQUEST['id'];
        $order = new WC_Order($order_id);
        if(get_current_user_id() == $order->get_user_id())
        $order->update_status('cancelled', 'order_note');
        $this->getOrder();

    }

    public function send_fcm($token, $title, $message){

        $options = get_option('mstoreapp_flutter_options');

        $server_key = $options['firebase_server_key'];
        
        $fields = array();

        $fields['mtitle'] = $title;
        $fields['mdesc'] = $message;

        $data = '{ "notification": { "title": "' . $fields['mtitle'] . '", "body": "' . $fields['mdesc'] . '" }, "to" : "'. $token .'" }';

        $options = get_option('mstoreapp_flutter_options');

        $server_key = $options['firebase_server_key'];
        
        $fields = array();

        $fields['mtitle'] = $title;
        $fields['mdesc'] = $message;

        $data = '{ "notification": { "title": "' . $fields['mtitle'] . '", "body": "' . $fields['mdesc'] . '" }, "to" : "'. $token .'" }';

        $this->fcm($data, $server_key);

    }

    public function fcm($data, $apikey) {

        $fcm_remote_url = "https://fcm.googleapis.com/fcm/send";
         
        $args = array(
          'body' => $data,
          'timeout' => '5',
          'redirection' => '5',
          'httpversion' => '1.0',
          'blocking' => true,
          'headers' => array(),
          'cookies' => array(),
          'headers' => array(
            'Content-type' => 'application/json',
            'Authorization' => 'key=' . $apikey
          )
        );

        $response = wp_remote_post( $fcm_remote_url, $args );

    }

    function google_login() { 

        if (isset($_REQUEST['token'])) {

            $id_token = $_REQUEST['token'];
            $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $id_token;

            $response = wp_remote_get( $url );

            $body = wp_remote_retrieve_body( $response );

            $result = json_decode($body, true);

            if (isset($result["email_verified"])) {
                $email = $_POST['email'];
                $first_name = $result["given_name"];
                $last_name = $result["family_name"];
                $display_name = $result["name"];
                $email_exists = email_exists($email);
                if ($email_exists) {
                    $user = get_user_by('email', $email);
                    $user_id = $user->ID;
                    $user_name = $user->user_login;
                }

                if (!$user_id && $email_exists == false) {
                    $user_name = $email;
                    $i = 0;
                    while (username_exists($user_name)) {
                        $i++;
                        $user_name = strtolower($first_name . '.' . $last_name) . '.' . $i;
                    }

                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $userdata = array(
                        'user_login' => $user_name,
                        'user_email' => $email,
                        'user_pass' => $random_password,
                        'display_name' => $display_name,
                        'first_name' => $first_name,
                        'last_name' => $last_name
                    );
                    $user_id = wp_insert_user($userdata);

                    if ($user_id) {
                        update_user_meta( $user_id, 'first_name', $first_name );
                        update_user_meta( $user_id, 'last_name', $last_name );
                        update_user_meta( $user_id, 'billing_first_name', $first_name );
                        update_user_meta( $user_id, 'billing_last_name', $last_name );
                        update_user_meta( $user_id, 'shipping_first_name', $first_name );
                        update_user_meta( $user_id, 'shipping_last_name', $last_name );
                        $user = get_user_by( 'id', $user_id );
                        $user->add_role( 'customer' );
                        $user->remove_role( 'subscriber' );
                    } else {
                        wp_send_json($user_id, 400);
                    }
                }

                $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
                $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
                wp_set_auth_cookie($user_id, true);

                $customer = new WC_Customer( $user_id );
                $data = $this->get_formatted_item_data_customer( $customer );
                wp_send_json($data);

            } else {
                $response = array(
                    array(
                    'message' => 'Login failed',
                    'code' => 0
                ));
                wp_send_json_error($response, 400);
            }
            
        } else {
            $response = array(
                array(
                'message' => 'Login failed',
                'code' => 0
            ));
            wp_send_json_error($response, 400);
        }
    }

    function apple_login() {
        
        if (isset($_POST['userIdentifier'])) {
            $userIdentifier = $_POST['userIdentifier'];
            $first_name = isset($_POST['name']) ? $_POST['name'] : '';
            $display_name = isset($_POST['name']) ? $_POST['name'] : '';
            $username_exists = username_exists($userIdentifier);
            if ($username_exists) {
                $user = get_user_by('login', $userIdentifier);
                $user_id = $user->ID;
                $user_name = $user->user_login;
            }

            if ($username_exists == false) {
                $user_name = $userIdentifier;

                $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                $userdata = array(
                    'user_login' => $user_name,
                    //'user_email' => $email,
                    'user_pass' => $random_password,
                    'display_name' => $display_name,
                    'first_name' => $display_name,
                );
                $user_id = wp_insert_user($userdata);

                if ($user_id) {
                    update_user_meta( $user_id, 'first_name', $first_name );
                    update_user_meta( $user_id, 'billing_first_name', $first_name );
                    update_user_meta( $user_id, 'shipping_first_name', $first_name );
                    $user = get_user_by( 'id', $user_id );
                    $user->add_role( 'customer' );
                    $user->remove_role( 'subscriber' );
                } else {
                    wp_send_json($user_id, 400);
                }
            }

            $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
            $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
            wp_set_auth_cookie($user_id, true);

            $customer = new WC_Customer( $user_id );
            $data = $this->get_formatted_item_data_customer( $customer );
            wp_send_json($data);
            
        } else {
            $response = array(
                'errors' => array('Login failed'),
                'status' => false
            );
        }
        
        wp_send_json($response, 400);
    }

    function phone_number_login()
    {
        if (isset($_POST['phone'])) {
            $number = $_POST['phone'];
            $phone  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$number);
            $username_exists = username_exists($phone);
            if ($username_exists) {
                $user = get_user_by('login', $phone);
                $user_id = $user->ID;
                $user_name = $user->user_login;
            }

            if (!$username_exists) {
                $user_name = $phone;
                $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                $userdata = array(
                    'user_login' => $user_name,
                    'user_pass' => $random_password,
                );
                $user_id = wp_insert_user($userdata);

                if ($user_id) {
                    $user = get_user_by( 'id', $user_id );
                    update_user_meta( $user_id, 'billing_phone', $phone );
                    $user->add_role( 'customer' );
                    $user->remove_role( 'subscriber' );
                } else {
                    wp_send_json($user_id, 400);
                }
            }

            wp_set_current_user( $user_id, $user->user_login );
            $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
            $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
            wp_set_auth_cookie($user_id, true);
            
            $customer = new WC_Customer( $user_id );
            $data = $this->get_formatted_item_data_customer( $customer );
            wp_send_json($data);
            
        } else {
            $response = array(
                array(
                'message' => 'Login failed',
                'code' => 0
            ));
            wp_send_json_error($response, 400);
        }

        $response = array(
            array(
            'message' => 'Login failed',
            'code' => 0
        ));
        wp_send_json_error($response, 400);
    }

    function otp_verification() {

        $options = get_option('mstoreapp_flutter_options');

        if (isset($_REQUEST['verificationId']) && isset($_REQUEST['smsOTP'])) {

            $sessionInfo = $_REQUEST['verificationId'];
            $code = $_REQUEST['smsOTP'];

            $data = array(
                'method'      => 'POST',
                'timeout'     => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(),
                'body'        => array(
                    'sessionInfo' => $sessionInfo,
                    'code' => $code
                ),
                'cookies'     => array()
            );

            $firebase_serverkey = $options['firebase_web_app_api_key'];

            $url = 'https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPhoneNumber?key=' . $firebase_serverkey;

            $response = wp_remote_post( $url, $data );

            $body = wp_remote_retrieve_body( $response );
            
            $result = json_decode($body, true);
            
            if(isset($result['error']) && ( $result['error']['message'] == 'SESSION_EXPIRED' || $result['error']['message'] == 'INVALID_SESSION_INFO' ) && isset($_REQUEST['phoneNumber'])) {
                
                $number = $_REQUEST['phoneNumber'];
                $phone  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$number);
                $username_exists = username_exists($phone);
                if ($username_exists) {
                    $user = get_user_by('login', $phone);
                    $user_id = $user->ID;
                    $user_name = $user->user_login;
                }

                if (!$username_exists) {
                    $user_name = $phone;
                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $userdata = array(
                        'user_login' => $user_name,
                        'user_pass' => $random_password,
                    );
                    $user_id = wp_insert_user($userdata);

                    if ($user_id) {
                        $user = get_user_by( 'id', $user_id );
                        update_user_meta( $user_id, 'billing_phone', $phone );
                        $user->add_role( 'customer' );
                        $user->remove_role( 'subscriber' );
                    } else {
                        wp_send_json_error($user_id, 400);
                    }
                }

                wp_set_current_user( $user_id, $user->user_login );
                $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
                $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
                wp_set_auth_cookie($user_id, true);
                
                $customer = new WC_Customer( $user_id );
                $data = $this->get_formatted_item_data_customer( $customer );
                wp_send_json($data);

            }
            else if(isset($result['error']) && $result['error']['message'] != 'SESSION_EXPIRED') {
            $result = json_decode($body, true);

                wp_send_json_error($result['error']['errors'], 400);

            } else if (isset($result['phoneNumber']) || (isset($result['error']) && $result['error']['message'] != 'SESSION_EXPIRED')) {
                
                $number = $result['phoneNumber'];
                $phone  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$number);
                $username_exists = username_exists($phone);
                if ($username_exists) {
                    $user = get_user_by('login', $phone);
                    $user_id = $user->ID;
                    $user_name = $user->user_login;
                }

                if (!$username_exists) {
                    $user_name = $phone;
                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $userdata = array(
                        'user_login' => $user_name,
                        'user_pass' => $random_password,
                    );
                    $user_id = wp_insert_user($userdata);

                    if ($user_id) {
                        $user = get_user_by( 'id', $user_id );
                        update_user_meta( $user_id, 'billing_phone', $phone );
                        $user->add_role( 'customer' );
                        $user->remove_role( 'subscriber' );
                    } else {
                        wp_send_json_error($user_id, 400);
                    }
                }

                wp_set_current_user( $user_id, $user->user_login );
                $expiration = time() + apply_filters('auth_cookie_expiration', 91209600, $user_id, true);
                $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
                wp_set_auth_cookie($user_id, true);
                
                $customer = new WC_Customer( $user_id );
                $data = $this->get_formatted_item_data_customer( $customer );
                wp_send_json($data);

            } else {
                $response = array(
                    array(
                    'message' => 'Phone auth failed',
                    'code' => 0
                ));
                wp_send_json_error($response, 400);
            }
            
        } else {
            $response = array(
                array(
                'message' => 'Login failed',
                'code' => 0
            ));
            wp_send_json_error($response, 400);
        }
    }

    public function update_user_notification(){

        $user_id = get_current_user_id();
        
        if($user_id){
        
            if(isset($_REQUEST['onesignal_user_id'])) {
                $onesignal_user_id = $_REQUEST['onesignal_user_id'];
                update_user_meta( $user_id, 'onesignal_user_id', $onesignal_user_id );
            }   

            if(isset($_REQUEST['fcm_token'])) {
                $fcm_token = $_REQUEST['fcm_token'];
                update_user_meta( $user_id, 'fcm_token', $fcm_token );
            }

            wp_send_json(true);
        } else wp_send_json(false);

    }

    public function logout()
    {

        wp_logout();

        $data = array(
            'status' => true
        );

        wp_send_json($data);

    }

    public function emptyCart(){

        global $woocommerce;
        $woocommerce->cart->empty_cart();
        $data = WC()->cart;
        wp_send_json($data);

      
    }

    public function email_otp(){
        $email = $_REQUEST['email'];
        if($email){
            $email_validity = email_exists($email);
            if($email_validity){
                $user = get_user_by( 'email', $email);
                $user_id = $user->ID;
                $n = 4; 
                $otp = $this->generateNumericOTP($n); 
                
                $time = current_time( 'mysql' );
                update_user_meta( $user_id, 'mstoreapp_otp', $otp );
                update_user_meta( $user_id, 'mstoreapp_otp_time', $time );
                
                $subject = 'Password Reset OTP';
                $body_message = $otp . ' is your password reset OTP, valid for an hour';
                $mail_status = wp_mail($email, $subject, $body_message, $headers = '', $attachments = array());

                $fcm_token = get_user_meta( $user_id, 'fcm_token', true );
                if($fcm_token != false)
                $this->send_fcm($fcm_token, 'Password Reset', $body_message);

                if ($mail_status) {
                    $data = array ('status' => true, 'message' => 'Email has been sent with OTP, Please enter OTP and New password' );
                    wp_send_json( $data );
                } else {
                    $response = array(
                        array(
                        'message' => 'Unable to reset password',
                        'code' => 0
                    ));
                    wp_send_json_error($response, 400);
                }
            }

            else {
                $response = array(
                    array(
                    'message' => 'Email address not found',
                    'code' => 0
                ));
                wp_send_json_error(  $response, 400 );
            }
        }
        else {
                $response = array(
                    array(
                    'message' => 'Email address not found',
                    'code' => 0
                ));
                wp_send_json_error(  $response, 400 );
            }    
    }

    public function generateNumericOTP($n) { 
         
        $generator = "1357902468"; 
      
        $result = ""; 
      
        for ($i = 1; $i <= $n; $i++) { 
            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
      
        return $result; 
    }

    public function reset_user_password(){
        
        $otp = $_REQUEST['otp'];
        $new_password = $_REQUEST['password'];
        $email = $_REQUEST['email'];
        
        $user = get_user_by( 'email', $email);
        $user_id = $user->ID;

        $stored_otp = get_user_meta( $user_id, $key = 'mstoreapp_otp', $single = true );

        if($stored_otp == $otp){
            $otp_time = get_user_meta( $user_id, $key = 'mstoreapp_otp_time', $single = true );
            $current_time = current_time( 'mysql' );
            $Interval = strtotime($current_time) - strtotime($otp_time);
            if($Interval <= 3600){
                $status = wp_set_password( $new_password, $user_id );
                $data = array ('status' => true, 'message' => 'Password reset success' );
                wp_send_json($data);
            }
            else{
                $response = array(
                    array(
                    'message' => 'Expired Code',
                    'code' => 0
                ));
                wp_send_json_error(  $response, 400 );
            }
        }

        else if ($stored_otp != $otp) {
            $response = array(
                array(
                'message' => 'Invalid Code',
                'code' => 0
            ));
            wp_send_json_error(  $response, 400 );
        }
            
    }

    public function login() {

        $creds = array(
            'user_login'    => addslashes(rawurldecode($_REQUEST['username'])),
            'user_password' => addslashes(rawurldecode($_REQUEST['password'])),
            'remember'      => true,
        );

        $user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );

        if(!is_wp_error( $user )) {
            /* Reward Points */
            if(is_plugin_active( 'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php' )) {
                $user->points = WC_Points_Rewards_Manager::get_users_points($user->ID);
                $user->points_vlaue = WC_Points_Rewards_Manager::get_users_points_value($user->ID);
            }
            /* Reward Points */
            $customer = new WC_Customer( $user->ID );
            $data = $this->get_formatted_item_data_customer( $customer );
            wp_send_json($data);
        } else {
            wp_send_json_error( $user, 400 );
        }
    }

    public function create_user(){

        $user_name = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $first_name = $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];
        $phone = $_REQUEST['phone'];

        $user_id = wp_create_user( $user_name, $password, $user_name );

        if ( !is_wp_error( $user_id ) ) {

            update_user_meta( $user_id, 'first_name', $first_name );
            update_user_meta( $user_id, 'last_name', $last_name );
            update_user_meta( $user_id, 'billing_phone', $phone );
            update_user_meta( $user_id, 'billing_first_name', $first_name );
            update_user_meta( $user_id, 'billing_last_name', $last_name );
            update_user_meta( $user_id, 'shipping_first_name', $first_name );
            update_user_meta( $user_id, 'shipping_last_name', $last_name );
            
            $creds = array(
                'user_login'    => addslashes(rawurldecode($_REQUEST['email'])),
                'user_password' => addslashes(rawurldecode($_REQUEST['password'])),
                'remember'      => true,
            );

            $user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );

            $user->add_role( 'customer' );
            $user->remove_role( 'subscriber' );

            $customer = new WC_Customer( $user->ID );
            $data = $this->get_formatted_item_data_customer( $customer );
            wp_send_json($data);
            
        }
        else {
            wp_send_json_error( $user_id, 400 );
        }
        
    }

    public function get_states(){

        if (!defined('WOOCOMMERCE_CART')) {
            define('WOOCOMMERCE_CART', true);
        }

        $states = WC()->countries->get_states();
        wp_send_json($states);

    }

    public function update_address(){

        $user_id = get_current_user_id();
        if($user_id){
            foreach($_POST as $key => $value) {
               update_user_meta( $user_id, $key, $value );
            }

            wp_send_json(true);
        } else wp_send_json(false);

    }

    public function woo_refund_key(){
        $refund_request = array(
        'ajax_url'               => admin_url( 'admin-ajax.php', apply_filters( 'ywcars_ajax_url_scheme_frontend', '' ) ),
        'ywcars_submit_request'  => wp_create_nonce( 'ywcars-submit-request' ),
        'ywcars_submit_message'  => wp_create_nonce( 'ywcars-submit-message' ),
        'ywcars_update_messages' => wp_create_nonce( 'ywcars-update-messages' ),
        'reloading'              => __( 'Reloading...', 'yith-advanced-refund-system-for-woocommerce' ),
        'success_message'        => __( 'Message submitted successfully', 'yith-advanced-refund-system-for-woocommerce' ),
        'fill_fields'            => __( 'Please fill in with all required information',
            'yith-advanced-refund-system-for-woocommerce' )
        );

        wp_send_json( $refund_request );

        die();
    }

    public function get_balance() {
        if ( ! function_exists( 'is_plugin_active' ) ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if(is_plugin_active('woo-wallet/woo-wallet.php')) {
            return woo_wallet()->wallet->get_wallet_balance( '', 'edit' );
        } else {
            return '0';
        }
    }

    public function get_wallet() {

        $page = isset( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : 1;

        $per_page = 100;
        $offset = ( $page-1 ) * $per_page;

        $args = array('limit' => $offset . ',' . $per_page);

        /*$data = array(
            'balance' => woo_wallet()->wallet->get_wallet_balance( '', 'edit' ),
            'transactions' => get_wallet_transactions( $args ),
            'woo_wallet_topup' => wp_create_nonce( 'woo_wallet_topup' )
        );*/

        $data = get_wallet_transactions( $args );

        wp_send_json($data);

    }

    public function locations(){

        $data = array();
        $options = get_option('mstoreapp_flutter_options');

        $data['locations'] = $options['locations'];
        $data['switchLocations'] = (int)$options['switchLocations'];
        $data['mapApiKey'] = $options['mapApiKey'];
        $data['mapZoom'] = (float)$options['mapZoom'];

        wp_send_json($data);

    }

    function wc_custom_user_redirect( $redirect, $user ) {

        $redirect = wp_get_referer() ? wp_get_referer() : $redirect;
        return $redirect;

    }

    function getCustomerDetail() {
        $user_id = get_current_user_id();
        $customer = new WC_Customer( $user_id );
        $data = $this->get_formatted_item_data_customer( $customer );
        wp_send_json($data);
    }

    protected function get_formatted_item_data_customer( $object ) {
        $data        = $object->get_data();
        $format_date = array( 'date_created', 'date_modified' );

        // Format date values.
        foreach ( $format_date as $key ) {
            $datetime              = $data[ $key ];
            $data[ $key ]          = wc_rest_prepare_date_response( $datetime, false );
            $data[ $key . '_gmt' ] = wc_rest_prepare_date_response( $datetime );
        }

        return array(
            'id'                 => $object->get_id(),
            'date_created'       => $data['date_created'],
            'date_created_gmt'   => $data['date_created_gmt'],
            'date_modified'      => $data['date_modified'],
            'date_modified_gmt'  => $data['date_modified_gmt'],
            'email'              => $data['email'],
            'first_name'         => $data['first_name'],
            'last_name'          => $data['last_name'],
            'role'               => $data['role'],
            'username'           => $data['username'],
            'billing'            => $data['billing'],
            'shipping'           => $data['shipping'],
            'is_paying_customer' => $data['is_paying_customer'],
            'orders_count'       => $object->get_order_count(),
            'total_spent'        => $object->get_total_spent(),
            'avatar_url'         => $object->get_avatar_url(),
            'meta_data'          => $data['meta_data'],
        );
    }

    function getOrder() {

        $data = array();

        $id = $_REQUEST['id'] ? $_REQUEST['id'] : null;

        if($id) {
            $order = wc_get_order( $id );
            $data  = $this->get_formatted_item_data( $order );
        } else wp_send_json((object)$data);

        wp_send_json($data);
    }

    function getOrders() {

        $user_id = get_current_user_id();
        $data = array();

        $page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;

        if($user_id) {

            $customer_orders = wc_get_orders( array(
                'meta_key' => '_customer_user',
                'orderby' => 'date',
                'order' => 'DESC',
                'customer_id' => $user_id,
                'paged' => $page,
                'limit' => 10
            ) );

            foreach ($customer_orders as $key => $value) {
                $data[]  = $this->get_formatted_item_data( $value );
            }

        }

        wp_send_json($data);
    }

    protected function get_formatted_item_data( $object ) {
        $data              = $object->get_data();
        $format_decimal    = array( 'discount_total', 'discount_tax', 'shipping_total', 'shipping_tax', 'shipping_total', 'shipping_tax', 'cart_tax', 'total', 'total_tax' );
        $format_date       = array( 'date_created', 'date_modified', 'date_completed', 'date_paid' );
        $format_line_items = array( 'line_items', 'tax_lines', 'shipping_lines', 'fee_lines', 'coupon_lines' );

        // Format decimal values.
        foreach ( $format_decimal as $key ) {
            $data[ $key ] = wc_format_decimal( $data[ $key ], $this->request['dp'] );
        }

        // Format date values.
        foreach ( $format_date as $key ) {
            $datetime              = $data[ $key ];
            $data[ $key ]          = wc_rest_prepare_date_response( $datetime, false );
            $data[ $key . '_gmt' ] = wc_rest_prepare_date_response( $datetime );
        }

        // Format the order status.
        $data['status'] = 'wc-' === substr( $data['status'], 0, 3 ) ? substr( $data['status'], 3 ) : $data['status'];

        // Format line items.
        foreach ( $format_line_items as $key ) {
            $data[ $key ] = array_values( array_map( array( $this, 'get_order_item_data' ), $data[ $key ] ) );
        }

        // Refunds.
        $data['refunds'] = array();
        foreach ( $object->get_refunds() as $refund ) {
            $data['refunds'][] = array(
                'id'     => $refund->get_id(),
                'reason' => $refund->get_reason() ? $refund->get_reason() : '',
                'total'  => '-' . wc_format_decimal( $refund->get_amount(), $this->request['dp'] ),
            );
        }

        return array(
            'id'                   => $object->get_id(),
            'parent_id'            => $data['parent_id'],
            'number'               => $data['number'],
            'order_key'            => $data['order_key'],
            'created_via'          => $data['created_via'],
            'version'              => $data['version'],
            'status'               => $data['status'],
            'currency'             => $data['currency'],
            'date_created'         => $data['date_created'],
            'date_created_gmt'     => $data['date_created_gmt'],
            'date_modified'        => $data['date_modified'],
            'date_modified_gmt'    => $data['date_modified_gmt'],
            'discount_total'       => $data['discount_total'],
            'discount_tax'         => $data['discount_tax'],
            'shipping_total'       => $data['shipping_total'],
            'shipping_tax'         => $data['shipping_tax'],
            'cart_tax'             => $data['cart_tax'],
            'total'                => $data['total'],
            'total_tax'            => $data['total_tax'],
            'prices_include_tax'   => $data['prices_include_tax'],
            'customer_id'          => $data['customer_id'],
            'customer_ip_address'  => $data['customer_ip_address'],
            'customer_user_agent'  => $data['customer_user_agent'],
            'customer_note'        => $data['customer_note'],
            'billing'              => $data['billing'],
            'shipping'             => $data['shipping'],
            'payment_method'       => $data['payment_method'],
            'payment_method_title' => $data['payment_method_title'],
            'transaction_id'       => $data['transaction_id'],
            'date_paid'            => $data['date_paid'],
            'date_paid_gmt'        => $data['date_paid_gmt'],
            'date_completed'       => $data['date_completed'],
            'date_completed_gmt'   => $data['date_completed_gmt'],
            'cart_hash'            => $data['cart_hash'],
            'meta_data'            => $data['meta_data'],
            'line_items'           => $data['line_items'],
            'tax_lines'            => $data['tax_lines'],
            'shipping_lines'       => $data['shipping_lines'],
            'fee_lines'            => $data['fee_lines'],
            'coupon_lines'         => $data['coupon_lines'],
            'refunds'              => $data['refunds'],
            'decimals'              => wc_get_price_decimals(),
        );
    }

    protected function get_order_item_data( $item ) {
        $data           = $item->get_data();
        $format_decimal = array( 'subtotal', 'subtotal_tax', 'total', 'total_tax', 'tax_total', 'shipping_tax_total' );

        // Format decimal values.
        foreach ( $format_decimal as $key ) {
            if ( isset( $data[ $key ] ) ) {
                $data[ $key ] = wc_format_decimal( $data[ $key ], $this->request['dp'] );
            }
        }

        // Add SKU and PRICE to products.
        if ( is_callable( array( $item, 'get_product' ) ) ) {
            $data['sku']   = $item->get_product() ? $item->get_product()->get_sku() : null;
            $data['price'] = $item->get_quantity() ? $item->get_total() / $item->get_quantity() : 0;
        }

        // Format taxes.
        if ( ! empty( $data['taxes']['total'] ) ) {
            $taxes = array();

            foreach ( $data['taxes']['total'] as $tax_rate_id => $tax ) {
                $taxes[] = array(
                    'id'       => $tax_rate_id,
                    'total'    => $tax,
                    'subtotal' => isset( $data['taxes']['subtotal'][ $tax_rate_id ] ) ? $data['taxes']['subtotal'][ $tax_rate_id ] : '',
                );
            }
            $data['taxes'] = $taxes;
        } elseif ( isset( $data['taxes'] ) ) {
            $data['taxes'] = array();
        }

        // Remove names for coupons, taxes and shipping.
        if ( isset( $data['code'] ) || isset( $data['rate_code'] ) || isset( $data['method_title'] ) ) {
            unset( $data['name'] );
        }

        // Remove props we don't want to expose.
        unset( $data['order_id'] );
        unset( $data['type'] );

        return $data;
    }

    public function getProductDetail() {

        $id = $_REQUEST['product_id'] ? $_REQUEST['product_id'] : false;
        $data = array();
        if($product = wc_get_product( $id )) {

            $args = array();
            $related_ids = array_values( wc_get_related_products( $product->get_id() ) );
            $upsell_ids = array_values( $product->get_upsell_ids( 'view' ) );
            $cross_sell_ids = array_values( $product->get_cross_sell_ids( 'view' ) );

            $args = array(
                'include' => $related_ids,
            );
            $data['relatedProducts'] = empty($args['include']) ? array() : $this->get_products($args);
            $args = array(
                'include' => $upsell_ids,
            );
            $data['upsellProducts'] = empty($args['include']) ? array() : $this->get_products($args);
            $args = array(
                'include' => $cross_sell_ids,
            );
            $data['crossProducts'] = empty($args['include']) ? array() : $this->get_products($args);

        }

        wp_send_json($data);

    }

    public function getProductReviews() {

        $id = $_REQUEST['product_id'] ? $_REQUEST['product_id'] : 21;
        $page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;

        $data = array();
        
        if($product = wc_get_product( $id )) {

            $args = array ('post_type' => 'product', 'post_id' => $id, 'paged' => $page, 'number'  => '100',);
            $comments = get_comments( $args );

            foreach ( $comments as $i => $value ) {
                $data[] = array(
                    'id' => $value->comment_ID,
                    'author' => $value->comment_author,
                    'email' => $value->comment_author_email,
                    'content' => $value->comment_content,
                    'rating' =>get_comment_meta( $value->comment_ID, 'rating', true ),
                    'avatar' => get_avatar_url($value->comment_author_email, array('size' => 450)),
                    'date' => $value->comment_date
                );
            }

        }

        wp_send_json($data);

    }

    /* WC Marketplace */
    public function get_wcmap_vendor_details() {
        $id = $_REQUEST['id'];
        $vendor = get_wcmp_vendor($id);
        $vendor_term_id = get_user_meta( $vendor->id, '_vendor_term_id', true );
        $vendor_review_info = wcmp_get_vendor_review_info($vendor_term_id);
        $avg_rating = number_format(floatval($vendor_review_info['avg_rating']), 1);
        $rating_count = $vendor_review_info['total_rating'];
        $data = array(
            'id' => $vendor->id,
            'login' => $vendor->user_data->data->user_login,
            'first_name' => get_user_meta($vendor->id, 'first_name', true),
            'last_name' => get_user_meta($vendor->id, 'last_name', true),
            'nice_name'  => $vendor->user_data->data->user_nicename,
            'display_name'  => $vendor->user_data->data->display_name,
            'email'  => $vendor->user_data->data->email,
            'url'  => $vendor->user_data->data->user_url,
            'registered'  => $vendor->user_data->data->user_registered,
            'status'  => $vendor->user_data->data->user_status,
            'roles'  => $vendor->user_data->roles,
            'allcaps'  => $vendor->user_data->allcaps,
            'timezone_string'  => get_user_meta($vendor->id, 'timezone_string', true),
            'longitude'  => get_user_meta($vendor->id, '_store_lng', true),
            'latitude'  => get_user_meta($vendor->id, '_store_lat', true),
            'gmt_offset'  => get_user_meta($vendor->id, 'gmt_offset', true),
            'shop' => array(
                'url'  => $vendor->permalink,
                'title'  => $vendor->page_title,
                'slug'  => $vendor->page_slug,
                'description'  => $vendor->description,
                'image'  => wp_get_attachment_image_src( $vendor->image, 'medium', false ),
                'banner'  => wp_get_attachment_image_src( $vendor->banner, 'large', false ),
            ),
            'address' => array(
                'address_1'  => $vendor->address_1,
                'address_2'  => $vendor->address_2,
                'city'  => $vendor->city,
                'state'  => $vendor->state,
                'country'  => $vendor->country,
                'postcode'  => $vendor->postcode,
                'phone'  => $vendor->phone,
            ),
            'social' => array(
                'facebook'  => $vendor->fb_profile,
                'twitter'  => $vendor->twitter_profile,
                'google_plus'  => $vendor->google_plus_profile,
                'linkdin'  => $vendor->linkdin_profile,
                'youtube'  => $vendor->youtube,
                'instagram'  => $vendor->instagram,
            ),
            'payment' => array(
                'payment_mode'  => $vendor->payment_mode,
                'bank_account_type'  => $vendor->bank_account_type,
                'bank_name'  => $vendor->bank_name,
                'bank_account_number'  => $vendor->bank_account_number,
                'bank_address'  => $vendor->bank_address,
                'account_holder_name'  => $vendor->account_holder_name,
                'aba_routing_number'  => $vendor->aba_routing_number,
                'destination_currency'  => $vendor->destination_currency,
                'iban'  => $vendor->iban,
                'paypal_email'  => $vendor->paypal_email,
            ),
            'message_to_buyers'  => $vendor->message_to_buyers,
            'rating_count' => $rating_count,
            'avg_rating' => $avg_rating,
        );

        wp_send_json($data);

        die();
    }

    // Dokan Features
    public function get_vendors_list(){

        $paged    = $_REQUEST['page'];
        $per_page = $_REQUEST['per_page'];
        $length  = absint( $per_page );
        $offset  = ( $paged - 1 ) * $length;

        // Get all vendors
        $vendor_paged_args = array (
            'role'  => 'seller',
            'orderby' => 'registered',
            'offset'  => $offset,
            'number'  => $per_page,
            'status'     => 'approved',
        );

        $show_products = 'yes';

        if ($show_products == 'yes') $vendor_total_args['query_id'] = 'vendors_with_products';

        $vendor_query = New WP_User_Query( $vendor_paged_args );
        $all_vendors = $vendor_query->get_results();

        $vendors = array();
        foreach ( $all_vendors as $i => $value ) {

            $store_info = dokan_get_store_info( $all_vendors[$i]->ID );
            $store_info['payment'] = null;
            $vendors[] = array(
                'id' => $all_vendors[$i]->ID,
                'store_info' => $store_info,
                'store_name' => $store_info['store_name'],
                'banner_url' => wp_get_attachment_url( $store_info['banner'] ),
                'logo' => wp_get_attachment_url( $store_info['banner'] ),
            ); 
            
        }

        wp_send_json(  $vendors );

    }

    // WCFM Features
    public function get_wcfm_vendor_list($distance) {

        global $WCFM, $WCFMmp, $wpdb;
        
        $search_term     = isset( $_REQUEST['search_term'] ) ? sanitize_text_field( $_REQUEST['search_term'] ) : '';
        $search_category = isset( $_REQUEST['wcfmmp_store_category'] ) ? sanitize_text_field( $_REQUEST['wcfmmp_store_category'] ) : '';
        $pagination_base = isset( $_REQUEST['pagination_base'] ) ? sanitize_text_field( $_REQUEST['pagination_base'] ) : '';
        $paged           = isset( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : 1;
        $per_row         = isset( $_REQUEST['per_row'] ) ? absint( $_REQUEST['per_row'] ) : 3;
        $per_page        = isset( $_REQUEST['per_page'] ) ? absint( $_REQUEST['per_page'] ) : 10;
        $includes        = isset( $_REQUEST['includes'] ) ? sanitize_text_field( $_REQUEST['includes'] ) : '';
        $excludes        = isset( $_REQUEST['excludes'] ) ? sanitize_text_field( $_REQUEST['excludes'] ) : '';
        $orderby         = isset( $_REQUEST['orderby'] ) ? sanitize_text_field( $_REQUEST['orderby'] ) : 'newness_asc';
        $has_orderby     = isset( $_REQUEST['has_orderby'] ) ? sanitize_text_field( $_REQUEST['has_orderby'] ) : '';
        $has_product     = isset( $_REQUEST['has_product'] ) ? sanitize_text_field( $_REQUEST['has_product'] ) : '';
        $sidebar         = isset( $_REQUEST['sidebar'] ) ? sanitize_text_field( $_REQUEST['sidebar'] ) : '';
        $theme           = isset( $_REQUEST['theme'] ) ? sanitize_text_field( $_REQUEST['theme'] ) : 'simple';
        $search_data     = array();
        
        if( isset( $_REQUEST['search_data'] ) ) {
            $search_data     = array('distance' => $distance);
            parse_str($_REQUEST['search_data'], $search_data);
        }
        
        $length  = absint( $per_page );
        $offset  = ( $paged - 1 ) * $length;
        
        $search_data['excludes'] = $excludes;
        
        if( $includes ) $includes = explode(",", $includes);
        else $includes = array();

        $stores = $WCFMmp->wcfmmp_vendor->wcfmmp_search_vendor_list( true, $offset, $length, $search_term, $search_category, $search_data, $has_product, $includes );

        $store_data = array();
        foreach ( $stores as $store_id => $store_name ) {

            $store_user = wcfmmp_get_store( $store_id );

            $banner = $store_user->get_list_banner();
            if( !$banner ) {
                $banner = isset( $WCFMmp->wcfmmp_marketplace_options['store_list_default_banner'] ) ? $WCFMmp->wcfmmp_marketplace_options['store_list_default_banner'] : $WCFMmp->plugin_url . 'assets/images/default_banner.jpg';
                $banner = apply_filters( 'wcfmmp_list_store_default_bannar', $banner );
            }

            $store_info = $store_user->get_shop_info();
            $store_info['payment'] = null;
            $store_info['commission'] = null;
            $store_info['withdrawal'] = null;

            $store_data[] = array(
                'id' => $store_id,
                'name' => isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'wc-multivendor-marketplace' ),
                'icon' => $store_user->get_avatar(),
                'banner' => $banner,
                //'store_name' => apply_filters( 'wcfmmp_store_title', $store_name , $store_id ),
                'address' => $store_user->get_address_string(), 
                'description' => $store_user->get_shop_description(),
                'latitude'    => isset( $store_info['store_lat'] ) ? esc_attr( $store_info['store_lat'] ) : null,
                'longitude'    => isset( $store_info['store_lng'] ) ? esc_attr( $store_info['store_lng'] ) : null,
                'average_rating' => (float)wc_format_decimal( get_user_meta( $vendor_id, '_wcfmmp_total_review_count', true ), 2 ),
                'rating_count' => (int)$store_user->get_total_review_count(),
                'is_close' => $this->wcfmmp_is_store_close($store_id),
            );
        }

        return $store_data;
    }

    /* Reward Points */
    public function get_point_purchase() {

        $points_earned = 0;

        foreach ( WC()->cart->get_cart() as $item_key => $item ) {
            $points_earned += apply_filters( 'woocommerce_points_earned_for_cart_item', WC_Points_Rewards_Product::get_points_earned_for_product_purchase( $item['data'] ), $item_key, $item ) * $item['quantity'];
        }

        // reduce by any discounts.  One minor drawback: if the discount includes a discount on tax and/or shipping
        //  it will cost the customer points, but this is a better solution than granting full points for discounted orders
        if ( version_compare( WC_VERSION, '2.3', '<' ) ) {
            $discount = WC()->cart->discount_cart + WC()->cart->discount_total;
        } else {
            $discount = WC()->cart->discount_cart;
        }

        $discount_amount = min( WC_Points_Rewards_Manager::calculate_points( $discount ), $points_earned );

        // apply a filter that will allow users to manipulate the way discounts affect points earned
        $points_earned = apply_filters( 'wc_points_rewards_discount_points_modifier', $points_earned - $discount_amount, $points_earned, $discount_amount );

        // check if applied coupons have a points modifier and use it to adjust the points earned
        $coupons = WC()->cart->get_applied_coupons();

        if ( ! empty( $coupons ) ) {

            $points_modifier = 0;

            // get the maximum points modifier if there are multiple coupons applied, each with their own modifier
            foreach ( $coupons as $coupon_code ) {

                $coupon = new WC_Coupon( $coupon_code );
                $coupon_id = version_compare( WC_VERSION, '3.0', '<' ) ? $coupon->id : $coupon->get_id();
                $wc_points_modifier = get_post_meta( $coupon_id, '_wc_points_modifier' );

                if ( ! empty( $wc_points_modifier[0] ) && $wc_points_modifier[0] > $points_modifier ) {
                    $points_modifier = $wc_points_modifier[0];
                }
            }

            if ( $points_modifier > 0 ) {
                $points_earned = round( $points_earned * ( $points_modifier / 100 ) );
            }
        }

        return apply_filters( 'wc_points_rewards_points_earned_for_purchase', $points_earned, WC()->cart );
    }

    public function ajax_maybe_apply_discount() {
        
        // bail if the discount has already been applied
        $existing_discount = WC_Points_Rewards_Discount::get_discount_code();

        // bail if the discount has already been applied
        if ( ! empty( $existing_discount ) && WC()->cart->has_discount( $existing_discount ) )          {
            wc_add_notice( 'Discount already applied', 'error' );
            wc_print_notices();
            die;
        }

        // Get discount amount if set and store in session
        WC()->session->set( 'wc_points_rewards_discount_amount', ( ! empty( $_POST['discount_amount'] ) ? absint( $_POST['discount_amount'] ) : '' ) );

        // generate and set unique discount code
        $discount_code = WC_Points_Rewards_Discount::generate_discount_code();

        // apply the discount
        WC()->cart->add_discount( $discount_code );

        wc_print_notices();
        die;
    }
    
    public function getPointsHistory(){
        
        $per_page = 20;
        $pagenum = 1;

        if ( isset( $_REQUEST['pagenum'] ))
        $pagenum = $_REQUEST['pagenum'];

        $args = array(
            'orderby' => array(
                'field' => 'date',
                'order' => 'DESC',
            ),
            'per_page'         => $per_page,
            'paged'            => $pagenum,
            'calc_found_rows' => true,
        );

        $args['user'] = get_current_user_id();

        $data = array(
            'items' => WC_Points_Rewards_Points_Log::get_points_log_entries( $args ),
            'points' => WC_Points_Rewards_Manager::get_users_points($args['user']),
            'points_vlaue' => WC_Points_Rewards_Manager::get_users_points_value($args['user']),
        );

        wp_send_json($data);
    }
    /* Reward Points */

    public function getProducts(){
        
        $products = $this->get_products();

        wp_send_json($products);
    }

    public function getProduct() {

        if(isset($_REQUEST['product_id'])) {
            $id = $_REQUEST['product_id'];
            $product = wc_get_product($id);
        } else if (isset($_REQUEST['sku'])) {
            $sku = $_REQUEST['sku'];
            $id = wc_get_product_id_by_sku($sku);
            $product = wc_get_product($id);
        }
        
        if($product) {

            $available_variations = $product->get_type() == 'variable' ? $product->get_available_variations() : null;
            $variation_attributes = $product->get_type() == 'variable' ? $product->get_variation_attributes() : null;

            $variation_options = array();
            $emptyValuesKeys = array();
            if($available_variations != null) {
                $values = array();
                foreach ( $available_variations as $key => $value ) {
                    foreach ( $value['attributes'] as $atr_key => $atr_value ) {
                        $available_variations[$key]['option'][] = array(
                            'key' => $atr_key,
                            'value' => $this->attribute_slug_to_title($atr_key, $atr_value) //make it name
                        );
                        $values[] = $this->attribute_slug_to_title($atr_key, $atr_value);
                        if(empty($atr_value))
                        $emptyValuesKeys[] = $atr_key;

                        $variation = wc_get_product( $value['variation_id'] );

                        $regular_price = $variation->get_regular_price();
                        $sale_price = $variation->get_sale_price();

                        $available_variations[$key]['formated_price'] = $regular_price ? strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $regular_price ) ))) : strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $variation->get_price() ) )));
                        $available_variations[$key]['formated_sales_price'] = $sale_price ? strip_tags(wc_price(wc_get_price_to_display( $variation, array( 'price' => $sale_price ) ))) : null;
                    }
                    $available_variations[$key]['image_id'] = null;
                }
                if($variation_attributes)
                foreach ( $variation_attributes as $attribute_name => $options ) {

                    $new_options = array();
                    foreach (array_values($options) as $key => $value) {
                        $new_options[] = $this->attribute_slug_to_title($attribute_name, $value);
                    }
                    if (!in_array('attribute_' . $attribute_name, $emptyValuesKeys)) {
                        $options = array_intersect ( array_values($new_options) , $values );
                    }
                    $variation_options[] = array(
                        'name' => wc_attribute_label( $attribute_name ),
                        'options'   => (array)$options,
                        'attribute' => wc_attribute_label($attribute_name),
                    );
                }
            }

            $results = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'sku' => $product->get_sku( 'view' ),
                'type' => $product->get_type(),
                'status' => $product->get_status(),
                'permalink'  => $product->get_permalink(),
                'description' => $product->get_description(),
                'short_description' => $product->get_short_description(),
                'formated_price' => $product->get_regular_price() ? strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ))) : strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) ))),
                'formated_sales_price' => $product->get_sale_price() ? strip_tags(wc_price(wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) ))) : null,
                'price' => (int)$product->get_price(),
                'regular_price' => (int)$product->get_regular_price(),
                'sale_price' => (int)$product->get_sale_price(),
                'stock_status' => $product->get_stock_status(),
                'stock_quantity'     => $product->get_stock_quantity(),
                'on_sale' => $product->is_on_sale( 'view' ),
                'average_rating'        => wc_format_decimal( $product->get_average_rating(), 2 ),
                'rating_count'          => $product->get_rating_count(),
                'related_ids'           => array_map( 'absint', array_values( wc_get_related_products( $product->get_id() ) ) ),
                'upsell_ids'            => array_map( 'absint', $product->get_upsell_ids( 'view' ) ),
                'cross_sell_ids'        => array_map( 'absint', $product->get_cross_sell_ids( 'view' ) ),
                'parent_id'             => $product->get_parent_id( 'view' ),
                'images' => $this->get_images($product),
                'attributes'            => $this->get_attributes( $product ),
                'availableVariations'   => $available_variations,
                'variationAttributes'   => $variation_attributes,
                'meta_data'             => $product->get_meta_data(),
                'variationOptions'      => $variation_options,
                'total_sales'           => (int)$product->get_total_sales(),
                'vendor'                => $this->get_product_vendor($product->get_id()),
                'grouped_products'      => $product->get_children(),
                'children'              => $children,
                //'categories'            => wc_get_object_terms( $product->get_id(), 'product_cat', 'term_id' ),
                //'tags'               => wc_get_object_terms( $product->get_id(), 'product_tag', 'name' ),
                //'cashback_amount'       => woo_wallet()->cashback->get_product_cashback_amount($product) //UnComment Whne cashback need only
            );

            wp_send_json($results);

        } else wp_send_json((object)array());
        
    }

    public function get_vendors($distance = 10) {

        switch ($this->which_vendor()) {
            case 'dokan':
                return $this->get_dokan_vendor_list($distance);
                break;
            case 'wcfm':
                return $this->get_wcfm_vendor_list($distance);
                break;
            case 'wc_marketplace':
                return $this->get_wc_marketplace_vendor_list();
                break;
            case 'product_vendor':
                return $this->get_product_vendor_list();
                break;
            default:
                return array();
        }
    }

    private function which_vendor() {
        if ( ! function_exists( 'is_plugin_active' ) ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if(is_plugin_active( 'dokan-lite/dokan.php') || is_plugin_active( 'dokan/dokan.php' )){
            return 'dokan';
        }
        else if(is_plugin_active( 'dc-woocommerce-multi-vendor/dc_product_vendor.php' )){
            return 'wc_marketplace';
        }
        else if(is_plugin_active( 'wc-multivendor-marketplace/wc-multivendor-marketplace.php' )){      
            return 'wcfm';
        } else if(is_plugin_active( 'woocommerce-product-vendors/woocommerce-product-vendors.php' )){      
            return 'product_vendor';
        }
        else return null;
    }

    public function get_product_vendor_list(){
        $terms = get_terms( 'wcpv_product_vendors', array( 'hide_empty' => false ) );

        $vendors = array();
        $vendor_data = array();
        foreach ( $terms as $term ) {

            $vendor_data = get_term_meta( $term->term_id, 'vendor_data', true );

            $image_icon = wp_get_attachment_image_src( $vendor_data['logo'], 'medium', false );
            $icon = $image_icon ? $image_icon[0] : '';

            $vendors[] = array(
                'id' => $term->term_id,
                'product_vendor' => $term->term_id,
                'name' => $term->name,
                'icon' => $icon,
                'banner' => null,
                'address' => null, 
                'description' => $term->description,
                'latitude'   => null,
                'longitude'   => null,
                'average_rating' => null,
                'rating_count' => null,
                'count' => $term->count,
                'wcpv_product_vendors' => $term->term_id,
            );
        }

        return $vendors;
    }

    public function get_dokan_vendor_list($distance){

        $post = $_POST;
        $_GET = $_POST;

        $vendors  = array();
        $paged    = isset( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : 1;
        $per_page = isset( $_REQUEST['per_page'] ) ? absint( $_REQUEST['per_page'] ) : 100;
        $length   = absint( $per_page );
        $offset   = ( $paged - 1 ) * $length;
        $search_term     = isset( $_REQUEST['search'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['search'] ) ) : '';

        // Get all vendors
        $seller_args = array (
            'role__in'   => array( 'seller', 'administrator' ),
            'orderby' => 'registered',
            'offset'  => $offset,
            'number'  => $per_page,
            'status'     => 'approved',
        );

        if ( '' != $search_term ) {
            $seller_args['meta_query'] = array(
                array(
                    'key'     => 'dokan_store_name',
                    'value'   => $search_term,
                    'compare' => 'LIKE',
                ),
            );
        }

        $show_products = 'yes';

        if ($show_products == 'yes') $vendor_total_args['query_id'] = 'vendors_with_products';

        $post = $_POST;

        if(isset($post['distance']) && isset($post['latitude']) && isset($post['longitude'])) {
            set_query_var( 'address', $post['address'] );
            set_query_var( 'distance', $post['distance'] );
            set_query_var( 'latitude', $post['latitude'] );
            set_query_var( 'longitude', $distance );
        }
     
        $all_vendors = dokan_get_sellers( apply_filters( 'dokan_seller_listing_args', $seller_args, $_GET ) );

        $vendors = array();
        foreach ( $all_vendors['users'] as $i => $value ) {

            $store_info = dokan_get_store_info( $value->ID );
            $store_info['payment'] = null;

            $store_user   = dokan()->vendor->get( $value->ID );
            $rating = $store_user->get_rating();

            // For Dokan Light
            $location = explode(',', $store_info['location']);
            $latitude = number_format((float)$location[0], 6);
            $longitude = number_format((float)$location[1], 6);

            //For Dokan Pro
            //$latitude = get_user_meta( $value->ID, 'dokan_geo_latitude', true );
            //$longitude = get_user_meta( $value->ID, 'dokan_geo_longitude', true );

            $vendors[] = array(
                'id' => $value->ID,
                'name' => $store_info['store_name'],
                'banner' => $store_user->get_banner(),
                'icon' => $store_user->get_avatar(),
                'address' => $store_info['address'],
                'description' => $store_info['address']['street_1'],
                'is_close' => dokan_is_store_open( $value->ID ),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'average_rating' => $rating['count'] == 0 ? 0 : (float)$rating['rating'],
                'rating_count' => $rating['count'],
            ); 
            
        }

        return $vendors;
    }

    public function get_wc_marketplace_vendor_list(){

        $args = array(
            'number' => $_REQUEST['per_page'],
            'offset' => ( $_REQUEST['page'] - 1 ) * $_REQUEST['per_page']
        );

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
        }

        if ( ! empty( $_REQUEST['order'] ) ) {
            $args['order'] = $_REQUEST['order'];
        }
        
        if ( ! empty( $_REQUEST['status'] ) ) {
            if($_REQUEST['status'] == 'pending') $args['role'] = 'dc_pending_vendor';
            else $args['role'] = $this->post_type;
        }

        $object = array();
        $response = array();
        $store_data = array();

        $args = wp_parse_args($args, array('role' => 'dc_vendor', 'fields' => 'ids', 'orderby' => 'registered', 'order' => 'ASC'));
        
        $user_query = new WP_User_Query($args);
        if (!empty($user_query->results)) {
            foreach ( $user_query->results as $vendor_id) {
                $vendor = get_wcmp_vendor($vendor_id);
                $vendor_term_id = get_user_meta( $vendor->id, '_vendor_term_id', true );
                $vendor_review_info = wcmp_get_vendor_review_info($vendor_term_id);
                $avg_rating = number_format(floatval($vendor_review_info['avg_rating']), 1);
                $rating_count = $vendor_review_info['total_rating'];

                $image_icon = wp_get_attachment_image_src( $vendor->image, 'medium', false );
                $icon = $image_icon ? $image_icon[0] : '';

                $image_banner = wp_get_attachment_image_src( $vendor->image, 'medium', false );
                $banner = $image_banner ? $image_banner[0] : '';

                

                $store_data[] = array(
                    'id' => $vendor->id,
                    'name' => $vendor->page_title,
                    'icon' => $icon,
                    'banner' => $banner,
                    //'store_name' => apply_filters( 'wcfmmp_store_title', $store_name , $store_id ),
                    //'address' => $store_user->get_address_string(), 
                    //'description' => $store_user->get_shop_description(),
                    'latitude'    => get_user_meta($vendor->id, '_store_lng', true),
                    'longitude'    => get_user_meta($vendor->id, '_store_lat', true),
                    'average_rating' => (float)wc_format_decimal( $avg_rating, 2 ),
                    'rating_count' => (int)$rating_count,
                );
            }
        }

        return $store_data;
    }

    function wcfmmp_is_store_close( $vendor_id ) {
        global $WCFM, $WCFMmp;
        
        $is_store_close = false;
        
        if( !$WCFM->wcfm_vendor_support->wcfm_vendor_has_capability( $vendor_id, 'store_hours' ) ) return $is_store_close;
        
        if( $vendor_id ) {
            $wcfm_vendor_store_hours = get_user_meta( $vendor_id, 'wcfm_vendor_store_hours', true );
            if( !empty( $wcfm_vendor_store_hours ) ) {
                $wcfm_store_hours_enable = isset( $wcfm_vendor_store_hours['enable'] ) ? 'yes' : 'no';
                if( $wcfm_store_hours_enable == 'yes' ) {
                    $wcfm_store_hours_disable_purchase = isset( $wcfm_vendor_store_hours['disable_purchase'] ) ? 'yes' : 'no';
                    if( $wcfm_store_hours_disable_purchase == 'yes' ) {
                        $wcfm_store_hours_off_days = isset( $wcfm_vendor_store_hours['off_days'] ) ? $wcfm_vendor_store_hours['off_days'] : array();
                        $wcfm_store_hours_day_times = isset( $wcfm_vendor_store_hours['day_times'] ) ? $wcfm_vendor_store_hours['day_times'] : array();
                        
                        $current_time = current_time( 'timestamp' );
                        
                        $today = date( 'N', $current_time );
                        $today -= 1;
                        
                        $today_date = date( 'Y-m-d', $current_time );
                        
                        // OFF Day Check
                        if( !empty( $wcfm_store_hours_off_days ) ) {
                            if( in_array( $today,  $wcfm_store_hours_off_days ) )  $is_store_close = true;
                        }
                        
                        // Closing Hours Check
                        if( !$is_store_close && !empty( $wcfm_store_hours_day_times ) ) {
                            if( isset( $wcfm_store_hours_day_times[$today] ) ) {
                                $wcfm_store_hours_day_time_slots = $wcfm_store_hours_day_times[$today];
                                if( !empty( $wcfm_store_hours_day_time_slots ) ) {
                                    if( isset( $wcfm_store_hours_day_time_slots[0] ) && isset( $wcfm_store_hours_day_time_slots[0]['start'] ) ) {
                                        if( !empty( $wcfm_store_hours_day_time_slots[0]['start'] ) && !empty( $wcfm_store_hours_day_time_slots[0]['end'] ) ) {
                                            $is_store_close = true;
                                            foreach( $wcfm_store_hours_day_time_slots as $slot => $wcfm_store_hours_day_time_slot ) {
                                                $open_hours  = isset( $wcfm_store_hours_day_time_slot['start'] ) ? strtotime( $today_date . ' ' . $wcfm_store_hours_day_time_slot['start'] ) : '';
                                                $close_hours = isset( $wcfm_store_hours_day_time_slot['end'] ) ? strtotime( $today_date . ' ' . $wcfm_store_hours_day_time_slot['end'] ) : '';
                                                //wcfm_log( $current_time . " => " . $open_hours . " ::" . $close_hours );
                                                //wcfm_log( date( wc_date_format() . ' ' . wc_time_format(), $current_time ) . " => " . date( wc_date_format() . ' ' . wc_time_format(), $open_hours ) . " ::" . date( wc_date_format() . ' ' . wc_time_format(), $close_hours ) );
                                                if( $open_hours && $close_hours ) {
                                                    if( ( $current_time > $open_hours ) && ( $current_time < $close_hours ) )  {
                                                        $is_store_close = false;
                                                        break;
                                                    }
                                                } else {
                                                    $is_store_close = false;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return $is_store_close;
    }

    public function cancel_order() {
        $order_id = $_REQUEST['id'];
        $order = new WC_Order($order_id);
        if(get_current_user_id() == $order->get_user_id())
        $order->update_status('cancelled', 'order_note');
        $this->getOrder();
    }


}
