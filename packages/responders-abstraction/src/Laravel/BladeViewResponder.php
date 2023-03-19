<?php

namespace AbdAdmin\RespondersAbstraction\Laravel;

use AbdAdmin\RespondersAbstraction\AbstractViewResponder;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class BladeViewResponder extends AbstractViewResponder
{
    public function __construct(private Factory $viewFactory)
    {
    }

    public function respond(): View
    {
        return $this->viewFactory->make($this->getViewPath(), $this->data);
    }
}
