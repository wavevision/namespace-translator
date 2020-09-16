<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Json;

trait InjectJsonModel
{

	protected JsonModel $jsonModel;

	public function injectJsonModel(JsonModel $jsonModel): void
	{
		$this->jsonModel = $jsonModel;
	}

}
