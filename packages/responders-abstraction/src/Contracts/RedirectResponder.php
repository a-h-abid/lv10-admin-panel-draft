<?php

namespace AbdAdmin\RespondersAbstraction\Contracts;

interface RedirectResponder extends Responder
{
    public function setRedirectToUrl(string $redirectUrl, int $statusCode = 302): static;

    public function setRedirectToRouteName(
        string $redirectRouteName,
        array $routeParams = [],
        int $statusCode = 302
    ): static;
}
