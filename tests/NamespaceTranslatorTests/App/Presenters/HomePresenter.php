<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Wavevision\NamespaceTranslatorTests\App\Models\Json\InjectJsonModel;
use Wavevision\NamespaceTranslatorTests\App\Models\Translated\InjectModel;

class HomePresenter extends BasePresenter
{

	use InjectModel;
	use InjectJsonModel;

	public function actionDefault(): void
	{
		$this->template->setParameters(
			[
				'modelTranslation' => $this->model->process(),
				'nestedTranslation' => $this->model->processNested(),
				'paramTranslation' => $this->model->process(),
				'integerTranslation' => $this->model->processInteger(),
			]
		);
	}

	public function actionInteger(): void
	{
		$this->template->setParameters(['translation' => $this->model->processInteger()]);
	}

	public function actionJson(): void
	{
		$this->template->setParameters(
			[
				'nonPrefix' => $this->jsonModel->nonPrefix(),
				'nested' => $this->jsonModel->nested(),
			]
		);
	}

}
