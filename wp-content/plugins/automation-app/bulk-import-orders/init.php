<?php
if (!class_exists('wooAtExport')) {
    class wooAtExport
    {

        function __construct()
        {

            define('WAE_VESION', '1.0');
            define('WAE_PATH', plugin_dir_path(__FILE__));
            define('WAE_URL', plugin_dir_url(__FILE__));
            define('WAE_QUEUE_TABLE', 'automation_export_queue');

            define('WAE_CRON_FRQ', '15minute');
            define('WAE_QUEUE_LIMIT', 50);

            $this->include_functions();
        }

        public function include_functions()
        {
            require_once(WAE_PATH.'include/automation-app-admin-options.php');
            require_once(WAE_PATH.'include/crons.php');
        }
    }

    new wooAtExport();
}