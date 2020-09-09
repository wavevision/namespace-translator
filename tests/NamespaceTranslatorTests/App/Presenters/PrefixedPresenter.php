<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Wavevision\NamespaceTranslatorTests\App\Models\Translated\Other;

class PrefixedPresenter extends BasePresenter
{

	/**
	 * @inject
	 */
	public Other $model;

	public function actionDefault(): void
	{
		$this->template->setParameters(
			[
				'message' => $this->model->processClassPrefixed(),
				'nested' => $this->model->processNestedPrefixed(),
				'unknown' => $this->model->processPrefixed(),
			]
		);
	}

}
