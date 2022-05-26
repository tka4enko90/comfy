<?php
/**
 * Automation.app WooCommerce Extension
 *
 * Plugin Name: Automation.app WooCommerce Extension
 * Plugin URI:  https://automation.app/blog/automationapp-plugin-for-referrer-tracking
 * Description: This extension 2-way sync's WooCommerce order data between WooCommerce and the Automation.app CRM & Automation platform. Go to https://automation.app/ to set up your account if you're don't already have done so. Follow this guide for more information (https://automation.app/blog/woocommerce-crm-plugin-for-automationapp)
 * Version: 1.0
 * Author: automationApp
 * Author URI: http://automation.app
 * Developer: Jesper Bisgaard
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Requires at least: 4.9
 * Requires PHP: 5.2.4
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    require_once(__DIR__.'/AutomationAppExport.php');
    require_once(__DIR__.'/AutomationAppWC.php');
    require_once(__DIR__.'/bulk-import-orders/init.php');

    if (class_exists('AutomationAppExport') && class_exists('AutomationAppWC')) {
        $exportClass = new AutomationAppExport();
        $GLOBALS['AutomationAppExport'] = $exportClass;
        $wcClass = new AutomationAppExport();
        $GLOBALS['AutomationAppWC'] = $wcClass;

        function automationApp_activatePlugin()
        {
            $wcClass = new AutomationAppWC();
            $wcClass->activate();

            /*Create Tables*/
            global $wpdb;
            $createLogTable = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix.WAE_QUEUE_TABLE."` (
					  `id` int(10) AUTO_INCREMENT,
					  `orderId` int(10) NOT NULL,
					  `exportedBy` int(10) NOT NULL,
					  `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`) , UNIQUE KEY `orderId` (`orderId`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;";
            $wpdb->query($createLogTable);

            /*Register Crons*/
            wooAtExportCrons::set_crons();
        }

        register_activation_hook(__file__, 'automationApp_activatePlugin');

        function automationApp_deactivatePlugin()
        {
            $wcClass = new AutomationAppWC();
            $wcClass->deactivate();

            $exportClass = new AutomationAppExport();
            $exportClass->deleteWebHook();

            wooAtExportCrons::unset_crons();
            delete_option('WAE_settings');
        }

        register_deactivation_hook(__file__, 'automationApp_deactivatePlugin');

        add_action('admin_notices', 'automationApp_check_api_settings');
        function automationApp_check_api_settings()
        {
            $apiKey = get_option('automation_app_api_key', '');
            $secretKey = get_option('automation_app_secret_key', '');

            if (empty($apiKey) || empty($secretKey)) {
                ?>
                <div class="notice notice-error" style="margin-left:0px">
                    <p>You don't seem to have a linkup with an automation.app account yet. <a href="
https://automation.app/app/organization/integrations" target="_blank">Click here</a> to enter your automation.app
                        solution and copy the API keys.</p>
                </div>
                <?php
            }
        }

        function automationApp_afterWebhookDelivery($http_args, $response, $duration, $arg, $webhook_id)
        {
            $orderData = json_decode($http_args['body']);
            if (!empty($orderData->id)) {
                $orderCreatedWebHook = get_option('automation_app_order_created_wh', '');
                $orderUpdatedWebHook = get_option('automation_app_order_updated_wh', '');

                if ($orderCreatedWebHook == $webhook_id || $orderUpdatedWebHook == $webhook_id) {
                    $order = wc_get_order($orderData->id);
                    $order->add_order_note('Order sent to automationApp', 0, false);

                    update_post_meta($orderData->id, 'WAE_order_exported', '1');
                }

            }
        }

        add_action('woocommerce_webhook_delivery', 'automationApp_afterWebhookDelivery', 1, 5);

        function automationApp_filter_http_args($http_args, $arg, $id)
        {
            $http_args['headers']['x-api-key'] = get_option('automation_app_api_key', '');

            return $http_args;
        }

        add_filter('woocommerce_webhook_http_args', 'automationApp_filter_http_args', 10, 3);

        # Add options page.
        function automationApp_registerOptionsPage()
        {
            add_menu_page(__('Automation App settings', 'woocommerce'),
                __('Automation.app', 'woocommerce'),
                'manage_options',
                'automation-app',
                'automationApp_option_page',
                'dashicons-dashboard'
            );

            add_submenu_page('automation-app',
                __('Import Orders', 'woocommerce'),
                __('Import Orders', 'woocommerce'),
                'manage_options',
                'automation-export',
                apply_filters('automation_import_page_callback', 'automationApp_import_page'));

            add_submenu_page('automation-app',
                __('Tracking', 'woocommerce'),
                __('Tracking', 'woocommerce'),
                'manage_options',
                'automation-tracking',
                apply_filters('automation_tracking_page_callback', 'automationApp_tracking_page'));
        }

        add_action('admin_menu', 'automationApp_registerOptionsPage', 49);

        function automationApp_option_page()
        {
            $wcClass = new AutomationAppWC();
            $wcClass->showSettingsForm();
            $wcClass->showAddonPlugins();
        }

        function automationApp_import_page()
        {
            $wcClass = new AutomationAppWC();
            $wcClass->showImportPage();
        }

        function automationApp_tracking_page()
        {
            $wcClass = new AutomationAppWC();
            $wcClass->showTrackingPage();
        }

        add_filter('whitelist_options', function ($whitelist_options) {
            $whitelist_options = [
                'automation_app_options_group' => [
                    'automation_app_api_key',
                    'automation_app_secret_key',
                    'automation_app_api_domain',
                ]
            ];

            return $whitelist_options;
        });

        function overrule_webhook_disable_limit($number)
        {
            return 50;
        }

        add_filter('woocommerce_max_webhook_delivery_failures', 'overrule_webhook_disable_limit');

        /*Add Styles*/
        function automation_app_styles()
        {
            $check = (!empty($_GET['page'])) ? $_GET['page'] : '';
            if (strpos($check, 'automation-') !== false) {
                wp_enqueue_style('automation.style', plugin_dir_url(__FILE__).'templates/style.css');
            }

        }

        add_action('admin_enqueue_scripts', 'automation_app_styles', 10);

        /*After Update Secret Key*/
        function after_update_automation_app_secret_key($old_value, $value)
        {
            $exportClass = new AutomationAppExport();
            $exportClass->deleteWebHook();
            $exportClass->createWebHook();

            $wcClass = new AutomationAppWC();
            $wcClass->registerInstall();
        }

        add_action('update_option_automation_app_secret_key', 'after_update_automation_app_secret_key', 10, 2);
    }
}