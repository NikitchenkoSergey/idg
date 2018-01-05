<?php

namespace Idg\Elements;


class AbsoluteBlock extends Element
{
    /**
     * @inheritdoc
     */
    public function getHeight()
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getTop()
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getLeft()
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
}