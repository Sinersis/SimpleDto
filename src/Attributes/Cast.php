<?php

namespace SimpleDto\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cast
{

    public function __construct(
        public string $class,
        public string $isArray,
    )
    {
        //
    }

}