<?php
/**
 * Scrubbill
 *
 * @package   Scrubbill\Plugin\Scrubbill
 * @author    ScrubBill <trouble@scrubbill.com>
 * @copyright 2020 ScrubBill
 * @license   GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @wordpress-plugin
 * Plugin Name: ScrubBill
 * Plugin URI:  https://scrubbill.com
 * Description: Multi-courier shipping software that makes fulfilment a breeze.
 * Version:     1.0.1
 * Author:      ScrubBill
 * Text Domain: scrubBill
 *
 * Copyright:   © 2021 ScrubBill
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Fire up the engines! Main plugin file which is simply used for getting
 * things started.
 *
 * @since 1.0
 */

namespace Scrubbill\Plugin\Scrubbill;

// Autoload classes.
require_once 'includes/helpers/autoloader.php';

// Load config.
require_once 'includes/config/config.php';

$bootstrap = Bootstrap::get_instance();
$bootstrap->load();

/**
 * Remove API key when deactivating.
 */
function scrubbill_deactivate() {
	delete_option( Settings::API_TOKEN_KEY );
}
register_deactivation_hook( __FILE__, 'Scrubbill\Plugin\Scrubbill\scrubbill_deactivate' );
