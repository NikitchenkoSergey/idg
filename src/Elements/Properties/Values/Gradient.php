<?php
namespace Idg\Elements\Properties\Values;

use Idg\Exceptions\ValueException;

class Gradient extends Value
{
    /**
     * Types
     */
    const TYPE_LINEAR = 'gradient';
    const TYPE_RADIAL = 'radial-gradient';

    /**
     * @var string
     */
    protected $beginColor;

    /**
     * @var string
     */
    protected $endColor;

    /**
     * @var string
     */
    protected $type = self::TYPE_LINEAR;

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_LINEAR,
            self::TYPE_RADIAL,
        ];
    }

    /**
     * Gradient constructor.
     * @param $beginColor
     * @param $endColor
     * @param string $type
     * @throws ValueException
     */
    public function __construct($beginColor, $endColor, $type = self::TYPE_LINEAR)
    {
        if (!in_array($type, self::getTypes())) {
            throw new ValueException('Invalid gradient type');
        }

        $this->beginColor = $beginColor;
        $this->endColor = $endColor;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getPseudoString()
    {
        return "{$this->type}:{$this->beginColor}-{$this->endColor}";
    }
}