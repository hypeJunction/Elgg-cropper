<?php

return [
	'plugin' => [
		'id' => 'cropper',
		'name' => 'Cropper',
		'description' => 'Cropper form input for Elgg',
		'version' => '4.0.0',
		'author' => 'Ismayil Khayredinov',
		'categories' => ['ui'],
	],

	'views' => [
		'default' => [
			'js/cropper.js' => __DIR__ . '/vendor/bower-asset/cropper/dist/cropper.min.js',
		],
	],

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
