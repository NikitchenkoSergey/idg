<?php
use Idg\Elements\Properties\Values\Gradient;
include '../vendor/autoload.php';

$idg = new \Idg\Idg(340, 3000, null, new ImagickPixel('#fff'));
$idg->beginDocument(20, 20, 20, 20);

    $idg->beginBlock()->setBorder(2, 'black')->setWidth(300);
        $idg->text('Text in block. Text in block. 
        Text in block. Text in block. Text in block. 
        Text in block. Text in block. Text in block. 
        Text in block. Text in block. Text in block. Text in block. Text in block. ')
            ->setMargin(10, 20, 20, 20);

    $idg->endBlock();

    $idg->beginBlock()
        ->setStaticHeight(function(\Idg\Elements\Element $element) {
            return $element->getPrevSibling()->getHeight();
        })
        ->setWidth(function(\Idg\Elements\Element $element) {
            return $element->getPrevSibling()->getWidth();
        })
        ->setBorder(2, 'black');
        $idg->text('Block with height and width like prev.')
            ->setMargin(10, 20, 20, 20);

    $idg->endBlock();

$idg->endDocument();
$idg->compose();


header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();
