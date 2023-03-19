<?php

namespace Domain\Auth\Configs;

enum FlowTypeEnum: string
{
    case REGULAR = 'regular';
    case STEPPED = 'stepped';
}
