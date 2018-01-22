<?php

namespace Idg\Elements;

use ImagickDraw;
use Imagick;

/**
 * Class Text
 * @package Idg\Elements
 */
class Text extends Element
{
    /**
     * @var string
     */
    protected $content;
    /**
     * @var \ImagickDraw
     */
    protected $fontStyle;

    /**
     * @var int
     */
    protected $angle = 0;

    /**
     * @var int
     */
    protected $align = Imagick::ALIGN_LEFT;

    /**
     * @var string
     */
    protected $font;

    /**
     * @var int
     */
    protected $fontSize = 16;

    /**
     * @var string
     */
    protected $textColor = 'black';

    /**
     * @var int
     */
    protected $decoration = Imagick::DECORATION_NO;


    /**
     * @inheritdoc
     */
    public function beforeRender()
    {
        parent::beforeRender();

        $fontStyle = $this->getDraw();
        $lines = $this->getTextRows();

        $textHeight = 0;
        foreach ($lines as $line) {
            $draw = clone $fontStyle;
            $metrics = $this->getIdg()->getCanvas()->queryFontMetrics($draw, $line, false);
            $textLineHeight = $metrics['textHeight'];
            $textLineWidth = $metrics['textWidth'];
            $textHeight += $textLineHeight;

        }
        $this->increaseHeight($textHeight);
    }

    /**
     * Render text
     */
    public function render()
    {
        parent::render();

        $fontStyle = $this->getDraw();
        $lines = $this->getTextRows();

        $textHeight = 0;

        foreach ($lines as $line) {
            $draw = clone $fontStyle;
            $metrics = $this->getIdg()->getCanvas()->queryFontMetrics($draw, $line, false);
            $textLineHeight = $metrics['textHeight'];
            $textLineWidth = $metrics['textWidth'];
            $leftOffset = $this->getLeftOffset();
            if ($this->align == Imagick::ALIGN_RIGHT) {
                $leftOffset = $this->getLeftOffset() + $this->getWidth();
            } elseif ($this->align == Imagick::ALIGN_CENTER) {
                $leftOffset = $this->getLeftOffset() + ($this->getWidth() / 2);
            }

            $textHeight += $textLineHeight;
            $draw->annotation($leftOffset, $this->getTopOffset() + $textHeight, $line);


            $this->getIdg()->getCanvas()->drawImage($draw);
        }
    }

    /**
     * Getting font style
     * @return ImagickDraw
     */
    protected function getDraw()
    {
        if ($this->fontStyle instanceof \ImagickDraw) {
            return $this->fontStyle;
        }

        $rotation = $this->getRotation() + $this->angle;

        $textDraw = new ImagickDraw();
        $textDraw->setFillColor(new \ImagickPixel($this->textColor));
        $textDraw->setFontSize($this->fontSize);
        $textDraw->setStrokeAntialias(true);
        $textDraw->setTextAntialias(true);
        $textDraw->setTextAlignment($this->align);
        $textDraw->setTextDecoration($this->decoration);
        if ($this->font) {
            $textDraw->setFont($this->font);
        }

        if ($rotation) {
            $textDraw->rotate($rotation);
        }

        return $textDraw;
    }


    /**
     * Explode text by lines for width
     * @return array
     */
    protected function getTextRows()
    {
        $fontStyle = $this->getDraw();
        $words = explode(' ', $this->content);
        $lines = array();
        $i = 0;
        while ($i < count($words)) {
            $line = '';
            do {
                if($line != '') {
                    $line .= ' ';
                }

                $line .= $words[$i];

                $i++;
                if($i == count($words)) {
                    break;
                }

                $linePreview = $line . ' ' . $words[$i];
                $metrics = $this->getIdg()->getCanvas()->queryFontMetrics($fontStyle, $linePreview);

            } while($metrics['textWidth'] <= $this->getWidth());

            $lines[] = $line;
        }

        return $lines;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setAlign($value)
    {
        $this->align = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDecoration($value)
    {
        $this->decoration = $value;
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setAngle($value)
    {
        $this->angle = $value;
        return $this;
    }

    /**
     * @param ImagickDraw $draw
     * @return $this
     */
    public function setFontStyle(\ImagickDraw $draw)
    {
        $this->fontStyle = $draw;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setFontSize($value)
    {
        $this->fontSize = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setFont($value)
    {
        $this->font = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTextColor($value)
    {
        $this->textColor = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setContent($value)
    {
        $this->content = $value;
        return $this;
    }
}
