<?php
use Idg\Exceptions\StructureException;
/**
 * Margin test
 * Class MarginTest
 */
class MarginTest  extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \Idg\Idg
     * @throws ImagickException
     */
    protected function getIdg()
    {
        return new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
    }

    /**
     * Test blocks with padding and margin
     * @throws ImagickException
     * @throws StructureException
     */
    public function testBlocksWithPaddingAndMargin()
    {
        $idg = $this->getIdg();
        $idg->beginDocument(10);
        $idg->beginBlock()->setTop(20)->setLeft(20);
            $idg->beginBlock()->setTop(30);

            $idg->endBlock();
            $idg->beginBlock()->setTop(10)
                ->setPaddingBottom(30)
                ->setPaddingTop(40)
                ->setMargin(11, 22, 33, 44);
                // 256x256
                $idg->image(dirname(__FILE__) . '/data/test_image.jpg')
                    ->setTop(10)
                    ->setPadding(20, 30, 20, 30)
                    ->setMargin(5, 15, 25, 35)
                ;
            $idg->endBlock();
        $idg->endBlock();

        $idg->endDocument();
        $idg->compose();

        $document = $idg->getDocument();
        $elements = $idg->getElements();
        $imageElement = $elements[4];

        $this->assertInstanceOf(\Idg\Elements\Image::class, $imageElement);
        $this->assertEquals(256  + 20 * 2, $imageElement->getHeight());
        $this->assertEquals(10 + 20 + 30 + 10 + 40 + 10 + 5 + 11, $imageElement->getTopOffset());
        $this->assertEquals(10 + 20 + 30 + 10 + 30 + 40 + 11 + 33 + $imageElement->getOuterHeight(), $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());
    }
}