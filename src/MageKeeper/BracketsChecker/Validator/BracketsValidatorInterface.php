<?php

namespace MageKeeper\BracketsChecker\Validator;

interface BracketsValidatorInterface
{
    /**
     * @param string $expression
     * @return bool
     * @throws \LogicException
     */
    public function validate($expression);
}