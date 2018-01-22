<?php

namespace Idg\Elements\Properties;

/**
 * Trait Padding
 * @package Idg\Elements\Properties
 *
 * @property integer $paddingTop
 * @property integer $paddingLeft
 * @property integer $paddingRight
 * @property integer $paddingBottom
 *
 */
trait Padding {

    /**
     * @var integer
     */
    protected $_paddingTop = 0;

    /**
     * @var integer
     */
    protected $_paddingLeft = 0;

    /**
     * @var integer
     */
    protected $_paddingRight = 0;

    /**
     * @var integer
     */
    protected $_paddingBottom = 0;

    /**
     * Setting padding top
     * @param int $value
     * @return $this
     */
    public function setPaddingTop($value)
    {
        $this->paddingTop = $value;
        return $this;
    }

    /**
     * Setting padding bottom
     * @param int $value
     * @return $this
     */
    public function setPaddingLeft($value)
    {
        $this->paddingLeft = $value;
        return $this;
    }

    /**
     * Setting padding right
     * @param int $value
     * @return $this
     */
    public function setPaddingRight($value)
    {
        $this->paddingRight = $value;
        return $this;
    }

    /**
     * Setting padding bottom
     * @param int $value
     * @return $this
     */
    public function setPaddingBottom($value)
    {
        $this->paddingBottom = $value;
        return $this;
    }

    /**
     * Setting padding like css
     * @param int $top
     * @param int $right
     * @param int $bottom
     * @param int $left
     * @return $this
     */
    public function setPadding($top, $right, $bottom, $left)
    {
        $this->paddingTop = $top;
        $this->paddingRight = $right;
        $this->paddingLeft = $left;
        $this->paddingBottom = $bottom;
        return $this;
    }
}
