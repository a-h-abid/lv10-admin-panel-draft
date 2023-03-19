<?php

namespace AbdAdmin\RespondersAbstraction\Contracts;

interface BodyResponder extends Responder
{
    public function setBody(string $body): static;
}
