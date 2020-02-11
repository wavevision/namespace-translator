<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Wavevision\NamespaceTranslatorTests\App\Components\OtherComponent\OtherComponentFactory;
use Wavevision\NamespaceTranslatorTests\App\Components\SomeComponent\SomeComponentFactory;

class OtherPresenter extends BasePresenter
{

	/**
	 * @inject
	 */
	public SomeComponentFactory $someComponentFactory;

	/**
	 * @inject
	 */
	public OtherComponentFactory $otherComponentFactory;

	public function actionDefault(): void
	{
		$this->addComponent($this->someComponentFactory->create(), 'someComponent');
	}

	public function actionNext(): void
	{
		$this->addComponent($this->otherComponentFactory->create(), 'otherComponent');
	}

}
