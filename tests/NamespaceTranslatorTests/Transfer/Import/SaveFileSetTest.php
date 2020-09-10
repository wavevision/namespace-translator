<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import;

use Nette\SmartObject;
use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\Neon;
use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectSaveFileSet;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class SaveFileSetTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectSaveFileSet;

	public function testUnableToRemoveDefaultLocale(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Unable to remove default locale.');
		vfsStream::setup('r');
		$this->saveFileSet->process(vfsStream::url('r/'), new FileSet([], '', Neon::FORMAT));
	}

	public function testRemoveLocale(): void
	{
		vfsStream::setup('r');
		$file = vfsStream::url('r/en.neon');
		touch($file);
		$this->saveFileSet->process(
			vfsStream::url('r/'),
			new FileSet(
				[
					'one' => [
						'cs' => 'Jedna',
					],
				],
				'',
				Neon::FORMAT
			)
		);
		$this->assertFileNotExists($file);
	}

}
