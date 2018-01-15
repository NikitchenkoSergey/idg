<?php
/**
 * Margin trait
 */

namespace Idg\Elements\Properties;

trait Margin {

    /**
     * @var integer
     */
    public $marginTop = 0;

    /**
     * @var integer
     */
    public $marginLeft = 0;

    /**
     * @var integer
     */
    public $marginRight = 0;

    /**
     * @var integer
     */
    public $marginBottom = 0;

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
     * @param int $value
     * @return $this
     */
    public function setMarginLeft($value)
    {
        $this->marginLeft = $value;
        return $this;
    }

    /**
     * Setting margin right
     * @param int $value
     * @return $this
     */
    public function setMarginRight($value)
    {
        $this->marginRight = $value;
        return $this;
    }

    /**
     * Setting margin bottom
     * @param int $value
     * @return $this
     */
    public function setMarginBottom($value)
    {
        $this->marginBottom = $value;
        return $this;
    }

    /**
     * Setting margin like css
     * @param int $top
     * @param int $right
     * @param int $bottom
     * @param int $left
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