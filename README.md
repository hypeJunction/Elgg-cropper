Cropper for Elgg
================
![Elgg 5.x](https://img.shields.io/badge/Elgg-5.x-orange.svg?style=flat-square)

Responsive image cropping input for Elgg

![file input](https://raw.github.com/hypeJunction/Elgg-cropper/master/screenshots/file_input.png "File Input with a Cropper")

## Usage

### Add cropper as a form input

```php
echo elgg_view('input/cropper', array(
	'src' => 'http://example.com/uri/image.jpg',
	'ratio' => 16/9,
	'name' => 'crop_coords',
));
```

### Add cropper to a file input (basic usage)

```php
// in your form
echo elgg_view('input/file', array(
    'name' => 'avatar',
    'use_cropper' => true,
));

// in your action
$coords = get_input('crop_coords');
```

### Add cropper to a file input (advanced usage)

```php
// in your form
echo elgg_view('input/file', array(
	'name' => 'cover',
	'use_cropper' => array(
		'name' => 'cover_crop_coords',
		'ratio' => 16/9,
		'src' => '/uri/image.jpg', // previously uploaded file
		'x1' => 100,
		'y1' => 100,
		'x2' => 260,
		'y2' => 190,
	),
));

// in your action
$coords = get_input('cover_crop_coords');
```


### Notes

1. In your action, be sure to use the same image source for cropping. If you passed master image source to the file input,
you will need to implement the logic for both new file upload and master image, as cropping coordinates may change even without new
file upload.