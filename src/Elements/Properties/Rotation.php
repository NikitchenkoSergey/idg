<?php

namespace Idg\Elements\Properties;

use Idg\Elements\Element;

/**
 * Trait Rotation
 * @package Idg\Elements\Properties
 * @property integer $rotation
 */
trait Rotation {

    /**
     * @var integer
     */
    protected $_rotation = 0;


    /**
     * Setting rotation
     * @param int|\Closure $value
     * @return $this
     */
    public function setRotation($value)
    {
        $this->rotation = $value;
        return $this;
    }

    /**
     * Get result rotation
     * @return int
     */
    public function getRotation()
    {
        /** @var $this Element */

        $rotation = $this->rotation;
        if ($this->parent instanceof Element) {
            $rotation += $this->parent->getRotation();
        }

        return $rotation;
    }
}
