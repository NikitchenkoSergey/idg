<?php
/**
 * Examples
 */
include '../vendor/autoload.php';

$fontRobotoRegular = 'RobotoCondensed-Regular.ttf';
$fontRobotoBold = 'RobotoCondensed-Regular.ttf';

$idg = new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));

$idg->beginDocument(40, 20, 40, 20);
    $idg->beginBlock(30);
        $idg->text('Lorem ipsum dolor sit amet', $fontRobotoBold, 26, '#000', Imagick::ALIGN_LEFT);
    $idg->endBlock();

    $idg->beginBlock(20, 0, 980);
        $idg->text('Lorem ipsum dolor sit amet, 
        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
        velit esse cillum dolore eu fugiat nulla pariatur. 
        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', $fontRobotoRegular);

        $idg->beginRow(20);
        $idg->beginColumn(300);
                $idg->image(0, 0, 'test_image.jpg');
            $idg->beginBlock(0, 20);
                $idg->text('Figure 1. Dolore eu fugiat nulla pariatur.', $fontRobotoRegular, 14, '#555', Imagick::ALIGN_LEFT);
            $idg->endBlock();
        $idg->endColumn();
        $idg->beginColumn(600);
            $idg->beginBlock(30);
                $idg->text('Lorem ipsum dolor sit amet, 
                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', $fontRobotoRegular);
            $idg->endBlock();
        $idg->endColumn();
        $idg->endRow();
    $idg->endBlock();

    $idg->beginBlock(40);
        $idg->text('Dolore eu fugiat nulla pariatur.', $fontRobotoBold, 26, '#000', Imagick::ALIGN_LEFT);
    $idg->endBlock();

    $idg->beginRow(20);
        $idg->beginColumn(300);
            $idg->text('Text in column. Text in column. Text in column. ', $fontRobotoRegular, 18, 'black', Imagick::ALIGN_LEFT);
            $idg->image(0, 0, 'test_image.jpg');
        $idg->endColumn();
        $idg->beginColumn(300);
            $idg->text('The bear column', $fontRobotoBold, 22, '#000', Imagick::ALIGN_CENTER);
            $idg->image(0, 20, 'test_image.jpg');
            $idg->text('Text in column. Text in column. Text in column. Text in column.
             Text in column. Text in column. Text in column. Text in column. Text in column.', $fontRobotoRegular, 18, 'black', Imagick::ALIGN_CENTER);
        $idg->endColumn();
        $idg->beginColumn(300);
            $idg->text('Align center. Text in column. Text in column. Text in column. 
            Text in column. Text in column. Text in column. ', $fontRobotoRegular, 18, 'black', Imagick::ALIGN_LEFT);
            $idg->image(0, 0, 'test_image.jpg');
        $idg->endColumn();
    $idg->endRow();


    $idg->beginBlock(40);
        $idg->text('Lorem ipsum dolor sit amet', $fontRobotoBold, 26, '#000', Imagick::ALIGN_LEFT);
    $idg->endBlock();

    $idg->beginRow();
        $idg->beginColumn(600);
            $idg->beginBlock(30);
                $idg->text('Align right. Lorem ipsum dolor sit amet, 
                                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                 aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                                velit esse cillum dolore eu fugiat nulla pariatur. 
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                    $fontRobotoRegular, 16, 'black', Imagick::ALIGN_RIGHT);
            $idg->endBlock();
        $idg->endColumn();
        $idg->beginColumn(300);
        $idg->beginBlock(0, 50);
        $idg->text('Figure 2. Dolore eu fugiat pariatur.', $fontRobotoRegular, 14, '#555', Imagick::ALIGN_LEFT);
        $idg->endBlock();
            $idg->image(0, 30, 'test_image.jpg');
        $idg->endColumn();
    $idg->endRow();

$idg->endDocument();
$idg->compose();
//print_r($idg); die();
header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();