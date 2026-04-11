<?php

namespace Cropper;

class Views {

	/**
	 * Add cropper class selector to file input
	 *
	 * @param \Elgg\Hook $hook "view_vars", "input/file"
	 * @return array|void
	 */
	public static function fileInputViewVars(\Elgg\Hook $hook) {
		static $iterator;

		$return = $hook->getValue();

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

			return $return;
		}
	}
}
