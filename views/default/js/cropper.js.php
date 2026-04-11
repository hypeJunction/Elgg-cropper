<?php
$plugin_path = elgg_get_plugins_path() . 'cropper/';
$vendor_path = is_dir("{$plugin_path}vendor") ? $plugin_path : dirname(elgg_get_plugins_path());
readfile($vendor_path . '/vendor/bower-asset/cropper/dist/cropper.min.js');
