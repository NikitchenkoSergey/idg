<?php

namespace Idg\Elements;

/**
 * Class Document
 * @package Idg\Elements
 */
class Document extends Element
{
    /**
     * @return int
     */
    public function getHeight()
    {
        $height = parent::getHeight();
        $height += $this->getTop();
        return $height;
    }
}