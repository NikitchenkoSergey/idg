<?php

namespace Idg\Elements;
use Imagick;

/**
 * Class Image
 * @package Idg\Elements
 */
class Image extends Element
{
    /**
     * @var string
     */
    public $file;

    /**
     * @var boolean
     */
    public $fromBlob;


    /**
     * Render image
     */
    public function render()
    {
        $image = new Imagick();
        if ($this->fromBlob) {
            $image->readImageBlob($this->file);
        } else {
            $image->readImage($this->file);
        }

        $imageWidth = $image->getImageWidth();
        $imageHeight = $image->getImageHeight();

        $this->getIdg()->getCanvas()->compositeImage($image, Imagick::COMPOSITE_OVER,
            $this->getLeftOffset() + $this->paddingLeft,
            $this->getTopOffset() + $this->paddingTop
        );
        $this->increaseHeight($imageHeight);
    }
}