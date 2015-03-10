<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Tests\Extension\Core\DataTransformer;

use Symfony\Component\Form\Extension\Core\DataTransformer\ThreeStateBooleanToStringTransformer;

class ThreeStateBooleanToStringTransformerTest extends \PHPUnit_Framework_TestCase
{
    private static $TRUE_VALUES = [ '1', true, 'on', 't', 'true'];

    /**
     * @var ThreeStateBooleanToStringTransformer
     */
    protected $transformer;

    protected function setUp()
    {
        $this->transformer = new ThreeStateBooleanToStringTransformer(self::$TRUE_VALUES);
    }

    protected function tearDown()
    {
        $this->transformer = null;
    }

    public function testTransform()
    {
        $this->assertEquals(self::$TRUE_VALUES[0], $this->transformer->transform(true));
        $this->assertFalse($this->transformer->transform(false));
    }

    // https://github.com/symfony/symfony/issues/8989
    public function testTransformAcceptsNull()
    {
        $this->assertNull($this->transformer->transform(null));
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testTransformFailsIfString()
    {
        $this->transformer->transform('1');
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testReverseTransformFailsIfInteger()
    {
        $this->transformer->reverseTransform(1);
    }

    public function testReverseTransform()
    {
        foreach (self::$TRUE_VALUES as $trueValue) {
            $this->assertTrue($this->transformer->reverseTransform($trueValue));
        }
        $this->assertFalse($this->transformer->reverseTransform('foobar'));
        $this->assertFalse($this->transformer->reverseTransform(''));
        $this->assertNull($this->transformer->reverseTransform(null));
    }
}
