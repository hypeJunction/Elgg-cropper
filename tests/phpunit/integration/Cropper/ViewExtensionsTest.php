<?php

namespace Cropper;

use Elgg\IntegrationTestCase;

/**
 * Tests that plugin view extensions and assets are registered.
 */
class ViewExtensionsTest extends IntegrationTestCase {

	public function up() {
	}

	public function down() {
	}

	public function getPluginID(): string {
		return 'cropper';
	}

	public function testInputCropperViewExists(): void {
		$this->assertTrue(elgg_view_exists('input/cropper'));
	}

	public function testFileInputExtensionViewExists(): void {
		$this->assertTrue(elgg_view_exists('elements/input/file/cropper'));
	}

	public function testCropperCssViewExists(): void {
		$this->assertTrue(elgg_view_exists('input/cropper.css'));
	}

	public function testCropperJsViewExists(): void {
		$this->assertTrue(elgg_view_exists('js/cropper.js') || elgg_view_exists('input/cropper'));
	}

	public function testFileInputExtensionIsBlankWithoutUseCropper(): void {
		$out = elgg_view('elements/input/file/cropper', ['id' => 'some-input']);
		$this->assertSame('', trim($out));
	}

	public function testFileInputExtensionSkipsWithoutId(): void {
		$out = elgg_view('elements/input/file/cropper', ['use_cropper' => true]);
		$this->assertSame('', trim($out));
	}

	public function testFileInputExtensionRendersCropperWhenEnabled(): void {
		$out = elgg_view('elements/input/file/cropper', [
			'id' => 'avatar-file',
			'use_cropper' => ['ratio' => 1],
		]);
		$this->assertIsString($out);
		$this->assertNotEmpty($out);
		$this->assertStringContainsString('cropper-input', $out);
		$this->assertStringContainsString('avatar-file', $out);
	}

	public function testInputCropperRendersHiddenCoordInputs(): void {
		$out = elgg_view('input/cropper', [
			'id' => 'crop-widget',
			'name' => 'avatar_coords',
			'src' => 'http://example.test/image.jpg',
			'ratio' => 1,
		]);
		$this->assertIsString($out);
		$this->assertStringContainsString('avatar_coords[x1]', $out);
		$this->assertStringContainsString('avatar_coords[y1]', $out);
		$this->assertStringContainsString('avatar_coords[x2]', $out);
		$this->assertStringContainsString('avatar_coords[y2]', $out);
		$this->assertStringContainsString('cropper-input', $out);
	}

	public function testInputCropperRendersImageWhenSrcProvided(): void {
		$out = elgg_view('input/cropper', [
			'id' => 'crop-widget-2',
			'src' => 'http://example.test/photo.png',
		]);
		$this->assertStringContainsString('cropper-input-image', $out);
		$this->assertStringContainsString('photo.png', $out);
	}

	public function testInputCropperOmitsImageWhenNoSrc(): void {
		$out = elgg_view('input/cropper', [
			'id' => 'crop-widget-3',
		]);
		$this->assertStringContainsString('cropper-input-image-container', $out);
		$this->assertStringNotContainsString('cropper-input-image"', $out);
	}

	public function testInputCropperSetsFileInputDataAttribute(): void {
		$out = elgg_view('input/cropper', [
			'id' => 'crop-widget-4',
			'input' => 'file-input-42',
		]);
		$this->assertStringContainsString('data-file-input="#file-input-42"', $out);
	}

	public function testInputCropperDefaultsRatioTo1(): void {
		$out = elgg_view('input/cropper', [
			'id' => 'crop-widget-5',
		]);
		$this->assertStringContainsString('data-ratio="1"', $out);
	}

	public function testInputCropperRespectsCustomRatio(): void {
		$out = elgg_view('input/cropper', [
			'id' => 'crop-widget-6',
			'ratio' => 1.75,
		]);
		$this->assertStringContainsString('data-ratio="1.75"', $out);
	}

	public function testInputFileWithUseCropperGetsCropperClass(): void {
		$out = elgg_view('input/file', [
			'name' => 'upload',
			'id' => 'upload-id',
			'use_cropper' => true,
		]);
		$this->assertStringContainsString('file-input-has-cropper', $out);
	}

	public function testInputFileWithoutUseCropperHasNoCropperClass(): void {
		$out = elgg_view('input/file', [
			'name' => 'upload',
			'id' => 'upload-id-2',
		]);
		$this->assertStringNotContainsString('file-input-has-cropper', $out);
	}
}
