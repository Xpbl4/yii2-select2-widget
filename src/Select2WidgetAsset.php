<?php

namespace xpbl4\select2;

use yii\web\AssetBundle;

/**
 * Widget select2 asset bundle.
 */
class Select2WidgetAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@xpbl4/select2/assets';

	/**
	 * @inheritdoc
	 */
	public $js = [
		'select2-search.js'
	];

	/**
	 * @inheritdoc
	 */
	public $css = [
		'select2-bootstrap.css',
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'xpbl4\select2\Select2Asset',
	];

}
