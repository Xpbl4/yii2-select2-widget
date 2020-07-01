<?php

namespace xpbl4\select2;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Select2 widget
 * Widget wrapper for {@link https://select2.org/ Select2}.
 * @var \yii\base\Widget $this Widget
 *
 * Usage:
 * ~~~
 * echo $form->field($model, 'field')->widget(Select2::className(), [
 *     'items' => [
 *         'item1',
 *         'item2',
 *         ...
 *     ],
 *     'options' => [
 *         'multiple' => true,
 *           'placeholder' => 'Choose item'
 *     ],
 *     'pluginOptions' => [
 *         'width' => '100%',
 *     ],
 *     'pluginEvents' => [
 *         'select2:open' => 'function (e) { log("select2:open", e); }',
 *         'select2:close' => new JsExpression('function (e) { log("select2:close", e); }')
 *         'select2:select' => [
 *             'function (e) { log("select2:select", e); }',
 *             'function (e) { console.log(e); }'
 *         ]
 *         ...
 *     ]
 * ]);
 * ~~~
 */
class Select2 extends InputWidget
{
	/** Name of inline JavaScript package that is registered by the widget */
	const INLINE_JS_KEY = 'xpbl4/select2/';

	/**
	 * @var array {@link https://select2.org/configuration/options-api Select2} options
	 */
	public $pluginOptions = [];

	/**
	 * @var array Select items
	 */
	public $items = [];

	/**
	 * @var string Plugin language. If `null`, [[\yii\base\Application::language|app language]] will be used.
	 */
	public $language;

	/**
	 * @var boolean Whatever to use bootstrap CSS or not
	 */
	public $bootstrap = true;

	/**
	 * Events array. Array keys are the events name, and array values are the events callbacks.
	 * Example:
	 * ```php
	 * [
	 *     'select2:open' => 'function (e) { log("select2:open", e); }',
	 *     'select2:close' => new JsExpression('function (e) { log("select2:close", e); }'),
	 *     'select2:select' => [
	 *         'function (e) { log("select2:select", e); }',
	 *         'function (e) { console.log(e); }'
	 *     ]
	 * ]
	 * ```
	 * @var array Plugin events
	 */
	public $pluginEvents = [];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		// Set language
		if ($this->language === null && ($language = Yii::$app->language) !== 'en-US') {
			$this->language = substr($language, 0, 2);
		}

		// Set placeholder
		$_placeholder = ArrayHelper::remove($this->options, 'prompt');
		if (!is_null($_placeholder) && !key_exists('allowClear', $this->pluginOptions)) $this->pluginOptions['allowClear'] = true;

		$_placeholder = ArrayHelper::remove($this->options, 'placeholder', $_placeholder);
		$_placeholder = ArrayHelper::remove($this->pluginOptions, 'placeholder', $_placeholder);

		if ($_placeholder === true && $this->hasModel()) $_placeholder = $this->model->getAttributeLabel($this->attribute);
		if (!is_null($_placeholder)) {
			$this->pluginOptions['placeholder'] = $_placeholder;
			if (empty($this->options['multiple'])) $this->options['prompt'] = $_placeholder;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$this->registerClientScript();
		if ($this->hasModel()) {
			return Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
		} else {
			return Html::dropDownList($this->name, $this->value, $this->items, $this->options);
		}
	}

	/**
	 * Register widget asset.
	 */
	public function registerClientScript()
	{
		$view = $this->getView();
		$selector = '#'.$this->options['id'];

		// Register asset
		$asset = Select2Asset::register($view);

		if ($this->language !== null) {
			$asset->language = $this->language;
			$this->pluginOptions['language'] = $this->language;
		}

		Select2WidgetAsset::register($view);

		// Init widget
		$settings = Json::encode($this->pluginOptions);
		$view->registerJs("jQuery('$selector').select2($settings);", $view::POS_READY, self::INLINE_JS_KEY.$this->options['id']);

		// Register events
		$this->registerEvents();
	}

	/**
	 * Register plugin' events.
	 */
	protected function registerEvents()
	{
		$view = $this->getView();
		$selector = '#'.$this->options['id'];

		if (!empty($this->pluginEvents)) {
			$js = [];
			foreach ($this->pluginEvents as $event => $callback) {
				if (is_array($callback)) {
					foreach ($callback as $function) {
						if (!$function instanceof JsExpression) {
							$function = new JsExpression($function);
						}
						$js[] = "jQuery('$selector').on('$event', $function);";
					}
				} else {
					if (!$callback instanceof JsExpression) {
						$callback = new JsExpression($callback);
					}
					$js[] = "jQuery('$selector').on('$event', $callback);";
				}
			}
			if (!empty($js)) {
				$js = implode("\n", $js);
				$view->registerJs($js, $view::POS_READY, self::INLINE_JS_KEY.'events/'.$this->options['id']);
			}
		}
	}
	
	public static function field($model, $attribute, $options)
	{
		return self::widget(ArrayHelper::merge(['model' => $model, 'attribute' => $attribute], $options));
	}
}