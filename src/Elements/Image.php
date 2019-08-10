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
    protected $file;

    /**
     * @var boolean
     */
    protected $fromBlob;


    /**
     * @var Imagick
     */
    protected $image;

    /**
     * @inheritdoc
     *
     * @throws \ImagickException
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

        $rotation = $this->getRotation();
        if ($rotation) {
            $image->rotateImage('transparent', $rotation);
        }

        $imageWidth = $image->getImageWidth();
        $imageHeight = $image->getImageHeight();

        $this->increaseHeight($imageHeight);
        $this->increaseWidth($imageWidth);

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

    /**
     * @param $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setFromBlob($value)
    {
        $this->fromBlob = $value;
        return $this;
    }
}
