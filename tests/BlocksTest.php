<?php
use Idg\Exceptions\StructureException;
/**
 * Blocks test
 * Class BlocksTest
 */
class BlocksTest  extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \Idg\Idg
     */
    protected function getIdg()
    {
        return new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
    }

    /**
     * Test block
     */
    public function testBlock()
    {
        $idg = $this->getIdg();
        $idg->beginDocument();
            $idg->beginBlock();
            $idg->endBlock();
        $idg->endDocument();
        $idg->compose();

        //empty document
        $document = $idg->getDocument();
        $this->assertEquals(0, $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());

        $idg = $this->getIdg();
        $idg->beginDocument();
            $idg->beginBlock()->setTop(20)->setLeft(20);
                $idg->beginBlock()->setTop(30);

                $idg->endBlock();
                $idg->beginBlock()->setTop(10);

                $idg->endBlock();
            $idg->endBlock();

            $idg->beginBlock()->setTop(40);

            $idg->endBlock();
        $idg->endDocument();
        $idg->compose();

        $document = $idg->getDocument();
        $this->assertEquals(20 + 30 + 10 + 40, $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());
    }

    /**
     * Test absolute block
     */
    public function testAbsoluteBlock()
    {
        $idg = $this->getIdg();
        $idg->beginDocument(10);
        $idg->beginBlock()->setTop(20)->setLeft(20);
        $idg->beginBlock()->setTop(30);

        $idg->endBlock();
        $idg->beginBlock()->setTop(10);
            $idg->beginAbsoluteBlock(40, 50)->setWidth(100);

            $idg->endBlock();
        $idg->endBlock();
        $idg->endBlock();

        // don't increase document height
        $idg->beginAbsoluteBlock(40, 50)->setWidth(100);

        $idg->endBlock();
        $idg->endDocument();
        $idg->compose();

        $document = $idg->getDocument();
        $this->assertEquals(10 + 20 + 30 + 10, $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());
    }
}