<?php

namespace Idg\Elements;

/**
 * Class Row
 * @package Idg\Elements
 */
class Row extends Element
{
    /**
     * Max column height
     * @return int
     */
    public function getHeight()
    {
        $height = $this->staticHeight ? $this->staticHeight : 0;
        if (!$height) {
            /** @var Element[] $children */
            $children = $this->getChildren();
            $maxHeight = 0;
            foreach ($children as $child) {
                $columnHeight = $child->getOuterHeight();
                if ($columnHeight > $maxHeight) {
                    $maxHeight = $columnHeight;
                }
            }
            $height = $maxHeight;

            $height += $this->paddingBottom;
        }

        return $height;
    }
}