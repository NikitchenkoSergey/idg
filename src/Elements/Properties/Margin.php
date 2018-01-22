<?php

namespace Idg\Elements\Properties;

/**
 * Trait Margin
 * @package Idg\Elements\Properties
 *
 * @property integer $marginTop
 * @property integer $marginLeft
 * @property integer $marginRight
 * @property integer $marginBottom
 *
 */
trait Margin {

    /**
     * @var integer
     */
    protected $_marginTop = 0;

    /**
     * @var integer
     */
    protected $_marginLeft = 0;

    /**
     * @var integer
     */
    protected $_marginRight = 0;

    /**
     * @var integer
     */
    protected $_marginBottom = 0;

    /**
     * Setting margin top
     * @param int $value
     * @return $this
     */
    public function setMarginTop($value)
    {
        $this->marginTop = $value;
        return $this;
    }

    /**
     * Setting margin bottom
     * @param int|\Closure $value
     * @return $this
     */
    public function setMarginLeft($value)
    {
        $this->marginLeft = $value;
        return $this;
    }

    /**
     * Setting margin right
     * @param int|\Closure $value
     * @return $this
     */
    public function setMarginRight($value)
    {
        $this->marginRight = $value;
        return $this;
    }

    /**
     * Setting margin bottom
     * @param int|\Closure $value
     * @return $this
     */
    public function setMarginBottom($value)
    {
        $this->marginBottom = $value;
        return $this;
    }

    /**
     * Setting margin like css
     * @param int|\Closure $top
     * @param int|\Closure $right
     * @param int|\Closure $bottom
     * @param int|\Closure $left
     * @return $this
     */
    public function setMargin($top, $right, $bottom, $left)
    {
        $this->marginTop = $top;
        $this->marginRight = $right;
        $this->marginLeft = $left;
        $this->marginBottom = $bottom;
        return $this;
    }
}
