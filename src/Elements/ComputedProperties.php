<?php

namespace Idg\Elements;


use Idg\Exceptions\ValueException;

/**
 * Trait ComputedProperties
 * @package Idg\Elements
 */
trait ComputedProperties
{
    /**
     * Compute value
     * @param $value
     * @return mixed
     */
    protected function computeValue($value)
    {
        if (is_callable($value)) {
            return $value($this);
        }

        return $value;
    }

    /**
     * Getter for computed properties
     * @param $name
     * @return mixed
     * @throws ValueException
     */
    public function __get($name)
    {
        $propertyName = '_' . $name;
        if (property_exists($this, $propertyName)) {
            return $this->computeValue($this->{$propertyName});
        }
        throw new ValueException("Property {$name} not exist");
    }

    /**
     * Setter for computed  properties
     * @param $name
     * @param $value
     * @throws ValueException
     */
    public function __set($name, $value)
    {
        $propertyName = '_' . $name;
        if (property_exists($this, $propertyName)) {
            $this->{$propertyName} = $value;
        } else {
            throw new ValueException("Property {$name} not exist");
        }
    }
}
