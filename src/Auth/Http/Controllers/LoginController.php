<?php

namespace Domain\Auth\Http\Controllers;

use AbdAdmin\RequestersAbstraction\Contracts\Requester;
use AbdAdmin\RespondersAbstraction\Contracts\SmartResponder;
use AbdAdmin\SessionAbstraction\Contracts\Session;
use Domain\Auth\Configs\AuthConfiguration;

class LoginController
{
    public function __construct(
        private Requester $request,
        private SmartResponder $responder,
        private AuthConfiguration $authConfig,
        private Session $session
    ) {
    }

    public function index()
    {
        $data = [
            'authConfig' => $this->authConfig->toArray(),
        ];

        if ($this->request->forHtmlResponse()) {
            $data['flash'] = [
                'error' => $this->session->get('error'),
            ];
        }

        return $this->responder->setView('auth/login/index')
            ->setData($data)
            ->respond();
    }

    public function store()
    {
        $identity = $this->request->get($this->authConfig->identity->value);
        $password = $this->request->get('password');

        if ($identity != 'john@example.com' || $password != '1234') {
            $message = trans('auth.alerts.credential-invalid');

            $this->session->flash('error', $message);

            return $this->responder->setData(['message' => $message])
                ->setStatusCode(401)
                ->setRedirectToRouteName('abdadmin.login')
                ->respond();
        }

        return $this->responder->setData(['success' => true])
            ->setRedirectToUrl('/dashboard')
            ->respond();
    }
}
