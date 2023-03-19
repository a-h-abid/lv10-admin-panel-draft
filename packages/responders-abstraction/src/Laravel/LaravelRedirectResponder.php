<?php

namespace AbdAdmin\RespondersAbstraction\Laravel;

use AbdAdmin\RespondersAbstraction\AbstractRedirectResponder;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class LaravelRedirectResponder extends AbstractRedirectResponder
{
    public function respond(): Redirector|RedirectResponse
    {
        if (!empty($this->redirectToRoute)) {
            return redirect()->route(
                $this->redirectToRoute,
                $this->routeParams,
                $this->redirectStatusCode,
                $this->headers
            );
        }

        return redirect($this->redirectToUrl, $this->redirectStatusCode, $this->headers);
    }
}
