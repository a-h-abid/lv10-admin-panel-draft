<?php

namespace Domain\Auth\Configs\FlowTypes;

use Domain\Auth\Configs\FlowTypeEngine;
use Domain\Auth\Http\Controllers\Login\StepByStepController;

class StepByStepEngine implements FlowTypeEngine
{
    public function getSlug(): string
    {
        return 'step-by-step';
    }

    public function getRoutes(): array
    {
        return [
            ['GET', '/', [StepByStepController::class, 'index']],
            ['POST', '/', [StepByStepController::class, 'store']],
        ];
    }
}
