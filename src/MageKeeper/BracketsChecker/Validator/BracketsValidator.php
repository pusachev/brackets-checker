<?php

namespace MageKeeper\BracketsChecker\Validator;

class BracketsValidator implements BracketsValidatorInterface, CustomBracketsInterface
{
    /** @var  string[] */
    protected $stack;

    /** @var  string[] */
    protected $collection;

    /** @var  mixed[] */
    protected $duplicatedBrackets;

    public function __construct()
    {
        $this->stack = [];
        $this->collection = [
            '(' => ')',
            '[' => ']',
            '{' => '}'
        ];
    }

    /** {@inheritdoc} */
    public function validate($expression)
    {
        if (!is_string($expression)) {
            throw new \LogicException(sprintf('Expression must be a string, %s given', gettype($expression)));
        }

        $length = mb_strlen($expression);

        $flippedCollection = array_flip($this->collection);

        for ($i = 0; $i < $length; $i++) {
            $char = $expression[$i];
            if (isset($this->collection[$char]) && !isset($flippedCollection[$char])) {
                array_push($this->stack, $this->collection[$char]);
            } else if (isset($this->collection[$char]) && isset($flippedCollection[$char])) {
                if (!isset($this->duplicatedBrackets[$char])) {
                    $this->duplicatedBrackets[$char] = 0;
                }
                $this->duplicatedBrackets[$char] += 1;
            } else if (isset($flippedCollection[$char])) {
                $expected = array_pop($this->stack);
                if (($expected === NULL) || ($char != $expected)) {
                    return false;
                }
            }
        }

        if (!empty($this->duplicatedBrackets)) {
            foreach ($this->duplicatedBrackets as $count) {
                if(($count%2) !== 0) {
                    return false;
                }
            }
        }

        return empty($this->stack);
    }

    /** {@inheritdoc} */
    public function addBrackets($openBracket, $closeBracket)
    {
        $this->collection[$openBracket]  = $closeBracket;

        return $this;
    }
}
