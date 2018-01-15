<?php
use Idg\Exceptions\StructureException;
/**
 * Padding test
 * Class PaddingTest
 */
class PaddingTest  extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \Idg\Idg
     */
    protected function getIdg()
    {
        return new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
    }

    /**
     * Test blocks with padding
     */
    public function testBlocksWithPadding()
    {
        $idg = $this->getIdg();
        $idg->beginDocument(10);
        $idg->beginBlock()->setTop(20)->setLeft(20);
            $idg->beginBlock()->setTop(30);

            $idg->endBlock();
            $idg->beginBlock()->setTop(10)->setPaddingBottom(30)->setPaddingTop(40);
                // 256x256
                $idg->image(dirname(__FILE__) . '/data/test_image.jpg')->setTop(10)->setPadding(20, 30, 20, 30);
            $idg->endBlock();
        $idg->endBlock();

        $idg->endDocument();
        $idg->compose();

        $document = $idg->getDocument();
        $elements = $idg->getElements();
        $imageElement = $elements[4];

        $this->assertInstanceOf(\Idg\Elements\Image::class, $imageElement);
        $this->assertEquals(256  + 20 * 2, $imageElement->getHeight());
        $this->assertEquals(10 + 20 + 30 + 10 + 40 + 10, $imageElement->getTopOffset());
        $this->assertEquals(10 + 20 + 30 + 10 + 30 + 40 + $imageElement->getOuterHeight(), $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());
    }
}