<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated;

trait InjectModel
{

	protected Model $model;

	public function injectModel(Model $model): void
	{
		$this->model = $model;
	}

}
