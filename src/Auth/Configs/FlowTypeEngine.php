<?php

namespace Domain\Auth\Configs;

interface FlowTypeEngine
{
    public function getSlug(): string;
    public function getRoutes(): array;
}
