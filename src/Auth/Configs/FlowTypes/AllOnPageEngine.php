<?php

namespace Domain\Auth\Configs\FlowTypes;

use Domain\Auth\Configs\FlowTypeEngine;
use Domain\Auth\Http\Controllers\Login\AllOnPageController;

class AllOnPageEngine implements FlowTypeEngine
{
    public function getSlug(): string
    {
        return 'all-on-page';
    }

    public function getRoutes(): array
    {
        return [
            ['GET', '/', [AllOnPageController::class, 'index']],
            ['POST', '/', [AllOnPageController::class, 'store']],
        ];
    }
}
