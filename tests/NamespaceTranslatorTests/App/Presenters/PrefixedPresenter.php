<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Wavevision\NamespaceTranslatorTests\App\Models\Translated\InjectOther;

class PrefixedPresenter extends BasePresenter
{

	use InjectOther;

	public function actionDefault(): void
	{
		$this->template->setParameters(
			[
				'message' => $this->other->processClassPrefixed(),
				'nested' => $this->other->processNestedPrefixed(),
				'unknown' => $this->other->processPrefixed(),
			]
		);
	}

}
