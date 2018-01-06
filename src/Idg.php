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
use Idg\Exceptions\Exception;
use Imagick;
use ImagickPixel;
use ImagickDraw;

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
     * @throws Exception
     */
    public function compose()
    {
        if ($this->openedElement) {
            throw new Exception('Element not closed');
        }

        if (empty($this->elements)) {
            throw new Exception('Nothing to compose');
        }

        /**
         * Rendering all elements by order
         */
        foreach ($this->elements as $element) {
            $element->render();
        }

        /**
         * After render all elements
         * when all has height and width
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
     */
    public function beginDocument($marginTop = 0, $marginLeft = 0, $marginBottom = 0, $marginRight = 0)
    {
        $document = new Document();
        $document->top = $marginTop;
        $document->left = $marginLeft;
        $document->bottomMargin = $marginBottom;
        $document->width = $this->width - ($marginLeft + $marginRight);
        $this->beginElement($document);
    }

    /**
     * End document
     */
    public function endDocument()
    {
        $this->endElement();
    }

    /**
     * Begin relative block
     * @param null $top
     * @param null $left
     * @param null $width
     * @param null $height
     */
    public function beginBlock($top = null, $left = null, $width = null, $height = null)
    {
        $element = new Block();
        $element->width = $width;
        $element->staticHeight = $height;
        $element->top = $top;
        $element->left = $left;
        $this->beginElement($element);
    }

    /**
     * End block
     */
    public function endBlock()
    {
        $this->endElement();
    }

    /**
     * Begin absolute block
     * @param null $top
     * @param null $left
     * @param null $width
     * @param null $height
     */
    public function beginAbsoluteBlock($top, $left, $width = null, $height = null)
    {
        $element = new AbsoluteBlock();
        $element->width = $width;
        $element->staticHeight = $height;
        $element->top = $top;
        $element->left = $left;
        $this->beginElement($element);
    }

    /**
     * End block
     */
    public function endAbsoluteBlock()
    {
        $this->endElement();
    }

    /**
     * Begin row
     * @param null $top
     * @param null $left
     * @param null $width
     * @param null $height
     */
    public function beginRow($top = null, $left = null, $width = null, $height = null)
    {
        $element = new Row();
        $element->width = $width;
        $element->staticHeight = $height;
        $element->top = $top;
        $element->left = $left;
        $this->beginElement($element);
    }

    /**
     * End row
     */
    public function endRow()
    {
        $this->endElement();
    }

    /**
     * Begin column
     * @param integer $width
     * @throws Exception
     */
    public function beginColumn($width)
    {
        if (!$this->openedElement instanceof Row) {
            throw new Exception('Column must be in Row');
        }

        /** @var Column $element */
        $element = new Column();
        $element->width = $width;
        $this->beginElement($element);
    }

    /**
     * End column
     */
    public function endColumn()
    {
        $this->endElement();
    }


    /**
     * Begin element by class
     * @param Element $element
     */
    public function beginElement(Element $element)
    {
        $this->addElement($element);
        $this->openedElement = $element;
    }

    /**
     * End element
     */
    public function endElement()
    {
        $this->openedElement = $this->openedElement->getParent();
    }

    /**
     * Adding text
     * @param string $content
     * @param string $font
     * @param int $fontSize
     * @param string $textColor
     * @param int $align
     */
    public function text($content, $font, $fontSize = 16, $textColor = 'black', $align = Imagick::ALIGN_LEFT)
    {
        $element = new Text();
        // removing \n\r
        $content = preg_replace("/\r\n|\r|\n|/",'', $content);
        // removing multi spaces
        $content = preg_replace("/\s+/",' ', $content);
        $element->content = $content;
        $element->align = $align;

        // text style
        $textDraw = new ImagickDraw();
        $textDraw->setFillColor(new ImagickPixel($textColor));
        $textDraw->setFontSize($fontSize);
        $textDraw->setStrokeAntialias(true);
        $textDraw->setTextAntialias(true);
        $textDraw->setTextAlignment($align);
        $textDraw->setFont($font);

        $element->fontStyle = $textDraw;

        $this->addElement($element);
    }

    /**
     * Adding image
     * @param int $top
     * @param int $left
     * @param string $file
     * @param bool $fromBlob
     */
    public function image($top, $left, $file, $fromBlob = false)
    {
        $element = new Image();
        $element->top = $top;
        $element->left = $left;
        $element->file = $file;
        $element->fromBlob = $fromBlob;
        $this->addElement($element);
    }

    /**
     * @param Element $element
     */
    public function addElement(Element $element)
    {
        $element->setIdg($this);
        if ($this->openedElement) {
            $element->setParent($this->openedElement);
        }
        $this->elements[] = $element;
    }

    /**
     * Getting documwnt element
     * @return Document
     * @throws Exception
     */
    public function getDocument()
    {
        $element = isset($this->elements[0]) ? $this->elements[0] : null;
        if (!$element || !($element instanceof Document)) {
            throw new Exception('First element must be Document');
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
     */
    public function getImageBlob()
    {
        $document = $this->getDocument();
        $height = $document->getHeight() + $document->bottomMargin;
        if ($height < $this->minHeight) {
            $height = $this->minHeight;
        }
        $this->canvas->cropImage($this->width, $height, 0, 0);

        return $this->canvas->getImageBlob();
    }
}