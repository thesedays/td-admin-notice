<?php

class AdminNotice
{
    /**
     * This method will be used to register
     * our custom settings admin page
     */
    public function init()
    {
        // Register page
        add_action('network_admin_menu', [$this, 'createSettingsPage']);

        // Update settings
        add_action('network_admin_menu', [$this, 'save']);

        // Show notice
        add_action( 'admin_notices', [$this, 'showNotice']);

        // Add custom CSS
        add_action( 'admin_enqueue_scripts', [$this, 'adminCss']);
    }

    /**
     * Set custom settings page.
     *
     * @return $this
     */
    public function createSettingsPage()
    {
        add_menu_page('Admin Notice', 'Admin Notice', 'create_sites', 'admin_notice', [$this, 'renderSettingsPage'], 'dashicons-warning');

        return $this;
    }

    /**
     * Parses the content of the settings page.
     */
    public function renderSettingsPage()
    {
        require_once 'views/settings-page.php';
    }

    /**
     * Check for post submission
     * and save settings when required
     */
    public function save()
    {
        if(isset($_POST['submit'])) {

            // verify authentication (nonce)
            if(! isset($_POST['td_admin_notice_nonce'])) return;

            // verify authentication (nonce)
            if(! wp_verify_nonce($_POST['td_admin_notice_nonce'], 'td_admin_notice_nonce')) return;

            return $this->updateSettings();
        }
    }

    /**
     * Update the admin notice settings.
     */
    public function updateSettings()
    {
        $settings = [];

        if(isset($_POST['tdan_admin_notice_msg'])) {
            $settings['tdan_admin_notice_msg'] = $_POST['tdan_admin_notice_msg'];
        }

        if(isset($_POST['tdan_admin_notice_priority'])) {
            $settings['tdan_admin_notice_priority'] = $_POST['tdan_admin_notice_priority'];
        }

        if(isset($_POST['tdan_admin_notice_enable'])) {
            $settings['tdan_admin_notice_enable'] = $_POST['tdan_admin_notice_enable'];
        }

        if($settings) {
            // update new settings
            update_site_option('td_admin_notice_settings', $settings);
        } else {
            // empty settings, revert back to default
            delete_site_option('td_admin_notice_settings');
        }

        $this->updated = true;
    }

    /**
     * Get settings
     *
     * @param $setting string optional setting name
     * @return array|null
     */

    public function getSettings($setting = '')
    {
        global $my_plugin_settings;

        if(isset($my_plugin_settings)) {
            if($setting) {
                return isset($my_plugin_settings[$setting]) ? $my_plugin_settings[$setting] : null;
            }

            return $my_plugin_settings;
        }

        $my_plugin_settings = wp_parse_args(get_site_option('td_admin_notice_settings'), array(
            'tdan_admin_notice_msg' => null,
            'tdan_admin_notice_priority' => null,
            'tdan_admin_notice_enable' => null,
        ));

        if($setting) {
            return isset($my_plugin_settings[$setting]) ? $my_plugin_settings[$setting] : null;
        }

        return $my_plugin_settings;
    }

    /**
     * Show the notification to all users.
     */
    public function showNotice()
    {
        $message = $this->getSettings('tdan_admin_notice_msg');
        $enabled = $this->getSettings('tdan_admin_notice_enable');
        $priority = $this->getSettings('tdan_admin_notice_priority');

        if($message !== '' && $enabled === 'true') {
            include __DIR__ . '/views/notice.php';
        }
    }

    /**
     * Add custom css
     */
    public function adminCss()
    {
        wp_enqueue_style( 'td-admin-notice-styles', plugin_dir_url( __FILE__ ) . '/css/admin-notice.css');
    }
}