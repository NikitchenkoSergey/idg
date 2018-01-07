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
    public $content;
    /**
     * @var \ImagickDraw
     */
    public $fontStyle;

    /**
     * @var int
     */
    public $angle = 0;

    /**
     * @var int
     */
    public $align = Imagick::ALIGN_LEFT;


    /**
     * Render text
     */
    public function render()
    {
        $lines = $this->getTextRows();

        $textHeight = 0;
        foreach ($lines as $line) {
            $draw = clone $this->fontStyle;
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
            $this->getIdg()->getCanvas()->annotateImage($draw, $leftOffset, $this->getTopOffset() + $textHeight, $this->angle, $line);
        }
        $this->increaseHeight($textHeight);
    }


    /**
     * Explode text by lines for width
     * @return array
     */
    protected function getTextRows()
    {
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
                $metrics = $this->getIdg()->getCanvas()->queryFontMetrics($this->fontStyle, $linePreview);

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
}