<?php

/**
 * Cropper
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

elgg_register_event_handler('init', 'system', 'cropper_init');

/**
 * Initialize the plugin
 * @return void
 */
function cropper_init() {

	elgg_register_plugin_hook_handler('view_vars', 'input/file', 'cropper_file_input_view_vars_hook');
	elgg_extend_view('input/file', 'elements/input/file/cropper');
	elgg_extend_view('css/elgg', 'input/cropper.css');

	// override previously defined assets
	elgg_unregister_css('jquery.cropper');

	elgg_register_simplecache_view('js/cropper.js');
	$src = elgg_get_simplecache_url('js/cropper.js');
	elgg_register_js('jquery.cropper', $src);
	elgg_define_js('cropper', [
		'src' => $src,
		'deps' => ['jquery'],
	]);
}

/**
 * Get path to vendor directory
 * @return string
 */
function cropper_get_vendor_path() {
	$plugin_root = __DIR__;
	$root = dirname(dirname($plugin_root));

	if (file_exists("$plugin_root/vendor/autoload.php")) {
		$path = $plugin_root;
	} else if (file_exists("$root/vendor/autoload.php")) {
		$path = $root;
	}

	return $path;
}

/**
 * Add cropper class selector to file input
 *
 * @param string $hook   "view_vars"
 * @param string $type   "input/file"
 * @param array  $return View vars
 * @param array  $params Hook params
 * @return array
 */
function cropper_file_input_view_vars_hook($hook, $type, $return, $params) {

	static $iterator;

	$cropper_params = elgg_extract('use_cropper', $return);
	if ($cropper_params) {
		$class = (array) elgg_extract('class', $return, []);
		$class[] = 'file-input-has-cropper';
		$return['class'] = implode(' ', $class);

		$id = elgg_extract('id', $return);
		if (!$id) {
			$iterator++;
			$return['id'] = "elgg-file-input-$iterator";
		}
	}

	return $return;
}
