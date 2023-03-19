<?php

namespace AbdAdmin\RespondersAbstraction\Laravel;

use AbdAdmin\RespondersAbstraction\AbstractSmartResponder;
use Illuminate\Http\Request;

class LaravelSmartResponder extends AbstractSmartResponder
{
    public function __construct(private Request $request)
    {
    }

    public function respond(): mixed
    {
        if ($this->request->wantsJson()) {
            return response()->json($this->data, $this->statusCode, $this->headers);
        }

        if (!empty($this->redirectToRoute)) {
            return redirect()->route(
                $this->redirectToRoute,
                $this->routeParams,
                $this->redirectStatusCode,
                $this->headers
            );
        }

        if (!empty($this->redirectToUrl)) {
            return redirect($this->redirectToUrl, $this->redirectStatusCode, $this->headers);
        }

        return view($this->getViewPath(), $this->data);
    }
}
