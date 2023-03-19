<?php

namespace AbdAdmin\RequestersAbstraction\Contracts;

interface Requester
{
    public function get(string $key, mixed $default = null): mixed;

    public function getAll(array $keys = null): array;

    public function forHtmlResponse(): bool;

    public function forJsonResponse(): bool;
}
