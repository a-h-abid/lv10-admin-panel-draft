<?php

namespace AbdAdmin\RespondersAbstraction\Traits;

trait HasHeaders
{
    protected array $headers = [];

    public function mergeHeaders(array $headers = []): static
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function setHeaders(array $headers = []): static
    {
        $this->headers = $headers;

        return $this;
    }
}
