<?php

namespace AbdAdmin\RespondersAbstraction;

use AbdAdmin\RespondersAbstraction\Traits\HasHeaders;
use AbdAdmin\RespondersAbstraction\Contracts\Responder;
use AbdAdmin\RespondersAbstraction\Traits\HasStatusCode;

abstract class AbstractResponder implements Responder
{
    use HasHeaders;
    use HasStatusCode;
}
