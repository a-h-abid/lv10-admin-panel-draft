<?php

namespace Domain\Dashboard\Http\Controllers;

use AbdAdmin\RequestersAbstraction\Contracts\Requester;
use AbdAdmin\RespondersAbstraction\Contracts\SmartResponder;
use AbdAdmin\SessionAbstraction\Contracts\Session;

class DashboardController
{
    public function __construct(
        private Requester $request,
        private SmartResponder $responder,
        private Session $session
    ) {
    }

    public function index()
    {
        return $this->responder->setView('dashboard/index')
            ->respond();
    }
}
