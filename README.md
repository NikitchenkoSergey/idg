# Document image generator
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![Build Status](https://travis-ci.org/NikitchenkoSergey/idg.svg?branch=master)](https://travis-ci.org/NikitchenkoSergey/idg)
[![License](https://poser.pugx.org/idg/idg/license.svg)](https://packagist.org/packages/idg/idg)

Fast and simple document image generator. This is a wrapper over Imagick with which you can create such images:
<p align="center">
       <img src="http://nikitchenko.ru/idg/example1.png" width="550" alt="Example" />
</p>
See: examples/index.php

### Features
* Any elements count and structure
* Possibility to create custom elements
* Simple markup (like html)
* Possibility to custom canvas by Imagick methods
* Faster and more optimal that html->pdf->image

# Requirements
PHP 5.6+, `Imagick` extension.

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
            $idg->image('test_image.jpg');
            $idg->beginBlock()->setLeft(20);
                $idg->text('Figure 1. Dolore eu fugiat nulla pariatur.')
                ->setFont($fontRegular)->setFontSize(14)->setTextColor('#555');
            $idg->endBlock();
        $idg->endColumn();
        $idg->beginColumn(600);
                $idg->text('Lorem ipsum dolor sit amet, 
                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.')
                    ->setFont($fontRegular);
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
see: examples/columns.php

# Methods
## Idg
| Method | Return | Description |
| ---| --- | --- |
| `Idg($width, $maxHeight, $minHeight = null, $background = null, $type = 'png')` | `Idg` | Creating new generator |
| `$idg->beginDocument($marginTop = 0, $marginLeft = 0, $marginBottom = 0, $marginRight = 0)` | `Document` | Begin Document. It required. |
| `$idg->endDocument()` | | End document. |
| `$idg->beginBlock()` | `Block` | Begin relative block. |
| `$idg->endBlock()` | | End block. |
| `$idg->beginAbsoluteBlock($top, $left)` | `AbsoluteBlock` | Begin absolute block. |
| `$idg->endAbsoluteBlock()` | | End absolute block. |
| `$idg->beginRow()` | `Row` | Begin row. |
| `$idg->endRow()` | | End row. |
| `$idg->beginColumn($width)` | `Column` | Begin column. |
| `$idg->endColumn()` | | End column. |
| `$idg->image($file, $fromBlob = false)` | `Image` | Adding image. |
| `$idg->text($content)` | `Text` | Adding text. |
| `$idg->addElement(Element $element)` | `Element` | Add custom element. |
| `$idg->getCanvas()` | `Imagick` | Return Imagick object. |
| `$idg->compose()` | | Composing blocks. |
| `$idg->getImageBlob()` | `string` | Returning image result blob. |
| `$idg->beginElement(Element $element)` | `Element` | Begin custom element. |
| `$idg->endElement()` | | End custom element. |

## Element
The element is responsible for its display 

### Main methods

| Method | Return | Description |
| ---| --- | --- |
| `Element()` | `Element` | Creating new element |
| `$element->setTop($value)` | `Element` | Setting top |
| `$element->setLeft($value)` | `Element` | Setting left |
| `$element->setWidth($value)` | `Element` | Setting width |
| `$element->setStaticHeight($value)` | `Element` | Setting static height |
| `$element->setAfterRender($closure)` | `Element` | Setting after render function, see: examples/custom_element.php |
| `$element->getParent()` | `Element or null` | Get parent element |
| `$element->getIdg()` | `Igd` | Get Igd object |
| `$element->getWidth()` | `int` | Get width or parents width |
| `$element->getLeft()` | `int` | Get left |
| `$element->getTop()` | `int` | Get top |
| `$element->getTopOffset()` | `int` | Get global top offset |
| `$element->getHeight()` | `int` | Get height with children |
| `$element->getOuterHeight()` | `int` | Get height with top |
| `$element->increaseHeight($value)` | | Increase self height |
| `$element->getChildren()` | `Element[]` | List of children |
| `$element->getSiblings()` | `Element[]` | List of siblings with current element |
| `$element->getPrevSibling()` | `Element` | Prev sibling |
| `$element->getPrevSiblings()` | `Element[]` | List of prev siblings |
| `$element->beforeRender()` | | Method will call before render document |
| `$element->render()` | | Method will call on render document |
| `$element->afterRender()` | | Method will call after render document |

### Element properties

#### Padding
| Method | Return | Description |
| ---| --- | --- |
| `$element->setPaddingTop($value)` | `Element` | Setting padding top |
| `$element->setPaddingLeft($value)` | `Element` | Setting padding left |
| `$element->setPaddingRight($value)` | `Element` | Setting padding right |
| `$element->setPaddingBottom($value)` | `Element` | Setting padding bottom |
| `$element->setPadding($top, $right, $bottom, $left)` | `Element` | Setting padding |

#### Margin
| Method | Return | Description |
| ---| --- | --- |
| `$element->setMarginTop($value)` | `Element` | Setting margin top |
| `$element->setMarginLeft($value)` | `Element` | Setting margin left |
| `$element->setMarginRight($value)` | `Element` | Setting margin right |
| `$element->setMarginBottom($value)` | `Element` | Setting margin bottom |
| `$element->setMargin($top, $right, $bottom, $left)` | `Element` | Setting margin |


#### Border
| Method | Return | Description |
| ---| --- | --- |
| `$element->setBorderColor($value)` | `Element` | Setting border color |
| `$element->setBorderWidth($value)` | `Element` | Setting border width |
| `$element->setBorder($width, $color)` | `Element` | Setting border |


### Text (extends Element)
| Method | Return | Description |
| ---| --- | --- |
| `$element->setAlign($value)` | `Element` | Setting align |
| `$element->setAngle($value)` | `Element` | Setting angle of line |
| `$element->setFontSize($value)` | `Element` | Setting font size, 16 default |
| `$element->setFont($value)` | `Element` | Setting font family |
| `$element->setTextColor($value)` | `Element` | Setting text color, black default |
| `$element->setFontStyle(\ImagickDraw $draw)` | `Element` | Setting style, it override all attributes |


### Padding, margin and border
<p align="center">
       <img src="http://nikitchenko.ru/idg/padding_margin.png" alt="Example" />
</p>
See: examples/padding_margin.php <br />

## Custom elements
<p align="center">
       <img src="http://nikitchenko.ru/idg/example3.png" alt="Example" />
</p>
See: examples/custom_element.php <br />
Custom element must be instance from Element (or children)

```php
/**
 * Custom element with green background
 * Class GreenBlock
 */
class GreenBlock extends \Idg\Elements\Element
{
    /**
     * @inheritdoc
     */
    function afterRender()
    {
        $draw = new \ImagickDraw();
        $strokeColor = new \ImagickPixel('green');
        $fillColor = new \ImagickPixel('green');

        $draw->setStrokeColor($strokeColor);
        $draw->setFillColor($fillColor);
        $draw->setFillOpacity(0.1);
        $draw->setStrokeOpacity(1);
        $draw->setStrokeWidth(2);

        $draw->rectangle($this->getLeftOffset(), $this->getTopOffset(), $this->getLeftOffset() + $this->getWidth(), $this->getTopOffset() + $this->getHeight());
        $this->getIdg()->getCanvas()->drawImage($draw);
    }
}
$customBlock = new GreenBlock();
// .....
$idg->beginElement($customBlock)->setTop(20)->setPaddingBottom(25);
// .....
$idg->endElement();
// .....
```

For more customization you can use standart Imagick methods:
```php
$idg->compose();
$idg->getCanvas()->gaussianBlurImage(10, 20);
```
