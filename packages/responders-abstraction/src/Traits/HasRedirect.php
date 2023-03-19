<?php

namespace AbdAdmin\RespondersAbstraction\Traits;

trait HasRedirect
{
    use HasStatusCode;

    protected string $redirectToUrl = '';

    protected string $redirectToRoute = '';

    protected array $routeParams = [];

    protected int $redirectStatusCode = 302;

    public function setRedirectToUrl(string $redirectUrl, int $statusCode = 302): static
    {
        $this->redirectToUrl = $redirectUrl;
        $this->redirectStatusCode = $statusCode;

        return $this;
    }

    public function setRedirectToRouteName(
        string $redirectRouteName,
        array $routeParams = [],
        int $statusCode = 302
    ): static
    {
        $this->redirectToRoute = $redirectRouteName;
        $this->routeParams = $routeParams;
        $this->redirectStatusCode = $statusCode;

        return $this;
    }
}
