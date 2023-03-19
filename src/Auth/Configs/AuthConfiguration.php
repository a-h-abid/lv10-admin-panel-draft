<?php

namespace Domain\Auth\Configs;

class AuthConfiguration
{
    public function __construct(
        public readonly FlowTypeEnum $flowType,
        public readonly IdentityEnum $identity,
        public readonly array $verification,
    ) {
    }

    public function toArray(): array
    {
        return [
            'flowType' => $this->flowType->value,
            'identity' => $this->identity->value,
            'verification' => $this->verification,
        ];
    }
}
