<?php

include '../vendor/autoload.php';

$idg = new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
$idg->beginDocument();

    $idg->beginBlock()->setPadding(50, 50, 60, 50)->setBorder(2, 'black')->setMargin(30, 30, 30, 30);
        $idg->text('Text in block with padding, margin and border. 
        Lorem ipsum dolor sit amet. Ut enim ad minim veniam, quis 
                nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                Duis aute irure dolor in reprehenderit in voluptate 
                                    velit esse cillum dolore eu fugiat nulla pariatur.');

        $idg->beginBlock()->setPadding(50, 50, 60, 50)->setBorder(2, 'black')->setMargin(60, 30, 30, 30);
        $idg->text('Text in block with padding, margin and border. 
            Lorem ipsum dolor sit amet. Ut enim ad minim veniam, quis 
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                    Duis aute irure dolor in reprehenderit in voluptate 
                                        velit esse cillum dolore eu fugiat nulla pariatur.')->setMarginBottom(50);

            $idg->image('test_image.jpg')->setPaddingLeft(210);

            $idg->text('Image with padding left')->setTextColor('#555')->setAlign(Imagick::ALIGN_CENTER);
        $idg->endBlock();
    $idg->endBlock();

$idg->endDocument();
$idg->compose();

header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();