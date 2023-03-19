<?php

namespace AbdAdmin\RespondersAbstraction\Traits;

trait HasData
{
    protected array $data = [];

    public function mergeData(array $data = []): static
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function setData(array $data = []): static
    {
        $this->data = $data;

        return $this;
    }
}
