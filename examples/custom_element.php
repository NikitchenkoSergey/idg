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
$customBlock->top = 20;
$idg = new \Idg\Idg(1000, 3000);

$idg->beginDocument(20, 30, 60, 30);
    $idg->beginElement($customBlock);
        $idg->beginBlock(10, 10, null, 110);
            $idg->text('Lorem ipsum dolor sit amet. Ut enim ad minim veniam, quis 
            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
            Duis aute irure dolor in reprehenderit in voluptate 
                                velit esse cillum dolore eu fugiat nulla pariatur. ',
                $fontRobotoRegular, 26, '#000', Imagick::ALIGN_LEFT);
        $idg->endBlock();
    $idg->endElement();

$idg->endDocument();

$idg->compose();

header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();