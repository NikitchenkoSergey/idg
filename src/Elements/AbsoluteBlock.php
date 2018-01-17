<?php

namespace Idg\Elements;

/**
 * Class AbsoluteBlock
 * @package Idg\Elements
 */
class AbsoluteBlock extends Element
{
    /**
     * Absolute block don`t increase document height
     * @inheritdoc
     */
    public function getOuterHeight()
    {
        return 0;
    }

    /**
     * Get left offset
     * @return int
     */
    public function getLeftOffset()
    {
        return $this->left;
    }

    /**
     * Get top offset
     * @return int
     */
    public function getTopOffset()
    {
        return $this->top;
    }

    /**
     * @inheritdoc
     */
    public function getWidth()
    {
        $result = $this->width;
        if (!$result && $this->parent) {
            $result = $this->parent->getWidth();
            $result -= $this->parent->paddingLeft;
            $result -= $this->parent->paddingRight;
        }

        $result -= $this->marginLeft + $this->marginRight;

        return $result;
    }
}
