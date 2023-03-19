<?php

namespace AbdAdmin\RequestersAbstraction\Laravel;

use AbdAdmin\RequestersAbstraction\Contracts\Requester;
use Illuminate\Http\Request;

class LaravelRequester implements Requester
{
    public function __construct(private Request $request)
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->request->get($key, $default);
    }

    public function getAll(array $keys = null): array
    {
        return $this->request->all($keys);
    }

    public function forHtmlResponse(): bool
    {
        return $this->request->accepts('text/html');
    }

    public function forJsonResponse(): bool
    {
        return $this->request->wantsJson();
    }
}
