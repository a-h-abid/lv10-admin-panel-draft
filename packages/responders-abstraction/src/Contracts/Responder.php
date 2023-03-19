<?php

namespace AbdAdmin\RespondersAbstraction\Contracts;

interface Responder
{
    public function mergeHeaders(array $headers = []): static;

    public function setHeaders(array $headers = []): static;

    public function setStatusCode(int $statusCode = 200): static;

    public function respond(): mixed;
}
