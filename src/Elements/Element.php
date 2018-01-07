<?php

namespace Idg\Elements;

use Idg\Idg;

/**
 * Class Element
 * @package Idg\Elements
 */
class Element
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var Idg
     */
    protected $idg;

    /**
     * @var Element
     */
    protected $parent;

    /**
     * @var integer
     */
    public $top;

    /**
     * @var integer
     */
    public $left;

    /**
     * @var integer
     */
    public $width;

    /**
     * @var integer
     */
    public $height;

    /**
     * @var integer
     */
    public $staticHeight;

    /**
     * @var integer
     */
    public $paddingBottom;

    /**
     * @var \Closure
     */
    public $afterRender;

    /**
     * @param Element $element
     */
    public function setParent(Element $element)
    {
        $this->parent = $element;
    }

    /**
     * @param Idg $idg
     */
    public function setIdg(Idg $idg)
    {
        $this->idg = $idg;
    }

    /**
     * @return Element
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return Idg
     */
    public function getIdg()
    {
        return $this->idg;
    }

    /**
     * Get width or parent width
     * @return int
     */
    public function getWidth()
    {
        $result = $this->width;
        if (!$result && $this->parent) {
            $result = $this->parent->getWidth();
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->left ? $this->left : 0;
    }

    /**
     * Get left offset
     * @return int
     */
    public function getLeftOffset()
    {
        $result = $this->getLeft();
        if ($this->parent) {
            $result += $this->parent->getLeftOffset();
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getTop()
    {
        return $this->top ? $this->top : 0;
    }

    /**
     * @return int
     */
    public function getTopOffset()
    {
        $result = $this->getTop();
        $prevSibling = $this->getPrevSibling();
        if ($prevSibling) {
            $result += $prevSibling->getTopOffset();
            $result += $prevSibling->getHeight();
        } elseif ($this->parent) {
            $result += $this->parent->getTopOffset();
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        $height = $this->height ? $this->height : 0;
        $height = $this->staticHeight ? $this->staticHeight : $height;
        if (!$height) {
            /** @var Element[] $children */
            $children = $this->getChildren();
            foreach ($children as $child) {
                $height += $child->getOuterHeight();
            }
        }

        $height += $this->paddingBottom;

        return $height;
    }

    /**
     * height in document
     * @return int
     */
    public function getOuterHeight()
    {
        return $this->getTop() + $this->getHeight();
    }

    /**
     * Increase height
     * @param $value
     */
    public function increaseHeight($value)
    {
        $this->height = ($this->height ? $this->height : 0) + $value;
    }

    /**
     * Element constructor.
     */
    public function __construct()
    {
        $this->id = uniqid('id_', true);
    }

    /**
     * Children of element
     * @return Element[]
     */
    public function getChildren()
    {
        $elements = $this->idg->getElements();
        if (empty($elements)) {
            return [];
        }
        $currentId = $this->id;
        $result = array_filter($elements, function(Element $element) use ($currentId) {
            return $element->parent && $element->parent->id === $currentId;
        });

        return $result;
    }

    /**
     * Siblings of element
     * with current element
     * @return Element[]
     */
    public function getSiblings()
    {
        $elements = $this->idg->getElements();
        if (empty($elements) || !$this->parent) {
            return [];
        }
        $parentId = $this->parent->id;
        $result = array_filter($elements, function(Element $element) use ($parentId) {
            return $element->parent && $element->parent->id === $parentId;
        });

        return $result;
    }

    /**
     * Prev sibling
     * @return Element|null
     */
    public function getPrevSibling()
    {
        $result = null;
        $siblings = $this->getSiblings();
        if (empty($siblings)) {
            return $result;
        }

        foreach ($siblings as $sibling) {
            // current element
            if ($sibling->id === $this->id) {
                break;
            }
            $result = $sibling;
        }

        return $result;
    }

    /**
     * Prev siblings
     * @return Element[]
     */
    public function getPrevSiblings()
    {
        $result = [];
        $siblings = $this->getSiblings();
        if (empty($siblings)) {
            return $result;
        }

        foreach ($siblings as $sibling) {
            // current element
            if ($sibling->id === $this->id) {
                break;
            }
            $result[] = $sibling;
        }

        return $result;
    }


    /**
     * Before rendering
     */
    public function beforeRender()
    {

    }

    /**
     * Rendering element
     */
    public function render()
    {

    }

    /**
     * After rendering element
     * when all elements has height and width
     */
    public function afterRender()
    {
        if (is_object($this->afterRender) && $this->afterRender instanceof \Closure) {
            $closure = $this->afterRender;
            $closure($this);
        }
    }

    /**
     * Setting top
     * @param int $value
     * @return $this
     */
    public function setTop($value)
    {
        $this->top = $value;
        return $this;
    }

    /**
     * Setting left
     * @param int $value
     * @return $this
     */
    public function setLeft($value)
    {
        $this->left = $value;
        return $this;
    }

    /**
     * Setting width
     * @param int $value
     * @return $this
     */
    public function setWidth($value)
    {
        $this->width = $value;
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
     * Setting static height
     * @param int $value
     * @return $this
     */
    public function setStaticHeight($value)
    {
        $this->staticHeight = $value;
        return $this;
    }

    /**
     * Setting after render function
     * @param \Closure $closure
     * @return $this
     */
    public function setAfterRender(\Closure $closure)
    {
        $this->afterRender = $closure;
        return $this;
    }
}