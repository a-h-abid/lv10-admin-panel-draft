<?php

namespace AbdAdmin\RespondersAbstraction\Contracts;

interface DataResponder extends Responder
{
    public function mergeData(array $data = []): static;

    public function setData(array $data = []): static;
}
