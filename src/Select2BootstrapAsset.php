<?php

namespace xpbl4\select2;

use yii\web\AssetBundle;

/**
 * Widget bootstrap asset bundle.
 */
class Select2BootstrapAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@bower/select2';

	/**
	 * @inheritdoc
	 */
	public $css = [
		'select2-bootstrap.css'
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'xpbl4\widgets\Select2Asset',
		'yii\bootstrap\BootstrapAsset'
	];
}
