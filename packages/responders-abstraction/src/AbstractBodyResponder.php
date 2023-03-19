<?php

namespace AbdAdmin\RespondersAbstraction;

use AbdAdmin\RespondersAbstraction\Contracts\BodyResponder;
use AbdAdmin\RespondersAbstraction\Traits\HasBody;

abstract class AbstractBodyResponder extends AbstractResponder implements BodyResponder
{
    use HasBody;
}
