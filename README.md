# Yii2 Select2 widget

[![Latest Version](https://img.shields.io/github/tag/Xpbl4/yii2-select2-widget.svg?style=flat-square&label=release)](https://github.com/Xpbl4/yii2-select2-widget/releases)
[![Software License](https://img.shields.io/badge/license-BSD-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/Xpbl4/yii2-select2-widget.svg?style=flat-square)](https://packagist.org/packages/Xpbl4/yii2-select2-widget)

Select2 widget is a wrapper of [Select2](https://select2.org/) for Yii 2 framework.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xpbl4/yii2-select2-widget "*"
```

or add

```
"xpbl4/yii2-select2-widget": "*"
```

to the require section of your `composer.json` file.

## Usage

Once the extension is installed, simply use it in your code by:

```php
use xpbl4\select\Select2;

echo $form->field($model, 'field')->widget(Select2::className(), [
    'items' => [
        'item1',
        'item2',
        ...
    ],
    'options' => [
        'multiple' => true,
        'placeholder' => 'Choose item'
    ],
    'pluginOptions' => [
        'width' => '100%',
    ],
    'pluginEvents' => [
        'select2:open' => 'function (e) { log("select2:open", e); }',
        'select2:close' => new JsExpression('function (e) { log("select2:close", e); }')
        ...
    ]
]);
```

## Testing

``` bash
$ phpunit
```

## Further Information

Please, check the [Select2](https://select2.org/) documentation for further information about its configuration options.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Serge Mashkov](https://github.com/Xpbl4)
- [All Contributors](../../contributors)

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.
