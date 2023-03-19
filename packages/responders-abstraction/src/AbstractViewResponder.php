<?php

namespace AbdAdmin\RespondersAbstraction;

use AbdAdmin\RespondersAbstraction\Contracts\ViewResponder;
use AbdAdmin\RespondersAbstraction\Traits\HasData;
use AbdAdmin\RespondersAbstraction\Traits\HasView;

abstract class AbstractViewResponder extends AbstractResponder implements ViewResponder
{
    use HasData;
    use HasView;
}
