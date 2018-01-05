# Image document generator (IGD)
Fast and simple document image generator. This is a wrapper over Imagick with which you can create such images:
<p align="center">
       <img src="http://nikitchenko.ru/idg/example1.png" width="550" alt="Example" />
</p>
See: examples/index.php

# Requirements
PHP 5.5+, `Imagick` extension.

# Installation
composer require idg/idg

# Usage
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';
// font for example
$fontRegular = 'RobotoCondensed-Regular.ttf';

$idg = new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
$idg->beginDocument(40, 30, 40, 30);
    $idg->beginBlock(30);
        $idg->text('Text example', $fontRobotoBold, 26, '#000', Imagick::ALIGN_LEFT);
    $idg->endBlock();
$idg->endDocument();
$idg->compose();

header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();
```

# Methods
| Method | Description |
| ---| --- |
| `Idg($width, $maxHeight, $minHeight = null, $background = null, $type = 'png')` | Creating new generator |
| `$idg->beginDocument($marginTop = 0, $marginLeft = 0, $marginBottom = 0, $marginRight = 0)` | Begin Document. It required. |
| `$idg->endDocument()` | End document. |
| `$idg->beginBlock($top = null, $left = null, $width = null, $height = null)` | Begin relative block. |
| `$idg->endBlock()` | End block. |
| `$idg->beginAbsoluteBlock($top, $left, $width = null, $height = null)` | Begin absolute block. |
| `$idg->endAbsoluteBlock()` | End absolute block. |
| `$idg->beginRow($top = null, $left = null, $width = null, $height = null)` | Begin row. |
| `$idg->endRow()` | End row. |
| `$idg->beginColumn($width)` | Begin column. |
| `$idg->endColumn()` | End column. |
| `$idg->image($top, $left, $file, $fromBlob = false)` | Adding image. |
| `$idg->text($content, $font, $fontSize = 16, $textColor = 'black', $align = Imagick::ALIGN_LEFT)` | Adding tet. |
| `$idg->addElement(Element $element)` | Add custom element. |
| `$idg->getCanvas()` | Return Imagick object. |
| `$idg->compose()` | Composing blocks. |
| `$idg->getImageBlob()` | Returning image result blob. |

For more customization you can use $idg->getCanvas() after compose():
```php
$idg->compose();
$idg->getCanvas()->gaussianBlurImage(10, 20);
```