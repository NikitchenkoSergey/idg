<?php
/**
 * Border trait
 */

namespace Idg\Elements\Properties;

use Idg\Elements\Element;

trait Border {

    /**
     * @var integer
     */
    public $borderWidth = 0;

    /**
     * @var string
     */
    public $borderColor = 'black';

    /**
     * @var int
     */
    public $borderOpacity = 1;

    /**
     * Setting border color
     * @param int $value
     * @return $this
     */
    public function setBorderColor($value)
    {
        $this->borderColor = $value;
        return $this;
    }

    /**
     * Setting border color
     * @param int $value
     * @return $this
     */
    public function setBorderWidth($value)
    {
        $this->borderWidth = $value;
        return $this;
    }

    /**
     * Setting border opacity
     * @param int $value
     * @return $this
     */
    public function setBorderOpacity($value)
    {
        $this->borderOpacity = $value;
        return $this;
    }


    /**
     * Setting border
     * @param $width
     * @param $color
     * @return $this
     */
    public function setBorder($width, $color)
    {
        $this->borderWidth = $width;
        $this->borderColor = $color;
        return $this;
    }

    /**
     * Rendfering border
     * @return bool
     */
    public function renderBorder()
    {
        /** @var $this Element */

        if ($this->borderWidth <= 0) {
            return false;
        }

        $draw = new \ImagickDraw();
        $strokeColor = new \ImagickPixel($this->borderColor);
        $fillColor = new \ImagickPixel('transparent');

        $draw->setStrokeColor($strokeColor);
        $draw->setFillColor($fillColor);
        $draw->setFillOpacity(0);
        $draw->setStrokeOpacity($this->borderOpacity);
        $draw->setStrokeWidth($this->borderWidth);

        $draw->rectangle($this->getLeftOffset(), $this->getTopOffset(), $this->getLeftOffset() + $this->getWidth(), $this->getTopOffset() + $this->getHeight());
        $this->getIdg()->getCanvas()->drawImage($draw);
    }
}