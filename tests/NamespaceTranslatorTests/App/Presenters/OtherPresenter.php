<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Wavevision\NamespaceTranslatorTests\App\Components\SomeComponent\SomeComponentFactory;

class OtherPresenter extends BasePresenter
{

	public const COMPONENT = 'someComponent';

	/**
	 * @inject
	 * @var SomeComponentFactory
	 */
	public $someComponentFactory;

	public function actionDefault(): void
	{
		$this->addComponent($this->someComponentFactory->create(), self::COMPONENT);
	}

}
