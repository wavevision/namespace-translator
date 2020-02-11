<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Wavevision\NamespaceTranslatorTests\App\Models\Translated\Model;

class HomePresenter extends BasePresenter
{

	/**
	 * @inject
	 */
	public Model $translatedModel;

	public function actionDefault(): void
	{
		$this->template->setParameters(
			[
				'modelTranslation' => $this->translatedModel->process(),
				'nestedTranslation' => $this->translatedModel->processNested(),
			]
		);
	}

}
