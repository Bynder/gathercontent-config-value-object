<?php

namespace GatherContent\ConfigValueObject;

use Assert\Assertion as BaseAssertion;

class Assertion extends BaseAssertion
{
    protected static $exceptionClass = ConfigValueException::class;
}
