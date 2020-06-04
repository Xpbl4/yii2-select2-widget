<?php

namespace xpbl4\select2;

use yii\web\AssetBundle;

/**
 * Widget select2 asset bundle.
 */
class Select2Asset extends AssetBundle
{
	/**
	 * @var string Plugin language
	 */
	public $language;

	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@bower/select2/dist';

	/**
	 * @inheritdoc
	 */
	public $js = [
		'js/select2.js'
	];

	/**
	 * @inheritdoc
	 */
	public $css = [
		'css/select2.css',
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset',
	];

	/**
	 * @inheritdoc
	 */
	public function registerAssetFiles($view)
	{
		if ($this->language !== null) {
			$this->js[] = 'js/i18n/'.$this->language.'.js';
		}

		parent::registerAssetFiles($view);
	}
}
