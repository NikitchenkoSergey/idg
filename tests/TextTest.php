<?php
use Idg\Exceptions\StructureException;
/**
 * Text test
 * Class TextTest
 */
class TextTest  extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \Idg\Idg
     */
    protected function getIdg()
    {
        return new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
    }

    /**
     * Test text in blocks
     */
    public function testTextInBlocks()
    {
        $idg = $this->getIdg();
        $idg->beginDocument(10);
        $idg->beginBlock()->setTop(20)->setLeft(20);
            $idg->beginBlock()->setTop(30);

            $idg->endBlock();
            $idg->beginBlock()->setTop(10);
                $idg->text('test test')->setFontSize(20);
            $idg->endBlock();
        $idg->endBlock();

        $idg->endDocument();
        $idg->compose();

        $document = $idg->getDocument();
        $elements = $idg->getElements();
        $textElement = $elements[4];

        $this->assertInstanceOf(\Idg\Elements\Text::class, $textElement);
        $this->assertGreaterThan(10, $textElement->getHeight());
        $this->assertEquals(10 + 20 + 30 + 10 + $textElement->getHeight(), $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());
    }
}