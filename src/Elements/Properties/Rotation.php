<?php
/**
 * Rotation trait
 */

namespace Idg\Elements\Properties;

use Idg\Elements\Element;

trait Rotation {

    /**
     * @var integer
     */
    protected $rotation = 0;


    /**
     * Setting rotation
     * @param int $value
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
