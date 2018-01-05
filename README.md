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
 $idg->beginRow();
        $idg->beginColumn(300);
            $idg->image(0, 0, 'test_image.jpg');
            $idg->beginBlock(0, 20);
                $idg->text('Figure 1. Dolore eu fugiat nulla pariatur.', $fontRegular, 14, '#555', Imagick::ALIGN_LEFT);
            $idg->endBlock();
        $idg->endColumn();
        $idg->beginColumn(600);
                $idg->text('Lorem ipsum dolor sit amet, 
                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', $fontRegular);
        $idg->endColumn();
        $idg->endRow();
$idg->endDocument();
$idg->compose();

header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();
```

### Result
<p align="center">
       <img src="http://nikitchenko.ru/idg/example2.png" alt="Example" />
</p>

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
