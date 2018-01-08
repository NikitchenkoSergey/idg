<?php
use Idg\Exceptions\StructureException;
/**
 * Image test
 * Class ImageTest
 */
class ImageTest  extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \Idg\Idg
     */
    protected function getIdg()
    {
        return new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
    }

    /**
     * Test image in blocks
     */
    public function testImageInBlocks()
    {
        $idg = $this->getIdg();
        $idg->beginDocument(10);
        $idg->beginBlock()->setTop(20)->setLeft(20);
            $idg->beginBlock()->setTop(30);

            $idg->endBlock();
            $idg->beginBlock()->setTop(10);
                // 256x256
                $idg->image(dirname(__FILE__) . '/data/test_image.jpg')->setTop(10);
            $idg->endBlock();
        $idg->endBlock();

        $idg->endDocument();
        $idg->compose();

        $document = $idg->getDocument();
        $elements = $idg->getElements();
        $imageElement = $elements[4];

        $this->assertInstanceOf(\Idg\Elements\Image::class, $imageElement);
        $this->assertEquals(256, $imageElement->getHeight());
        $this->assertEquals(10 + 20 + 30 + 10 + $imageElement->getOuterHeight(), $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());
    }
}