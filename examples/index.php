<?php
/**
 * Standart usage
 */
include '../vendor/autoload.php';

$fontRobotoRegular = 'RobotoCondensed-Regular.ttf';
$fontRobotoBold = 'RobotoCondensed-Regular.ttf';

$idg = new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));

$idg->beginDocument(20, 30, 20, 30);

    $idg->text('Lorem ipsum dolor sit amet')->setFont($fontRobotoBold)->setFontSize(26);

    $idg->beginBlock()->setTop(20)->setWidth(960);
        $idg->text('Lorem ipsum dolor sit amet, 
        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
         Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
         Duis aute irure dolor in reprehenderit in voluptate 
        velit esse cillum dolore eu fugiat nulla pariatur. 
        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
        )->setFont($fontRobotoRegular);

        $idg->beginRow()->setTop(20);
        $idg->beginColumn(300);
                $idg->image('test_image.jpg');
            $idg->beginBlock()->setLeft(20);
                $idg->text('Figure 1. Dolore eu fugiat nulla pariatur.')
                ->setFont($fontRobotoRegular)->setFontSize(14)->setTextColor('#555');
            $idg->endBlock();
        $idg->endColumn();
        $idg->beginColumn(600);
            $idg->beginBlock()->setTop(30);
                $idg->text('Lorem ipsum dolor sit amet, 
                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                 Duis aute irure dolor in reprehenderit in voluptate 
                velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.')
                ->setFont($fontRobotoRegular);
            $idg->endBlock();

        $idg->beginBlock()->setPadding(4, 10, 10, 10)
            ->setBorder(2, '#500')->setBorderOpacity(0.9)->setMarginTop(20);
        $idg->text('Text block with border. Lorem ipsum dolor sit amet, 
                        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                         Ut enim ad minim venia.')->setAlign(Imagick::ALIGN_CENTER)
            ->setFont($fontRobotoRegular)->setTextColor('#500');
        $idg->endBlock();
        $idg->endColumn();
        $idg->endRow();
    $idg->endBlock();

    $idg->beginBlock()->setTop(40);
        $idg->text('Dolore eu fugiat nulla pariatur.')
        ->setFontSize(26)->setFont($fontRobotoBold);
    $idg->endBlock();

    $idg->beginRow()->setTop(20);
        $idg->beginColumn(300);
            $idg->text('Text in column. Text in column. Text in column. ')->setFont($fontRobotoRegular)->setFontSize(18);
            $idg->image('test_image.jpg')->setMarginTop(20)->setLeft(10);
        $idg->endColumn();
        $idg->beginColumn(300);
            $idg->text('The bear column')->setFont($fontRobotoBold)->setDecoration(Imagick::DECORATION_UNDERLINE)
                ->setFontSize(22)->setAlign(Imagick::ALIGN_CENTER)->setMarginBottom(10);
            $idg->image('test_image.jpg')->setLeft(20);
            $idg->text('Align center. Text in column. Text in column. Text in column. Text in column.
             Text in column. Text in column. Text in column. Text in column. Text in column.')
            ->setFont($fontRobotoRegular)->setFontSize(18)->setAlign(Imagick::ALIGN_CENTER);
        $idg->endColumn();
        $idg->beginColumn(300);
            $idg->text('Column with rotated image. Column with rotated image. 
            Column with rotated image.')->setFont($fontRobotoRegular)->setFontSize(18);
            $idg->image('test_image.jpg')->setMarginTop(20)->setRotation(90);
        $idg->endColumn();
    $idg->endRow();


    $idg->beginBlock()->setTop(40)->setMarginBottom(15);
        $idg->text('Lorem ipsum dolor sit amet')->setFont($fontRobotoBold)->setFontSize(26);
    $idg->endBlock();

    $idg->beginRow();
        $idg->beginColumn(600);
            $idg->beginBlock()->setMarginTop(10);
                $idg->text('Align right. Lorem ipsum dolor sit amet, 
                                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                 aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip 
                                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                                velit esse cillum dolore eu fugiat nulla pariatur. 
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.')
                    ->setFont($fontRobotoRegular)->setAlign(Imagick::ALIGN_RIGHT);
            $idg->endBlock();
        $idg->endColumn();
        $idg->beginColumn(300);
        $idg->beginBlock()->setLeft(50);
        $idg->text('Figure 2. Dolore eu fugiat pariatur.')
        ->setFont($fontRobotoRegular)->setFontSize(14)->setTextColor('#555');
        $idg->endBlock();
            $idg->image('test_image.jpg')->setLeft(30);
        $idg->endColumn();
    $idg->endRow();

$idg->beginAbsoluteBlock(250, 120)->setWidth(200)
    ->setBorder(2, 'white')->setPadding(0, 5, 15, 5)
    ->setBackground('green', 0.5)->setRotation(10);
    $idg->text('Absolute block with rotation')
    ->setFont($fontRobotoBold)->setFontSize(28)->setTextColor('white')->setAlign(Imagick::ALIGN_CENTER);
$idg->endAbsoluteBlock();

$idg->endDocument();

$idg->compose();

header('Content-Type: image/' . $idg->getCanvas()->getImageFormat());
print $idg->getImageBlob();
