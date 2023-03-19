<?php

namespace AbdAdmin\RespondersAbstraction;

use AbdAdmin\RespondersAbstraction\Contracts\RedirectResponder;
use AbdAdmin\RespondersAbstraction\Traits\HasRedirect;

abstract class AbstractRedirectResponder extends AbstractResponder implements RedirectResponder
{
    use HasRedirect;
}
