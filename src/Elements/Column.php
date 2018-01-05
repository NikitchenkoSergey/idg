<?php

namespace Idg\Elements;


class Column extends Element
{
    /**
     * @return int
     */
    public function getTopOffset()
    {
        $result = $this->getTop();
        if ($this->parent) {
            $result += $this->parent->getTopOffset();
        }

        return $result;
    }

    /**
     * Get left
     * @return int
     */
    public function getLeftOffset()
    {
        $result = $this->getLeft();
        $prevSibling = $this->getPrevSibling();
        if ($prevSibling) {
            $result += $prevSibling->getLeftOffset() + $prevSibling->width;
        }
        if ($this->parent) {
            $result += $this->parent->getLeftOffset();
        }

        return $result;
    }
}