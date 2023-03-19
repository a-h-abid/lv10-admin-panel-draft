<?php

namespace AbdAdmin\SessionAbstraction\Contracts;

interface Session
{
    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value = null): void;

    public function unset(string $key): void;

    public function flash(string $key, mixed $value = null): void;
}
