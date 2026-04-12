<?php

namespace Cropper;

use Elgg\IntegrationTestCase;

/**
 * Tests for \Cropper\Views hook handler on input/file view_vars.
 */
class ViewsTest extends IntegrationTestCase {

	public function up() {
	}

	public function down() {
	}

	public function getPluginID(): string {
		return 'cropper';
	}

	/**
	 * Build an \Elgg\Hook object for view_vars, input/file with the given return value.
	 */
	protected function makeHook(array $return): \Elgg\Hook {
		return new \Elgg\Hook(
			_elgg_services()->hooks->getEvents(),
			'view_vars',
			'input/file',
			[],
			$return
		);
	}

	public function testReturnsVoidWhenUseCropperNotSet(): void {
		$hook = $this->makeHook(['class' => 'foo']);
		$result = Views::fileInputViewVars($hook);
		$this->assertNull($result);
	}

	public function testReturnsVoidWhenUseCropperEmpty(): void {
		$hook = $this->makeHook(['use_cropper' => false]);
		$result = Views::fileInputViewVars($hook);
		$this->assertNull($result);
	}

	public function testAddsCropperClassWhenUseCropperTrue(): void {
		$hook = $this->makeHook([
			'use_cropper' => true,
			'id' => 'my-input',
			'class' => 'elgg-input-file',
		]);
		$result = Views::fileInputViewVars($hook);

		$this->assertIsArray($result);
		$this->assertStringContainsString('file-input-has-cropper', $result['class']);
		$this->assertStringContainsString('elgg-input-file', $result['class']);
		$this->assertEquals('my-input', $result['id']);
	}

	public function testAddsCropperClassWhenClassIsArray(): void {
		$hook = $this->makeHook([
			'use_cropper' => ['ratio' => 1],
			'id' => 'input-id',
			'class' => ['foo', 'bar'],
		]);
		$result = Views::fileInputViewVars($hook);

		$this->assertIsArray($result);
		$this->assertStringContainsString('foo', $result['class']);
		$this->assertStringContainsString('bar', $result['class']);
		$this->assertStringContainsString('file-input-has-cropper', $result['class']);
	}

	public function testAddsCropperClassWhenNoClassPresent(): void {
		$hook = $this->makeHook([
			'use_cropper' => true,
			'id' => 'some-id',
		]);
		$result = Views::fileInputViewVars($hook);

		$this->assertIsArray($result);
		$this->assertEquals('file-input-has-cropper', trim($result['class']));
	}

	public function testGeneratesIdWhenMissing(): void {
		$hook = $this->makeHook([
			'use_cropper' => true,
		]);
		$result = Views::fileInputViewVars($hook);

		$this->assertIsArray($result);
		$this->assertNotEmpty($result['id']);
		$this->assertStringStartsWith('elgg-file-input-', $result['id']);
	}

	public function testGeneratedIdsAreUniqueAcrossCalls(): void {
		$h1 = $this->makeHook(['use_cropper' => true]);
		$h2 = $this->makeHook(['use_cropper' => true]);
		$r1 = Views::fileInputViewVars($h1);
		$r2 = Views::fileInputViewVars($h2);

		$this->assertNotEquals($r1['id'], $r2['id']);
	}

	public function testPreservesExistingIdAndDoesNotAutoGenerate(): void {
		$hook = $this->makeHook([
			'use_cropper' => true,
			'id' => 'keep-me',
		]);
		$result = Views::fileInputViewVars($hook);

		$this->assertEquals('keep-me', $result['id']);
	}

	public function testUseCropperWithParametersArrayEnablesCropper(): void {
		$hook = $this->makeHook([
			'use_cropper' => [
				'ratio' => 1.5,
				'name' => 'avatar_coords',
			],
			'id' => 'avatar-input',
		]);
		$result = Views::fileInputViewVars($hook);

		$this->assertIsArray($result);
		$this->assertStringContainsString('file-input-has-cropper', $result['class']);
	}
}
