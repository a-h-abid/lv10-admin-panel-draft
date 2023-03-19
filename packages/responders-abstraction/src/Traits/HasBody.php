<?php

namespace AbdAdmin\RespondersAbstraction\Traits;

trait HasBody
{
    protected string $body = '';

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }
}
