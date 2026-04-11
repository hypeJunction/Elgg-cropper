<?php

return [
	'bootstrap' => \Cropper\Bootstrap::class,

	'hooks' => [
		'view_vars' => [
			'input/file' => [
				\Cropper\Views::class . '::fileInputViewVars' => [],
			],
		],
	],

	'view_extensions' => [
		'input/file' => [
			'elements/input/file/cropper' => [],
		],
		'css/elgg' => [
			'input/cropper.css' => [],
		],
	],
];
