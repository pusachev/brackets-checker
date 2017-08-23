<?php

namespace MageKeeper\BracketsChecker\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;

use MageKeeper\BracketsChecker\Validator\BracketsValidator;

class BracketsValidatorTest extends TestCase
{
    /** @var  BracketsValidator */
    protected $bracketsValidator;

    /** {@inheritdoc} */
    public function setUp()
    {
        $this->bracketsValidator = new BracketsValidator();
    }

    /** {@inheritdoc} */
    public function tearDown()
    {
        unset($this->bracketsValidator);

        parent::tearDown();
    }

    /**
     * @dataProvider validatorProvider
     *
     * @param string  $expression
     * @param bool    $expected
     */
    public function testValidate($expression, $expected)
    {
        $this->assertEquals($expected, $this->bracketsValidator->validate($expression));
    }

    /**
     * @dataProvider validatorWithCustomBracketProvider
     *
     * @param string $openBracket
     * @param string $closeBracket
     * @param string $expression
     * @param bool   $expected
     */
    public function testValidateWithCustomBrackets(
        $openBracket,
        $closeBracket,
        $expression,
        $expected
    ) {
        $this->bracketsValidator->addBrackets($openBracket, $closeBracket);
        $this->assertEquals($expected, $this->bracketsValidator->validate($expression));
    }

    /**
     * @expectedException \LogicException
     */
    public function testInvalidTypeGiven()
    {
        $this->bracketsValidator->validate(123);
    }

    /** @return mixed[] */
    public function validatorProvider()
    {
        return [
            ['[({})]', true],
            ['[([)', false],
            ['(5+10)*20/(15 - 1)', true],
            ['(12 - 10 * {12} + 5]', false,],
            ['[x*(y+2 *[3 +4) -5 ]', false]
        ];
    }

    public function validatorWithCustomBracketProvider()
    {
        return [
            ['#', '#', '#(12 + 15) * 10#', true],
            ['#', '#', '#(12 + 15)# * 10#', false],
            ['#', '#', '(12+15) * 10#', false],
            ['/', '/', '/(12+15) * 10/', true],
            ['/', '/', '/(12+15)/ * 10/', false],
            ['/', '/', '/(12+15) * 10', false],
        ];
    }
}
