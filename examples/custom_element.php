<?php
/**
 * With custom element
 */
include '../vendor/autoload.php';

$fontRobotoRegular = 'RobotoCondensed-Regular.ttf';

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
$idg = new \Idg\Idg(1000, 3000);

$idg->beginDocument(20, 20, 40, 20);
$idg->text('Custom element')->setAlign(Imagick::ALIGN_CENTER)->setFontSize(26)->setFont($fontRobotoRegular);
    $idg->beginElement($customBlock)->setTop(20)->setPaddingBottom(25);
        $idg->beginBlock()->setTop(10)->setLeft(10);
            $idg->text('Lorem ipsum dolor sit amet. Ut enim ad minim veniam, quis 
            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
            Duis aute irure dolor in reprehenderit in voluptate 
                                velit esse cillum dolore eu fugiat nulla pariatur. ')->setFont($fontRobotoRegular)->setFontSize(26);
        $idg->endBlock();
    $idg->endElement();

    // second way
    $idg->beginBlock()->setStaticHeight(20);
    $idg->endBlock();

    $idg->text('Second way by afterRender Closure')->setFont($fontRobotoRegular)
        ->setFontSize(26)->setAlign(Imagick::ALIGN_CENTER);

    $idg->beginBlock()->setTop(20)->setPaddingBottom(25)->setAfterRender(function (\Idg\Elements\Element $element) {
        $draw = new \ImagickDraw();
        $strokeColor = new \ImagickPixel('green');
        $fillColor = new \ImagickPixel('green');

        $draw->setStrokeColor($strokeColor);
        $draw->setFillColor($fillColor);
        $draw->setFillOpacity(0.1);
        $draw->setStrokeOpacity(1);
        $draw->setStrokeWidth(2);

        $draw->rectangle($element->getLeftOffset(), $element->getTopOffset(), $element->getLeftOffset() + $element->getWidth(), $element->getTopOffset() + $element->getHeight());
        $element->getIdg()->getCanvas()->drawImage($draw);
    });
        $idg->beginBlock()->setTop(10)->setLeft(10);
            $idg->text('Lorem ipsum dolor sit amet. Ut enim ad minim veniam, quis 
                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate 
                                            velit esse cillum dolore eu fugiat nulla pariatur. ')->setFont($fontRobotoRegular)->setFontSize(26);
        $idg->endBlock();
    $idg->endElement();

$idg->endDocument();

$idg->compose();

header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();