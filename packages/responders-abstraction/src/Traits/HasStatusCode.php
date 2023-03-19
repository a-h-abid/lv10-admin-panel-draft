<?php

namespace AbdAdmin\RespondersAbstraction\Traits;

trait HasStatusCode
{
    protected int $statusCode = 200;

    public function setStatusCode(int $statusCode = 200): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
