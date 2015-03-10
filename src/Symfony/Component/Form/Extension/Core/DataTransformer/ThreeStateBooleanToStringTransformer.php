<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between a Boolean and a string.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Florian Eckerstorfer <florian@eckerstorfer.org>
 */
class ThreeStateBooleanToStringTransformer implements DataTransformerInterface
{
    /**
     * The value emitted upon transform if the input is true.
     *
     * @var string
     */
    private $trueValues;

    /**
     * Sets the value emitted upon transform if the input is true.
     *
     * @param string $trueValues
     */
    public function __construct(array $trueValues = array('true'))
    {
        $this->trueValues = $trueValues;
    }

    /**
     * Transforms a Boolean into a string.
     *
     * @param bool $value Boolean value.
     *
     * @return string String value.
     *
     * @throws TransformationFailedException If the given value is not a Boolean.
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!is_bool($value)) {
            throw new TransformationFailedException('Expected a Boolean.');
        }

        return $value ? $this->trueValues[0] : false;
    }

    /**
     * Transforms a string into a Boolean.
     *
     * @param string $value String value.
     *
     * @return bool Boolean value.
     *
     * @throws TransformationFailedException If the given value is not a string.
     */
    public function reverseTransform($value)
    {
        if (in_array($value, $this->trueValues, true)) {
            return true;
        }

        if (!is_string($value)) {
            throw new TransformationFailedException('Expected a string.');
        }

        return false;
    }
}
