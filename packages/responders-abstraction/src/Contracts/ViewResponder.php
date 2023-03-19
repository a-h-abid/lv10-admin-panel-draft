<?php

namespace AbdAdmin\RespondersAbstraction\Contracts;

interface ViewResponder extends DataResponder
{
    public function setView(string $view = '', string $namespace = ''): static;
}
