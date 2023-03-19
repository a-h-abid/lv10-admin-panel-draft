<?php

namespace AbdAdmin\RespondersAbstraction;

use AbdAdmin\RespondersAbstraction\Contracts\SmartResponder;
use AbdAdmin\RespondersAbstraction\Traits\HasBody;
use AbdAdmin\RespondersAbstraction\Traits\HasData;
use AbdAdmin\RespondersAbstraction\Traits\HasRedirect;
use AbdAdmin\RespondersAbstraction\Traits\HasView;

abstract class AbstractSmartResponder extends AbstractResponder implements SmartResponder
{
    use HasBody;
    use HasData;
    use HasView;
    use HasRedirect;
}
