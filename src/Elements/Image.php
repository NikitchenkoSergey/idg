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
     * @var Imagick
     */
    protected $image;

    /**
     * @inheritdoc
     */
    public function beforeRender()
    {
        parent::beforeRender();

        $image = new Imagick();
        if ($this->fromBlob) {
            $image->readImageBlob($this->file);
        } else {
            $image->readImage($this->file);
        }

        $imageWidth = $image->getImageWidth();
        $imageHeight = $image->getImageHeight();

        $this->increaseHeight($imageHeight);

        $this->image = $image;
    }

    /**
     * Render image
     */
    public function render()
    {
        parent::render();

        $this->getIdg()->getCanvas()->compositeImage($this->image, Imagick::COMPOSITE_OVER,
            $this->getLeftOffset() + $this->paddingLeft,
            $this->getTopOffset() + $this->paddingTop
        );
    }
}