<?php

namespace AbdAdmin\SessionAbstraction\Laravel;

use AbdAdmin\SessionAbstraction\Contracts\Session;
use Illuminate\Session\Store as LaravelSessionStore;

class LaravelSession implements Session
{
    public function __construct(private LaravelSessionStore $session)
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->session->get($key, $default);
    }

    public function set(string $key, mixed $value = null): void
    {
        $this->session->put($key, $value);
    }

    public function unset(string $key): void
    {
        $this->session->forget($key);
    }

    public function flash(string $key, mixed $value = null): void
    {
        $this->session->flash($key, $value);
    }
}
