<?php
/**
 * Background trait
 */

namespace Idg\Elements\Properties;

use Idg\Elements\Element;

trait Background {

    /**
     * @var integer
     */
    public $backgroundOpacity = 1;

    /**
     * @var string
     */
    public $backgroundColor;

    /**
     * Setting background color
     * @param int $value
     * @return $this
     */
    public function setBackgroundColor($value)
    {
        $this->backgroundColor = $value;
        return $this;
    }

    /**
     * Setting background opacity
     * @param int $value
     * @return $this
     */
    public function setBackgroundOpacity($value)
    {
        $this->backgroundOpacity = $value;
        return $this;
    }


    /**
     * Setting background
     * @param $opacity
     * @param $color
     * @return $this
     */
    public function setBackground($color, $opacity)
    {
        $this->backgroundOpacity = $opacity;
        $this->backgroundColor = $color;
        return $this;
    }

    /**
     * Rendering background
     * @return bool
     */
    public function renderBackground()
    {
        /** @var $this Element */

        if (!$this->backgroundColor) {
            return false;
        }

        $draw = new \ImagickDraw();
        $fillColor = new \ImagickPixel($this->backgroundColor);

        $draw->setFillColor($fillColor);
        $draw->setFillOpacity($this->backgroundOpacity);

        $rotation = $this->getRotation();
        if ($rotation) {
            $draw->rotate($rotation);
        }

        $draw->rectangle($this->getLeftOffset(), $this->getTopOffset(), $this->getLeftOffset() + $this->getWidth(), $this->getTopOffset() + $this->getHeight());
        $this->getIdg()->getCanvas()->drawImage($draw);
    }
}
