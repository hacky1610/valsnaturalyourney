<?php

/*
Plugin Name: Vals Admin Tools
*/

include_once dirname( __FILE__ ) . '/private/AdminTools.php';

define("VNJ_ADMIN_PATH", plugin_dir_url( __FILE__ ));
define("VNJ_ADMIN_VERSION", '0.9.94');


new AdminTools();
?>