<?php
use Idg\Exceptions\StructureException;
/**
 * Tables test
 * Class TablesTest
 */
class TablesTest  extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \Idg\Idg
     */
    protected function getIdg()
    {
        return new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
    }

    /**
     * Test absolute block
     */
    public function testTableWithBlocks()
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

            $idg->beginRow()->setTop(15);
                $idg->beginColumn(100)->setStaticHeight(150);
                $idg->endColumn();
                $idg->beginColumn(100)->setStaticHeight(170);
                $idg->endColumn();
            $idg->endRow();
        $idg->endBlock();

        // don't increase document height
        $idg->beginAbsoluteBlock(40, 50)->setWidth(100);

        $idg->endBlock();
        $idg->endDocument();
        $idg->compose();

        $document = $idg->getDocument();
        $this->assertEquals(10 + 20 + 30 + 10 + 15 + 170, $document->getHeight());
        $this->assertEquals(1000, $document->getWidth());
    }
}