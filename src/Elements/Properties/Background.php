<?php

namespace Idg\Elements\Properties;

use Idg\Elements\Element;
use Idg\Elements\Properties\Values\Gradient;
use Idg\Idg;
use Imagick;

/**
 * Trait Background
 * @property float $backgroundOpacity
 * @property string|Gradient $backgroundColor
 * @package Idg\Elements\Properties
 */
trait Background {

    /**
     * @var integer
     */
    protected $_backgroundOpacity = 1;

    /**
     * @var string
     */
    protected $_backgroundColor;

    /**
     * Setting background color
     * @param string|Gradient|\Closure $value
     * @return $this
     */
    public function setBackgroundColor($value)
    {
        $this->backgroundColor = $value;
        return $this;
    }

    /**
     * Setting background opacity
     * @param int|\Closure $value
     * @return $this
     */
    public function setBackgroundOpacity($value)
    {
        $this->backgroundOpacity = $value;
        return $this;
    }


    /**
     * Setting background
     * @param string|Gradient|\Closure $color
     * @param int|\Closure $opacity
     * @return $this
     */
    public function setBackground($color, $opacity = 1)
    {
        $this->backgroundOpacity = $opacity;
        $this->backgroundColor = $color;
        return $this;
    }

    /**
     * Rendering background
     * @return bool
     *
     * @throws \ImagickException
     */
    public function renderBackground()
    {
        /** @var $this Element */

        if (!$this->backgroundColor) {
            return false;
        }

        /** @var Idg $idg */
        $idg = $this->getIdg();

        if ($this->backgroundColor instanceof Gradient) {
            $gradient = new Imagick();
            $gradient->newPseudoImage($this->getWidth(), $this->getHeight(), $this->backgroundColor->getPseudoString());
            $rotation = $this->getRotation();
            if ($rotation) {
                $gradient->rotateImage('transparent', $rotation);
            }
            $gradient->setImageOpacity($this->backgroundOpacity);

            $idg->getCanvas()->compositeImage($gradient, Imagick::COMPOSITE_DEFAULT, $this->getLeftOffset(), $this->getTopOffset());
        } else {
            $draw = new \ImagickDraw();
            $fillColor = new \ImagickPixel($this->backgroundColor);

            $draw->setFillColor($fillColor);
            $draw->setFillOpacity($this->backgroundOpacity);

            $rotation = $this->getRotation();
            if ($rotation) {
                $draw->rotate($rotation);
            }

            $draw->rectangle($this->getLeftOffset(), $this->getTopOffset(), $this->getLeftOffset() + $this->getWidth(), $this->getTopOffset() + $this->getHeight());
            $idg->getCanvas()->drawImage($draw);
        }
    }
}
