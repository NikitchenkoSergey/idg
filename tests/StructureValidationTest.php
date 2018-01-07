<?php
use Idg\Exceptions\StructureException;
/**
 * Structure validation test
 * Class StructureValidationTest
 */
class StructureValidationTest  extends \PHPUnit\Framework\TestCase
{
    /**
     * @return \Idg\Idg
     */
    protected function getIdg()
    {
        return new \Idg\Idg(1000, 3000, null, new ImagickPixel('#fff'));
    }

    /**
     * Test document is first
     */
    public function testDocumentIsFirst()
    {
        $idg = $this->getIdg();
        $this->expectException(StructureException::class);
        $idg->beginBlock();
    }

    /**
     * Test close element
     */
    public function testCloseElement()
    {
        $idg = $this->getIdg();
        $this->expectException(StructureException::class);
        $idg->beginDocument();
        $idg->compose();
    }

    /**
     * Test column in row
     */
    public function testColumn()
    {
        $idg = $this->getIdg();
        $this->expectException(StructureException::class);
        $idg->beginDocument();
        $idg->beginColumn(200);
        $idg->endColumn();
        $idg->endDocument();
        $idg->compose();
    }
}