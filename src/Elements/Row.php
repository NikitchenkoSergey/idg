<?php

namespace Idg\Elements;


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
                $columnHeight = 0;
                $columnHeight += $child->getTop();
                $columnHeight += $child->getHeight();
                if ($columnHeight > $maxHeight) {
                    $maxHeight = $columnHeight;
                }
            }
            $height = $maxHeight;
        }

        return $height;
    }
}