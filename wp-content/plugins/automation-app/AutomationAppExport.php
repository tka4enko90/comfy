<?php

/**
 * Class AutomationAppExport
 */
class AutomationAppExport
{

    const ORDER_API_PATH = "/api/v1/woocommerce/order";

    const CUSTOMER_API_PATH = "/api/v1/woocommerce/customer";

    public function createWebHook()
    {
        // Creating a new order created webhook.
        $webhook = new WC_Webhook();
        $webhook->set_user_id(get_current_user_id());
        $webhook->set_name('Automation App order created export');
        $webhook->set_topic('order.created');
        $webhook->set_secret(get_option('automation_app_secret_key', ''));
        $url = get_option('automation_app_api_domain', '');
        $webhook->set_delivery_url($url.self::ORDER_API_PATH);
        $webhook->set_status('active');
        $webhook->save();
        add_option('automation_app_order_created_wh', $webhook->get_id());
        // Creating a new order updated webhook.
        $webhook = new WC_Webhook();
        $webhook->set_user_id(get_current_user_id());
        $webhook->set_name('Automation App order updated export');
        $webhook->set_topic('order.updated');
        $webhook->set_secret(get_option('automation_app_secret_key', ''));
        $url = get_option('automation_app_api_domain', '');
        $webhook->set_delivery_url($url.self::ORDER_API_PATH);
        $webhook->set_status('active');
        $webhook->save();
        add_option('automation_app_order_updated_wh', $webhook->get_id());

        // Creating a new customer created webhook.
        $webhook = new WC_Webhook();
        $webhook->set_user_id(get_current_user_id());
        $webhook->set_name('Automation App customer created export');
        $webhook->set_topic('customer.created');
        $webhook->set_secret(get_option('automation_app_secret_key', ''));
        $url = get_option('automation_app_api_domain', '');
        $webhook->set_delivery_url($url.self::CUSTOMER_API_PATH);
        $webhook->set_status('active');
        $webhook->save();
        add_option('automation_app_customer_created_wh', $webhook->get_id());
        // Creating a new customer updated webhook.
        $webhook = new WC_Webhook();
        $webhook->set_user_id(get_current_user_id());
        $webhook->set_name('Automation App customer updated export');
        $webhook->set_topic('customer.updated');
        $webhook->set_secret(get_option('automation_app_secret_key', ''));
        $url = get_option('automation_app_api_domain', '');
        $webhook->set_delivery_url($url.self::CUSTOMER_API_PATH);
        $webhook->set_status('active');
        $webhook->save();
        add_option('automation_app_customer_updated_wh', $webhook->get_id());
    }

    /**
     * Delete webhook.
     */
    public function deleteWebHook()
    {
        try {
            $id = get_option('automation_app_order_created_wh', '');
            if (!$id) {
                error_log("No webhook id found");
                return;
            }
            $webhook = wc_get_webhook($id);
            if ($webhook) {
                $webhook->delete(true);
            }
        } catch (Exception $exception) {
            error_log($exception->getMessage());
        }
        delete_option('automation_app_order_created_wh');
        try {
            $id = get_option('automation_app_order_updated_wh', '');
            if (!$id) {
                error_log("No webhook id found");
                return;
            }
            $webhook = wc_get_webhook($id);
            if ($webhook) {
                $webhook->delete(true);
            }
        } catch (Exception $exception) {
            error_log($exception->getMessage());
        }
        delete_option('automation_app_order_updated_wh');

        try {
            $id = get_option('automation_app_customer_created_wh', '');
            if (!$id) {
                error_log("No webhook id found");
                return;
            }
            $webhook = wc_get_webhook($id);
            if ($webhook) {
                $webhook->delete(true);
            }
        } catch (Exception $exception) {
            error_log($exception->getMessage());
        }
        delete_option('automation_app_customer_created_wh');
        try {
            $id = get_option('automation_app_customer_updated_wh', '');
            if (!$id) {
                error_log("No webhook id found");
                return;
            }
            $webhook = wc_get_webhook($id);
            if ($webhook) {
                $webhook->delete(true);
            }
        } catch (Exception $exception) {
            error_log($exception->getMessage());
        }
        delete_option('automation_app_customer_updated_wh');
    }
}