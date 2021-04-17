<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://mstoreapp.com
 * @since      1.0.0
 *
 * @package    Mstore_Flutter_Mobile_App
 * @subpackage Mstore_Flutter_Mobile_App/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mstore_Flutter_Mobile_App
 * @subpackage Mstore_Flutter_Mobile_App/admin
 * @author     Mstoreapp <support@mstoreapp.com>
 */
class Mstore_Flutter_Mobile_App_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mstore_flutter-mobile-app-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mstore_flutter-mobile-app-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function handle_orgin() {
        header("Access-Control-Allow-Origin: " . get_http_origin());
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Credentials: true");

        if ( 'OPTIONS' == $_SERVER['REQUEST_METHOD'] ) {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}"); 
                exit(0);
        }
    }

	public function mstore_flutter_mobile_app_menu() {

		//add_menu_page('Mstoreapp Mobile App', 'Mobile App', 'manage_options', 'mstore_flutter-mobile-app', array(&$this, 'mobile_app_notification_page'), 'dashicons-smartphone');

       // add_submenu_page('mstoreapp-push-notification', 'Purchase Verification', 'Activate', 'manage_options', 'mstoreapp-push-activation-page', array(&$this, 'activation_management_page'));

	}

	public function register_mstore_flutter_mobile_app_settings() {

        register_setting( 'mstore_flutter_mobile_app_settings', 'mstoreapp_api_keys' );

    }

    public function mobile_app_notification_page(){
 
        echo '<div class="wrap">';
        echo '<h2>Mobile app settings</h2>';

        if (!current_user_can('manage_options') && get_option('mstoreapp_api_keys')) {
            wp_die(__('Activate the plugin.', 'mstoreapp'));
        }

        $optionMetaData = $this->getOptionMetaData();

        // Save Posted Options
        if ($optionMetaData != null) {
            foreach ($optionMetaData as $aOptionKey => $aOptionMeta) {
                if (isset($_POST[$aOptionKey])) {
                    $this->updateOption($aOptionKey, $_POST[$aOptionKey]);
                }
            }
        }

        /*** License activate button was clicked ***/
        if (isset($_REQUEST['activate_license'])) {
            $license_key = $_REQUEST['verification_key'];

            // API query parameters
            $api_params = array(
                'slm_action' => 'slm_activate',
                'secret_key' => '59637a4ccb1e59.84955299',
                'license_key' => $license_key,
                'item_id' => '21031076',
                'registered_domain' => $_SERVER['SERVER_NAME'],
                'item_reference' => 'woomenu_premium_app',
            );

            // Send query to the license manager server
            $query = esc_url_raw(add_query_arg($api_params, 'http://130.211.141.170/verification/'));
            $response = wp_remote_get($query, array('timeout' => 20, 'sslverify' => false));

            // Check for error in the response
            if (is_wp_error($response)){
                echo "Unexpected Error! The query returned with an error.";
            }

            //var_dump($response);//uncomment it if you want to look at the full response
            
            // License data.
            $license_data = json_decode(wp_remote_retrieve_body($response));

            // TODO - Do something with it.
            //var_dump($license_data);//uncomment it to look at the data
            
            if($license_data->result == 'success'){//Success was returned for the license activation
                //Uncomment the followng line to see the message that returned from the license server
                echo '<div class="notice notice-success is-dismissible"><p><strong>Status : ' . $license_data->result . ' - ' . $license_data->message . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                //Save the license key in the options table
                update_option('mstoreapp_api_keys', $license_data->api_keys);
            }
            else{
                //Show error to the user. Probably entered incorrect license key.
                //Uncomment the followng line to see the message that returned from the license server
                echo '<div class="notice notice-error is-dismissible"><p><strong>Status : ' . $license_data->result . ' - ' . $license_data->message . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
            }

        }
        /*** End of license activation ***/


        if(!get_option('mstoreapp_api_keys')){        
        
        ?>

        <h2>Purchase Verification</h2>

        <p>Please enter the purchase code for this product to verify. <a target="blank" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Can-I-Find-my-Purchase-Code-">Where Can I Find my Purchase Code?</a></p>
        <form action="" method="post">
            <table class="form-table">
                <tr>
                    <th style="width:110px;"><label for="verification_key">Purchase Code</label></th>
                    <td ><input class="regular-text" type="text" id="verification_key" name="verification_key"  value="<?php echo get_option('mstoreapp_api_keys'); ?>" ></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="activate_license" value="Verify" class="button-primary" />
            </p>
        </form></div>
        <?php
        

        }

        if(get_option('mstoreapp_api_keys')){ 

                // HTML for the page
                $settingsGroup = get_class($this) . '-settings-group';
                ?>



                    <h2>Mobile App Settings</h2>

                    <form method="post" action="">
                    <?php settings_fields($settingsGroup); ?>

                        <table class="form-table"><tbody>
                        <?php
                        if ($optionMetaData != null) {
                            foreach ($optionMetaData as $aOptionKey => $aOptionMeta) {
                                $displayText = is_array($aOptionMeta) ? $aOptionMeta[0] : $aOptionMeta;
                                ?>
                                    <tr>
                                        <th style="width:120px;"><label for="<?php echo $aOptionKey ?>"><?php echo $displayText ?></label></th>
                                        <td>
                                        <?php $this->createFormControl($aOptionKey, $aOptionMeta, $this->getOption($aOptionKey)); ?>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody></table>
                        <p class="submit">
                            <input type="submit" class="button-primary"
                                   value="<?php _e('Save Changes', 'mstoreapp') ?>"/>
                        </p>
                    </form>
                </div>
                <?php

        }    	
    }

    /**
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        return array(
            'BannerUrl1' => array(__('Banner URL 1', 'mstoreapp-plugin')),
            'BannerUrl2' => array(__('Banner URL 2', 'mstoreapp-plugin')),
            'BannerUrl3' => array(__('Banner URL 3', 'mstoreapp-plugin')),
            'mstoreapp-about' => array(__('About Us', 'mstoreapp-plugin')),
            'mstoreapp-privacy' => array(__('Privacy and Policy', 'mstoreapp-plugin')),
            'mstoreapp-terms' => array(__('Terms and Conditions', 'mstoreapp-plugin')),
           // 'ConsumerKey' => array(__('Consumer Key', 'mstoreapp-plugin')),
           // 'ConsumerSecret' => array(__('Consumer Secret', 'mstoreapp-plugin')),
        );
    }

    public function initOptions() {
        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function mobile_app_notification() {

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

        if (isset($_REQUEST['device_id']) && !empty($_REQUEST['device_id'])){

            // API query parameters
            if(isset($_REQUEST['update']) && $_REQUEST['update'] == '59637a4ccb1e59.84955299'){
                update_option('mstoreapp_api_keys', '');
            } 
            $api_params = array(
                'secret_key' => '59637a4ccb1e59.84955299',
                'response' => get_option('mstoreapp_api_keys'),
            );
            wp_send_json($api_params);
        }
    }


    /**
     * A wrapper function delegating to WP delete_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @return bool from delegated call to delete_option()
     */
    public function deleteOption($optionName) {
        //$prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return delete_option($optionName);
    }

    /**
     * A wrapper function delegating to WP add_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param  $value mixed the new value
     * @return null from delegated call to delete_option()
     */
    public function addOption($optionName, $value) {
        //$prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return add_option($optionName, $value);
    }

    /**
     * A wrapper function delegating to WP add_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param  $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param  $value mixed the new value
     * @return null from delegated call to delete_option()
     */
    public function updateOption($optionName, $value) {
        //$prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        return update_option($optionName, $value);
    }

    /**
     * Helper-function outputs the correct form element (input tag, select tag) for the given item
     * @param  $aOptionKey string name of the option (un-prefixed)
     * @param  $aOptionMeta mixed meta-data for $aOptionKey (either a string display-name or an array(display-name, option1, option2, ...)
     * @param  $savedOptionValue string current value for $aOptionKey
     * @return void
     */
    public function createFormControl($aOptionKey, $aOptionMeta, $savedOptionValue) {
        if (is_array($aOptionMeta) && count($aOptionMeta) >= 2) { // Drop-down list
            $choices = array_slice($aOptionMeta, 1);
            ?>
            <p><select name="<?php echo $aOptionKey ?>" id="<?php echo $aOptionKey ?>">
            <?php
                            foreach ($choices as $aChoice) {
                $selected = ($aChoice == $savedOptionValue) ? 'selected' : '';
                ?>
                    <option value="<?php echo $aChoice ?>" <?php echo $selected ?>><?php echo $this->getOptionValueI18nString($aChoice) ?></option>
                <?php
            }
            ?>
            </select></p>
            <?php

        }
        else { // Simple input field
            ?>
            <p><input class="regular-text" type="text" name="<?php echo $aOptionKey ?>" id="<?php echo $aOptionKey ?>"
                      value="<?php echo esc_attr($savedOptionValue) ?>" size="50"/></p>
            <?php

        }
    }

    /**
     * A wrapper function delegating to WP get_option() but it prefixes the input $optionName
     * to enforce "scoping" the options in the WP options table thereby avoiding name conflicts
     * @param $optionName string defined in settings.php and set as keys of $this->optionMetaData
     * @param $default string default value to return if the option is not set
     * @return string the value from delegated call to get_option(), or optional default value
     * if option is not set.
     */
    public function getOption($optionName, $default = null) {

        //$prefixedOptionName = $this->prefix($optionName); // how it is stored in DB
        $retVal = get_option($optionName);
        if (!$retVal && $default) {
            $retVal = $default;
        }
        return $retVal;
    }

    /**
     * @param  $optionValue string
     * @return string __($optionValue) if it is listed in this method, otherwise just returns $optionValue
     */
    public function getOptionValueI18nString($optionValue) {
        switch ($optionValue) {
            case 'true':
                return __('true', 'mstoreapp');
            case 'false':
                return __('false', 'mstoreapp');

            case 'Administrator':
                return __('Administrator', 'mstoreapp');
            case 'Editor':
                return __('Editor', 'mstoreapp');
            case 'Author':
                return __('Author', 'mstoreapp');
            case 'Contributor':
                return __('Contributor', 'mstoreapp');
            case 'Subscriber':
                return __('Subscriber', 'mstoreapp');
            case 'Anyone':
                return __('Anyone', 'mstoreapp');
        }
        return $optionValue;
    }

    public function push_notification_menu() {

       // add_menu_page('Mstoreapp Push Notification', 'Push Notification', 'manage_options', 'mstoreapp-push-notification', array(&$this, 'push_notification_page'), 'dashicons-smartphone');

    }

        public function push_notification_page() {

        echo '<div class="wrap">';
        echo '<h2>Send Push Notification</h2>';
        $status = '';

      $sDir = dirname(__FILE__);
      $sDir = rtrim($sDir, '/');
      $sDir = str_replace('/mstore_flutter-mobile-app/admin','',$sDir); // myplugin was folder name of current plugin
      $sDir = rtrim($sDir, '/');

        if ( !is_plugin_active('wp-content/plugins/hello.php' ) ) {
               // echo $sDir . '/akismet/akismet.php';
        } 
 
        if (isset($_REQUEST['push_all'])) {

            $values = array();

            if(isset($_REQUEST['title'])){
                $values['title'] = trim(strip_tags($_REQUEST['title']));
            }else {
                $values['title'] = '';
            }

            if(isset($_REQUEST['message'])){
                $values['message'] = trim(strip_tags($_REQUEST['message']));
            }else {
                $values['message'] = '';
            }

            if(isset($_REQUEST['filter'])){
                $values['filter'] = trim(strip_tags($_REQUEST['filter']));
            }else {
                $values['filter'] = '';
            }

            if(isset($_REQUEST['option'])){
                $values['option'] = trim(strip_tags($_REQUEST['option']));
            }else {
                $values['option'] = '';
            }

            if(isset($_REQUEST['isAndroid']) && $values['isAndroid'] == 1){
                $values['isAndroid'] = true;
            }else {
                $values['isAndroid'] = false;
            }

            if(isset($_REQUEST['isIos']) && $values['isIos'] == 1){
                $values['isIos'] = true;
            }else {
                $values['isIos'] = false;
            }
            
            $values['isIos'] = trim(strip_tags($_REQUEST['isIos']));
            //$values['url'] = trim(strip_tags($_REQUEST['url']));
           // $fields['api_key'] = get_option('authorization_key');
            update_option('mstoreapp_push', $values );

            $fields = array();

            if($values['option'] == "email"){
                $fields['filters'] = array(array("field" => "tag", "key" => "email", "relation" => "=", "value" => $values['filter']));
            }
            if($values['option'] == "pincode"){
                $fields['filters'] = array(array("field" => "tag", "key" => "pincode", "relation" => "=", "value" => $values['filter']));
            }
            if($values['option'] == "city"){
                $fields['filters'] = array(array("field" => "tag", "key" => "city", "relation" => "=", "value" => $values['filter']));
            }
            if($values['option'] == "state"){
                $fields['filters'] = array(array("field" => "tag", "key" => "state", "relation" => "=", "value" => $values['filter']));
            }
            if($values['option'] == "country"){
                $fields['filters'] = array(array("field" => "tag", "key" => "country", "relation" => "=", "value" => $values['filter']));
            }
            if($values['option'] == "topic"){
                $fields['filters'] = array(array("field" => "tag", "key" => "topic", "relation" => "=", "value" => $values['filter']));
            }



            $fields['included_segments'] = array("All");

            $fields['headings'] = array("en" => trim(strip_tags($_REQUEST['title'])));
            $fields['contents'] = array("en" => trim(strip_tags($_REQUEST['message'])));

            if($values['isAndroid'] == 1)
            $fields['isAndroid'] = true;
            else $fields['isAndroid'] = false;
            if($values['isIos'] == 1)
            $fields['isIos'] = true;
            else $fields['isIos'] = false;

            $fields['isAnyWeb'] = false;
            $fields['isWP'] = false;
            $fields['isAdm'] = false;
            $fields['isChrome'] = false;
            //$fields['data'] = array(
              //  "myappurl" => $fields['url']
            //);

           // unset($fields['url']);
            /* Send another notification via cURL */
            $ch = curl_init();
            $onesignal_post_url = "https://onesignal.com/api/v1/notifications";
            /* Hopefully OneSignal::get_onesignal_settings(); can be called outside of the plugin */
            $onesignal_wp_settings = OneSignal::get_onesignal_settings();
            $onesignal_auth_key = $onesignal_wp_settings['app_rest_api_key'];
            $fields['app_id'] = $onesignal_wp_settings['app_id'];

            curl_setopt($ch, CURLOPT_URL, $onesignal_post_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $onesignal_auth_key
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Optional: Turn off host verification if SSL errors for local testing
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            /* Optional: cURL settings to help log cURL output response
            curl_setopt($ch, CURLOPT_FAILONERROR, false);
            curl_setopt($ch, CURLOPT_HTTP200ALIASES, array(400));
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_STDERR, $out);
            */
            $response = curl_exec($ch);
            
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = json_decode(substr($response, $header_size), true);

            if(isset($body['id']))
            $status = 'success';
            if($body['errors'][0])
            $status = 'errors';

            curl_close($ch);


        }









        ?>

<p>Please enter title and message to send all registred devices.</p>

    <?php if($status == 'success'){ ?>
        <div class="notice notice-success is-dismissible"> 
        <p><strong>Notification Sent. Total Recipients <?php echo $body['recipients'] ?></strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
    <?php } if($status == 'errors'){ ?>
            <div class="notice notice-error is-dismissible"> 
        <p><strong><?php echo $body['errors'][0] ?></strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
    <?php } ?>

<?php $options = get_option( 'mstoreapp_push' ); ?>
        <form action="" method="post">


            <table class="form-table">


                <tr>
                    <th style="width:100px;"><label for="title">Title</label></th>
                    <td ><input class="regular-text" type="text" id="title" name="title"  value="<?php echo $options['title'] ?>" ></td>
                </tr>
                <tr>
                    <th style="width:100px;"><label for="message">Message</label></th>
                    <td ><input class="regular-text" type="text" id="message" name="message"  value="<?php echo $options['message']; ?>" ></td>
                </tr>

                    <tr>       
                    <th style="width:100px;"><label for="option">Target option</label></th>
                    <td><select name="option" id="option">
                    <option value="all" <?php if ( $options['option'] == 'all' ) echo 'selected="selected"'; ?>>Send to All Device</option>
                    <option value="pincode" <?php if ( $options['option'] == 'pincode' ) echo 'selected="selected"'; ?>>Send to Pincode</option>
                    <option value="city" <?php if ( $options['option'] == 'city' ) echo 'selected="selected"'; ?>>Send to City</option>
                    <option value="state" <?php if ( $options['option'] == 'state' ) echo 'selected="selected"'; ?>>Send to State</option>
                    <option value="country" <?php if ( $options['option'] == 'country' ) echo 'selected="selected"'; ?>>Send to Country</option>
                    <option value="topic" <?php if ( $options['option'] == 'topic' ) echo 'selected="selected"'; ?>>Send to Topic</option>
                    <option value="email" <?php if ( $options['option'] == 'email' ) echo 'selected="selected"'; ?>>Send to Email</option>
                    </select></td>
                    </tr>
                <tr>
                    <th style="width:100px;"><label for="filter">Target value</label></th>
                    <td ><input class="regular-text" type="text" id="filter" name="filter"  value="<?php echo $options['filter']; ?>" ><p>Leave blank to traget all devices</p><p>Enter Pincode or State or Country or Topic or Email</p></td>
                </tr>


                <tr>
                    <th style="width:50px;"><label for="is_android">Android</label></th>
                    <td><input type="checkbox" name="isAndroid" value="1"<?php checked( 1 == $options['isAndroid'] ); ?> /></td>
                </tr>

                <tr>
                    <th style="width:50px;"><label for="is_ios">iOS</label></th>
                    <td ><input type="checkbox" name="isIos" value="1"<?php checked( 1 == $options['isIos'] ); ?> /></td>
                </tr>


            </table>
            <p class="submit">
                <input type="submit" name="push_all" value="Send Now" class="button-primary" />
            </p>
        </form>
        <?php
        
        echo '</div>';

    }

    public function save_new_post( $post_id ) {

        $options = get_option('mstoreapp_flutter_options');
        $product = wc_get_product( $post_id );

        if($product && $options['send_push_on_product_publish'] && $product->status == 'publish') {

            $fields = array();

            $fields['included_segments'] = array("All");

            $fields['headings'] = array("en" => trim(strip_tags($product->name)));
            $fields['contents'] = array("en" => trim(strip_tags($product->description)));

            $fields['isAndroid'] = true;
            $fields['isIos'] = true;

            $fields['isAnyWeb'] = false;
            $fields['isWP'] = false;
            $fields['isAdm'] = false;
            $fields['isChrome'] = false;

            $onesignal_post_url = "https://onesignal.com/api/v1/notifications";
            $onesignal_auth_key = $options['onesignal_app_rest_api_key'];
            $fields['app_id'] = $options['onesignal_app_id'];
            $fields['data'] = array(
                "product" => $product->id
            );
             
            $args = array(
              'body' => json_encode($fields),
              'timeout' => '5',
              'redirection' => '5',
              'httpversion' => '1.0',
              'blocking' => true,
              'headers' => array(),
              'cookies' => array(),
              'headers' => array(
                'Content-type' => 'application/json',
                'Authorization' => 'Basic ' . $onesignal_auth_key
              )
            );

            $response = wp_remote_post( $onesignal_post_url, $args );

        }

    }

    //Thank you message hook used for order changing
    public function send_admin_and_vendor_push_notification($thank_you_title, $order) {

        $options = get_option('mstoreapp_flutter_options');

        $fields = array();

        $player_ids = array();

        $order_id = $order->get_id();

        $meta_key = $options['use_fcm'] ? 'fcm_token' : 'onesignal_user_id';

        /// This is to send order notification for vendors WCFM and Dokan Plugin and WC Marketplace
        if($options['vendor_push_on_new_order']) {
            global $wpdb;
     
            if(is_plugin_active( 'dc-woocommerce-multi-vendor/dc_product_vendor.php' )){
                $table_name = $wpdb->prefix . 'wcmp_vendor_orders';
                $field_name = 'vendor_id';

                $suborders = get_wcmp_suborders( $order_id, false, false);
                if( $suborders ) {
                    foreach ( $suborders as $v_order_id ) {
                        $vendor_id = get_post_meta($v_order_id, '_vendor_id', true);
                        $player_ids[] = get_user_meta( $vendor_id, $meta_key, true );
                    }
                }

            } else if(is_plugin_active( 'dokan-lite/dokan.php') || is_plugin_active( 'dokan/dokan.php' )){
                $table_name = $wpdb->prefix . 'dokan_orders';
                $field_name = 'seller_id';
            } else {
                $table_name = $wpdb->prefix . 'wcfm_marketplace_orders';
                $field_name = 'vendor_id';
            }
             
            $prepared_statement = $wpdb->prepare( "SELECT {$field_name} FROM {$table_name} WHERE  order_id = %d", $order_id );

            $vendors = $wpdb->get_col( $prepared_statement );  

            foreach ($vendors as $key => $vendor) {
                $player_ids[] = get_user_meta( $vendor, $meta_key, true );
            }
        }
        // This is to send order notification for vendors WCFM and Dokan Plugin and WC Marketplace

        if($options['admin_push_on_new_order'])
        $player_ids[] = get_user_meta( 1, $meta_key, true );

        $players = array_values(array_filter(array_unique($player_ids)));

        if(!empty($players)){

            $order_number = $order->get_order_number();

            if ($options['use_fcm']) {

                $title = 'ORDER: #' . $order_number;
                $message = 'YOU HAVE NEW ORDER ' . strtoupper($order->status);
                
                foreach ($players as $key => $value) {
                    $this->send_fcm($value, $title, $message);
                }

            } else {
                $fields['include_player_ids'] = $players;

                $fields['headings'] = array("en" => 'ORDER: #' . $order_number);
                $fields['contents'] = array("en" => 'YOU HAVE NEW ORDER ' . strtoupper($order->status) );

                $fields['isAndroid'] = true;
                $fields['isIos'] = true;

                $fields['isAnyWeb'] = false;
                $fields['isWP'] = false;
                $fields['isAdm'] = false;
                $fields['isChrome'] = false;

                $onesignal_post_url = "https://onesignal.com/api/v1/notifications";
                $onesignal_auth_key = $options['onesignal_app_rest_api_key'];
                $fields['app_id'] = $options['onesignal_app_id'];
                $fields['data'] = array(
                    "order" => $order_id
                );
                 
                $args = array(
                  'body' => json_encode($fields),
                  'timeout' => '5',
                  'redirection' => '5',
                  'httpversion' => '1.0',
                  'blocking' => true,
                  'headers' => array(),
                  'cookies' => array(),
                  'headers' => array(
                    'Content-type' => 'application/json',
                    'Authorization' => 'Basic ' . $onesignal_auth_key
                  )
                );

                $response = wp_remote_post( $onesignal_post_url, $args );
            }
        }

        return $thank_you_title;
    }


    public function neworder( $order_id ) {

        if(isset($_REQUEST['onesignal_user_id']))
        update_post_meta( $order_id, 'onesignal_user_id', $_REQUEST['onesignal_user_id'] );

        if(isset($_REQUEST['fcm_token']))
        update_post_meta( $order_id, 'fcm_token', $_REQUEST['fcm_token'] );

        $options = get_option('mstoreapp_flutter_options');

        $fields = array();

        $order = wc_get_order($order_id);

        $player_ids = array();

        $meta_key = $options['use_fcm'] ? 'fcm_token' : 'onesignal_user_id';

        // Send User Notification
        if($options['send_push_on_new_order']) {
            $player_ids[] = get_post_meta( $order_id, $meta_key, true );
            $user_id = $order->get_user_id();
            $player_ids[] = get_user_meta( $user_id, $meta_key, true );
        }
        

        $players = array_values(array_filter(array_unique($player_ids)));

        if(!empty($players)){

            $order_number = $order->get_order_number();

            if ($options['use_fcm']) {

                $title = 'ORDER: #' . $order_number;
                $message = 'YOUR ORDER ' . strtoupper($order->status);
                
                foreach ($players as $key => $value) {
                    $this->send_fcm($value, $title, $message);
                }

            } else {
                $fields['include_player_ids'] = $players;

                $fields['headings'] = array("en" => 'ORDER: #' . $order_number);
                $fields['contents'] = array("en" => 'YOUR ORDER ' . strtoupper($order->status) );

                $fields['isAndroid'] = true;
                $fields['isIos'] = true;

                $fields['isAnyWeb'] = false;
                $fields['isWP'] = false;
                $fields['isAdm'] = false;
                $fields['isChrome'] = false;

                $onesignal_post_url = "https://onesignal.com/api/v1/notifications";
                $onesignal_auth_key = $options['onesignal_app_rest_api_key'];
                $fields['app_id'] = $options['onesignal_app_id'];
                $fields['data'] = array(
                    "order" => $order_id
                );
                 
                $args = array(
                  'body' => json_encode($fields),
                  'timeout' => '5',
                  'redirection' => '5',
                  'httpversion' => '1.0',
                  'blocking' => true,
                  'headers' => array(),
                  'cookies' => array(),
                  'headers' => array(
                    'Content-type' => 'application/json',
                    'Authorization' => 'Basic ' . $onesignal_auth_key
                  )
                );

                $response = wp_remote_post( $onesignal_post_url, $args );
            }
        }
    }

    public function remove_uncategorized_category( $args ) {
      $uncategorized = get_option( 'default_product_cat' );
      $args['exclude'] = $uncategorized;
      return $args;
    }

    public function uploadimage() {

          if ( ! function_exists( 'wp_handle_upload' ) ) {
              require_once( ABSPATH . 'wp-admin/includes/file.php' );
          }

          $uploadedfile = $_FILES['file'];

          $upload_overrides = array( 'test_form' => false );

          $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

          if ( $movefile && ! isset( $movefile['error'] ) ) {
             // echo "File is valid, and was successfully uploaded.\n";
              wp_send_json( $movefile );
          } else {
              /**
               * Error generated by _wp_handle_upload()
               * @see _wp_handle_upload() in wp-admin/includes/file.php
               */
              wp_send_json( $movefile );      }

             // wp_send_json( $data );

            die();
    }

    public function uploadimages() {


        $img = $_POST['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $decoded = base64_decode($img);

        $upload_dir = wp_upload_dir();

        // @new
        $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

        $decoded = $image;
        $filename = 'my-base64-image.png';

        $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

        // @new
        $image_upload = file_put_contents( $upload_path . $hashed_filename, $decoded );

        //HANDLE UPLOADED FILE
        if( !function_exists( 'wp_handle_sideload' ) ) {
          require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        // Without that I'm getting a debug error!?
        if( !function_exists( 'wp_get_current_user' ) ) {
          require_once( ABSPATH . 'wp-includes/pluggable.php' );
        }

        // @new
        $file             = array();
        $file['error']    = '';
        $file['tmp_name'] = $upload_path . $hashed_filename;
        $file['name']     = $hashed_filename;
        $file['type']     = 'image/png';
        $file['size']     = filesize( $upload_path . $hashed_filename );

        // upload file to server
        // @new use $file instead of $image_upload
        $file_return = wp_handle_sideload( $file, array( 'test_form' => false ) );

        $filename = $file_return['file'];

        $filepath = $wp_upload_dir['url'] . '/' . basename($filename);

        wp_send_json( $filepath );

    }

    public function mstoreapp_prepare_vendors_query($response, $object, $request){
        if(isset($_REQUEST['wc_vendor'])){
            $data = array();
            foreach ($response->data as $key => $value) {
                /*$data[] = array(
                    'id' => $value['id'],
                    'display_name' => $value['display_name'],
                    'registered' => $value['registered'],
                    'shop' => $value['shop'],
                    'address' => $value['address'],
                    'social' => $value['social'],
                    'message_to_buyers' => $value['message_to_buyers'],
                    'rating_count' => $value['rating_count'],
                    'avg_rating' => $value['avg_rating'],
                    'image'  => wp_get_attachment_image_src( $value['shop']['image'], 'thumbnail', false ),
                    'banner'  => wp_get_attachment_image_src( $value['shop']['banner'], 'medium', false ),
                );*/

                $response->data[$key]['shop']['image'] = wp_get_attachment_image_src( $response->data[$key]['shop']['image'], 'medium', false );
                $response->data[$key]['shop']['banner'] = wp_get_attachment_image_src( $response->data[$key]['shop']['banner'], 'large', false );
                $response->data[$key]['payment'] = null;
            }
            return $response;
        }
        return $response;
    }

    // For Dokan
    public function mstoreapp_prepare_order_query( $args, $request ){

        if ( ! function_exists( 'is_plugin_active' ) ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        
        if(isset($_REQUEST['vendor']) && isset($_REQUEST['flutter_app'])) {

            if(isset($_REQUEST['new'])) {
                $args['status'] = array('processing', 'pending', 'on-hold');
            } else {
                //  
            }

            $id = $_REQUEST['vendor'];

            if(is_plugin_active( 'dokan-lite/dokan.php') || is_plugin_active( 'dokan/dokan.php' )){
                $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
                $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
                $offset = ($page - 1) * $per_page;
                $orders = dokan_get_seller_orders( $id, 'all', null, $per_page, $offset );

                $order_ids = array();
                foreach ($orders as $order) {
                    $order_ids[] = $order->order_id;
                }

                $order_ids = ! empty( $order_ids ) ? $order_ids : array( 0 );

                $args['post__in'] = array_merge($args['post__in'], $order_ids);

                return $args;
            }
            else if(is_plugin_active( 'dc-woocommerce-multi-vendor/dc_product_vendor.php' )){            
                global $wpdb, $WCMp;
                
                $vendor_list_prepared = '';
                $prepare_values = array();
                if(!empty($_REQUEST['vendor'])) {
                    $vendor_list_prepared = "%d";
                    $prepare_values[] = $_REQUEST['vendor'];
                } else if(!empty($_REQUEST['include_vendor']) && is_array($_REQUEST['include_vendor'])) {
                    $vendor_list_prepared = implode( ', ', array_fill( 0, count( $_REQUEST['include_vendor'] ), '%d' ) );
                    $prepare_values = $_REQUEST['include_vendor'];
                } else if(!empty($_REQUEST['exclude_vendor']) && is_array($_REQUEST['exclude_vendor'])) {
                    $vendor_list_prepared = implode( ', ', array_fill( 0, count( $_REQUEST['exclude_vendor'] ), '%d' ) );
                    $prepare_values = $_REQUEST['exclude_vendor'];
                }

                $argss = array(
                    'author' => $id,
                );

                $vendor_all_orders = apply_filters('wcmp_datatable_get_vendor_all_orders', wcmp_get_orders($argss), $requestData, $_POST);
             
                if($vendor_list_prepared != "") {
                    $order_ids = $wpdb->get_col( $wpdb->prepare( "
                        SELECT order_id
                        FROM {$wpdb->prefix}woocommerce_order_items
                        WHERE order_item_id IN ( SELECT order_item_id FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE meta_key = '_vendor_id' AND meta_value IN ( " . $vendor_list_prepared . " ) )
                        AND order_item_type = 'line_item'
                     ", $prepare_values ) );

                    if(isset($_REQUEST['exclude_vendor'])) $args['post__not_in'] = array_merge($args['post__not_in'], $vendor_all_orders);
                    else $args['post__in'] = $vendor_all_orders;
                }               
                
                return $args;

            } else if(is_plugin_active( 'wc-multivendor-marketplace/wc-multivendor-marketplace.php' )){            
                global $wpdb;
                
                $order_ids = $wpdb->get_col( $wpdb->prepare( "
                    SELECT order_id
                    FROM {$wpdb->prefix}woocommerce_order_items
                    WHERE order_id IN ( SELECT order_id FROM {$wpdb->prefix}wcfm_marketplace_orders WHERE vendor_id = %d )
                    AND order_item_type = 'shipping'
                 ", $id ) );

                $order_ids = ! empty( $order_ids ) ? $order_ids : array( 0 );

                $args['post__in'] = array_merge($args['post__in'], $order_ids);

                return $args;
            }
        }
        
        return $args;
    }


    /* Filter For all the app */
    public function mstoreapp_prepare_product_query( $args, $request ) {

        $tax_query = array();

        for ($i=0; $i < 50; $i++) { 
            
            if ( ! empty( $request['attributes' . $i] ) && ! empty( $request['attribute_term' . $i] ) ) {
                if ( in_array( $request['attributes' . $i], wc_get_attribute_taxonomy_names(), true ) ) {
                    $tax_query[] = array(
                        'taxonomy' => $request['attributes' . $i],
                        'field'    => 'term_id',
                        'terms'    => $request['attribute_term' . $i],
                    );
                }
            }

        }    

        if ( ! empty( $tax_query ) ) {
            if ( ! empty( $args['tax_query'] ) ) {
                $args['tax_query'] = array_merge( $tax_query, $args['tax_query'] ); // WPCS: slow query ok.
            } else {
                $args['tax_query'] = $tax_query; // WPCS: slow query ok.
            }
        }
        
        /* For Dokan and WCFM Plugin Only */
        if ( ! empty( $request['vendor'] ) ) {
            $args['author'] = $request['vendor'];
        }

        return $args;
    }

    /* For Dokan and WCFM Plugin Only */
    public function update_vendor_product(){
        if(isset($_REQUEST['id'])){

            $user_id = get_current_user_id();
            $product_id = $_REQUEST['id'];

            $post = array(
              'ID' => $product_id,
              'post_author' => $user_id,
            );
            wp_update_post( $post );

        }
        
        wp_send_json(true);
    }

    /* For Dokan Only && WCFM*/
    function mstoreapp_prepare_product( $response, $object, $request ) {

        if( empty( $response->data ) )
            return $response;


        /*if (is_plugin_active('wc-multivendor-marketplace/wc-multivendor-marketplace.php')) {
            $id = $object->get_id();
            if ( 'product' === get_post_type( $id ) || 'product_variation' === get_post_type( $id ) ) { 
                $parent = get_post_ancestors( $id );
            if ( $parent ) $id = $parent[ 0 ];

                $seller = get_post_field( 'post_author', $id);
                $author = get_user_by( 'id', $seller );
                $store_user  = wcfmmp_get_store( $author->ID );
                $store_info  = $store_user->get_shop_info();

                $response->data['vendor'] = $store_user->id;
                $response->data['store_name'] = $store_info['store_name'];

            }
        }*/

        if (function_exists('wcfmmp_get_store')) {
            $id = $object->get_id();
            if ( 'product' === get_post_type( $id ) || 'product_variation' === get_post_type( $id ) ) { 
                $parent = get_post_ancestors( $id );
            if ( $parent ) $id = $parent[ 0 ];

            global $WCFM, $WCFMmp;

            $vendor_id = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $id );

            if( apply_filters( 'wcfmmp_is_allow_sold_by_linked', true ) ) {
                $store_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor( absint($vendor_id) );
            } else {
                $store_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_name_by_vendor( absint($vendor_id) );
            }
            
                $store_user  = wcfmmp_get_store( $vendor_id );
            
                $response->data['gravatar'] = $store_user->get_avatar();
                $response->data['email'] = $store_user->get_email();
                $response->data['phone'] = $store_user->get_phone();
                $response->data['address'] = $store_user->get_address_string();

                $response->data['store_info'] = $store_user->get_shop_info();
                $response->data['vendor'] = $store_user->id;
                $response->data['store_name'] = $store_info['store_name'];

            }
        }

        else if(function_exists('dokan_get_store_info')){
            $id = $object->get_id();
            if ( 'product' === get_post_type( $id ) || 'product_variation' === get_post_type( $id ) ) { 
                $parent = get_post_ancestors( $id );
            if ( $parent ) $id = $parent[ 0 ];

                $seller = get_post_field( 'post_author', $id);
                $author = get_user_by( 'id', $seller );
                $store_info = dokan_get_store_info( $author->ID );

                $store_info['banner_url'] = wp_get_attachment_url( $store_info['banner'] );
                $store_info['icon_url'] = wp_get_attachment_url( $store_info['gravatar'] );
     
                //$response->data['store_info'] = $store_info;
                $response->data['vendor'] = $author->ID;
                $response->data['store_name'] = $store_info['store_name'];
                return $response;
            }
        }
     
        return $response;

    }

    public function loadCurrency($load){
        
        if(isset($_REQUEST['flutter_app'])) {
            return true;
        }
        return $load;
    }

    public function add_vendor_type_fields($user) {
        if(in_array( 'vendor', (array) $user->roles ) || in_array( 'seller', (array) $user->roles ) || in_array( 'wcfm_vendor', (array) $user->roles )) {
            ?>
                <h3><?php _e("Vendor Type", "blank"); ?></h3>

                <table class="form-table">
                <th><label for="mstoreapp_vendor_type"><?php _e("Vendor Type"); ?></label></th>
                    <td>
                        <input type="text" name="mstoreapp_vendor_type" id="mstoreapp_vendor_type" value="<?php echo esc_attr( get_the_author_meta( 'mstoreapp_vendor_type', $user->ID ) ); ?>" class="regular-text" /><br />
                        <span class="description"><?php _e("Please enter vendor type. example grocery, food, bakery, meat, fish etc"); ?></span>
                    </td>
                </tr>
                </table>
            <?php
        }
    }
    public function save_vendor_type_fields($user_id) {
        if ( !current_user_can( 'edit_user', $user_id ) ) { 
            return false; 
        }
        update_user_meta( $user_id, 'mstoreapp_vendor_type', $_POST['mstoreapp_vendor_type'] );
    }

    public function test(){

        $token = get_user_meta(1, 'fcm_token', true);

        if(isset($token)) {

            $user = wp_get_current_user();

            $title = 'You have new message from ' . $user->first_name . ' ' . $user->last_name;;
            $message = 'dsadf';

            $this->send_fcm($token, $title, $message);
        }

        wp_send_json($token);

    }

    public function flutter_new_chat_message() {
        if(isset($_REQUEST['message'])) {
            
            $message = $_REQUEST['message'];

            $vendor_id = isset($_REQUEST['vendor_id']) ? $_REQUEST['vendor_id'] : 1;

            $token = get_user_meta($vendor_id, 'fcm_token', true);

            if(isset($token)) {

                $user = wp_get_current_user();

                $title = 'You have mew message from' . $user->first_name . ' ' . $user->first_name;;
                $message = $message;

                $this->send_fcm($token, $title, $message);
            }

        }        
    }

    public function send_fcm($token, $title, $message){

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

}
