<?php

namespace MageKeeper\BracketsChecker\Validator;


interface CustomBracketsInterface
{
    /**
     * @param string $openBracket
     * @param string $closedBracket
     * @return CustomBracketsInterface
     */
    public function addBrackets($openBracket, $closedBracket);
}