<?php

namespace Idg\Elements\Properties;

use Idg\Elements\Element;
use Idg\Idg;

/**
 * Trait Border
 * @property integer $borderWidth
 * @property string $borderColor
 * @property float $borderOpacity
 * @package Idg\Elements\Properties
 */
trait Border {

    /**
     * @var integer
     */
    protected $_borderWidth = 0;

    /**
     * @var string
     */
    protected $_borderColor = 'black';

    /**
     * @var int
     */
    protected $_borderOpacity = 1;

    /**
     * Setting border color
     * @param int|\Closure $value
     * @return $this
     */
    public function setBorderColor($value)
    {
        $this->borderColor = $value;
        return $this;
    }

    /**
     * Setting border color
     * @param int|\Closure $value
     * @return $this
     */
    public function setBorderWidth($value)
    {
        $this->borderWidth = $value;
        return $this;
    }

    /**
     * Setting border opacity
     * @param int|\Closure $value
     * @return $this
     */
    public function setBorderOpacity($value)
    {
        $this->borderOpacity = $value;
        return $this;
    }


    /**
     * Setting border
     * @param int|\Closure $width
     * @param string|\Closure $color
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

        $rotation = $this->getRotation();
        if ($rotation) {
            $draw->rotate($rotation);
        }

        $draw->rectangle($this->getLeftOffset(), $this->getTopOffset(), $this->getLeftOffset() + $this->getWidth(), $this->getTopOffset() + $this->getHeight());
        /** @var Idg $idg */
        $idg = $this->getIdg();
        $idg->getCanvas()->drawImage($draw);
    }
}
