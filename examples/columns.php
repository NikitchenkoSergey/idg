<?php

include '../vendor/autoload.php';
// font for example
$fontRegular = 'RobotoCondensed-Regular.ttf';

$idg = new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
$idg->beginDocument(40, 30, 40, 30);
    $idg->beginRow();
        $idg->beginColumn(300);
        $idg->image('test_image.jpg');
        $idg->beginBlock()->setLeft(20);
        $idg->text('Figure 1. Dolore eu fugiat nulla pariatur.')->setTextColor('#555')->setFontSize(14)->setFont($fontRegular);
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