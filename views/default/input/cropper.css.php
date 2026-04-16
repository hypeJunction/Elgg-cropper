<?php
// Vendor cropper.js CSS — install bower-asset/cropper via composer install
$vendor_css = realpath(__DIR__ . '/../../../vendor/bower-asset/cropper/dist/cropper.min.css');
if ($vendor_css && file_exists($vendor_css)) {
	readfile($vendor_css);
}
?>
.cropper-input-image-container {
	position: relative;
	max-width: 100%;
}
.cropper-input-image {
	max-width: 100%;
	height: auto;
}
