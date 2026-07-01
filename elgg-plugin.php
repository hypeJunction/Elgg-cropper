<?php

return [
	'plugin' => [
		'id' => 'cropper',
		'name' => 'Cropper',
		'description' => 'Cropper form input for Elgg',
		'version' => '7.0.0',
		'author' => 'Ismayil Khayredinov',
		'categories' => ['ui'],
	],

	'views' => [
		'default' => [
			// Vendored Cropper UMD build, exposed as the ESM importmap entry `cropper`
			// so `import 'cropper'` resolves from js/input/cropper.mjs (Elgg 7 importmap).
			'cropper.mjs' => __DIR__ . '/vendors/cropper/cropper.min.js',
		],
	],

	'events' => [
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
