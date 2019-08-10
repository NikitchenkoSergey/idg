<?php
namespace Idg;

use Idg\Elements\AbsoluteBlock;
use Idg\Elements\Column;
use Idg\Elements\Document;
use Idg\Elements\Element;
use Idg\Elements\Block;
use Idg\Elements\Image;
use Idg\Elements\Row;
use Idg\Elements\Text;
use Idg\Exceptions\StructureException;
use Imagick;
use ImagickPixel;

/**
 * Class Idg
 * @package Idg
 */
class Idg
{
    /**
     * @var Imagick
     */
    protected $canvas;

    /**
     * @var integer
     */
    protected $width;

    /**
     * @var integer
     */
    protected $minHeight;

    /**
     * @var Element[]
     */
    protected $elements = [];

    /**
     * @var Element
     */
    protected $openedElement;

    /**
     * Idg constructor.
     * @param integer $width
     * @param integer $maxHeight
     * @param integer $minHeight
     * @param ImagickPixel $background
     * @param string $type
     * @throws \ImagickException
     */
    public function __construct($width, $maxHeight, $minHeight = null, $background = null, $type = 'png')
    {
        $this->width = $width;
        $this->minHeight = $minHeight;
        $this->canvas = new Imagick();
        $background = $background ? $background : new ImagickPixel('white');
        $this->canvas->newImage($this->width, $maxHeight, $background, $type);
    }

    /**
     * Composing image
     * @throws StructureException
     */
    public function compose()
    {
        if ($this->openedElement) {
            throw new StructureException('Element not closed');
        }

        if (empty($this->elements)) {
            throw new StructureException('Nothing to compose');
        }

        /**
         * Prepare element for render
         */
        foreach ($this->elements as $element) {
            $element->beforeRender();
        }

        /**
         * Rendering all elements by order
         */
        foreach ($this->elements as $element) {
            $element->render();
        }

        /**
         * After render all elements
         */
        foreach ($this->elements as $element) {
            $element->afterRender();
        }
    }

    /**
     * Begin document
     * @param int $marginTop
     * @param int $marginLeft
     * @param int $marginBottom
     * @param int $marginRight
     * @return Element
     * @throws StructureException
     */
    public function beginDocument($marginTop = 0, $marginLeft = 0, $marginBottom = 0, $marginRight = 0)
    {
        if (!empty($this->elements)) {
            throw new StructureException('Document must be first element');
        }

        $document = new Document();
        $document->setTop($marginTop)->setLeft($marginLeft)->setPaddingBottom($marginBottom);
        $document->setWidth($this->width - ($marginLeft + $marginRight));
        return $this->beginElement($document);
    }

    /**
     * End document
     * @throws StructureException
     */
    public function endDocument()
    {
        $this->endElement();
    }

    /**
     * Begin relative block
     * @return Element
     * @throws StructureException
     */
    public function beginBlock()
    {
        $element = new Block();
        return $this->beginElement($element);
    }

    /**
     * End block
     * @throws StructureException
     */
    public function endBlock()
    {
        $this->endElement();
    }

    /**
     * Begin absolute block
     * @param int|\Closure $top
     * @param int|\Closure $left
     * @return Element
     * @throws StructureException
     */
    public function beginAbsoluteBlock($top, $left)
    {
        $element = new AbsoluteBlock();
        $element->setTop($top)->setLeft($left);
        return $this->beginElement($element);
    }

    /**
     * End block
     * @throws StructureException
     */
    public function endAbsoluteBlock()
    {
        $this->endElement();
    }

    /**
     * Begin row
     * @return Element
     * @throws StructureException
     */
    public function beginRow()
    {
        $element = new Row();
        return $this->beginElement($element);
    }

    /**
     * End row
     * @throws StructureException
     */
    public function endRow()
    {
        $this->endElement();
    }

    /**
     * Begin column
     * @param integer $width
     * @return Element
     * @throws StructureException
     */
    public function beginColumn($width)
    {
        if (!$this->openedElement instanceof Row) {
            throw new StructureException('Column must be in Row');
        }

        /** @var Column $element */
        $element = new Column();
        $element->setWidth($width);
        return $this->beginElement($element);
    }

    /**
     * End column
     * @throws StructureException
     */
    public function endColumn()
    {
        $this->endElement();
    }


    /**
     * Begin element by class
     * @param Element $element
     * @return Element
     * @throws StructureException
     */
    public function beginElement(Element $element)
    {
        if (empty($this->elements) && !($element instanceof Document)) {
            throw new StructureException('Document must be first element');
        }

        $this->addElement($element);
        $this->openedElement = $element;
        return $element;
    }

    /**
     * End element
     * @throws StructureException
     */
    public function endElement()
    {
        if (!$this->openedElement) {
            throw new StructureException('No element for close');
        }

        $this->openedElement = $this->openedElement->getParent();
    }

    /**
     * Adding text
     * @param string $content
     * @return Text
     */
    public function text($content)
    {
        $element = new Text();
        // removing \n\r
        $content = preg_replace("/\r\n|\r|\n|/",'', $content);
        // removing multi spaces
        $content = preg_replace("/\s+/",' ', $content);
        $element->setContent($content);

        /** @var Text $text */
        $text = $this->addElement($element);

        return $text;
    }

    /**
     * Adding image
     * @param string $file
     * @param bool $fromBlob
     * @return Image
     */
    public function image($file, $fromBlob = false)
    {
        $element = new Image();
        $element->setFile($file);
        $element->setFromBlob($fromBlob);

        /** @var Image $image */
        $image = $this->addElement($element);

        return $image;
    }

    /**
     * @param Element $element
     * @return Element
     */
    public function addElement(Element $element)
    {
        $element->setIdg($this);
        if ($this->openedElement) {
            $element->setParent($this->openedElement);
        }
        $this->elements[] = $element;
        return $element;
    }

    /**
     * Getting document element
     * @return Document
     * @throws StructureException
     */
    public function getDocument()
    {
        $element = isset($this->elements[0]) ? $this->elements[0] : null;
        if (!$element || !($element instanceof Document)) {
            throw new StructureException('First element must be Document');
        }
        return $element;
    }

    /**
     * @return Imagick
     */
    public function getCanvas()
    {
        return $this->canvas;
    }

    /**
     * @return Elements\Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Return image blob
     * @return string
     *
     * @throws StructureException
     */
    public function getImageBlob()
    {
        $document = $this->getDocument();
        $height = $document->getHeight();
        if ($height < $this->minHeight) {
            $height = $this->minHeight;
        }
        $this->canvas->cropImage($this->width, $height, 0, 0);

        return $this->canvas->getImageBlob();
    }
}
