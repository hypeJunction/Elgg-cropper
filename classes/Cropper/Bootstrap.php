<?php

namespace Cropper;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	public function init() {
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
}
