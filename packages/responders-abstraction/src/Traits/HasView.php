<?php

namespace AbdAdmin\RespondersAbstraction\Traits;

trait HasView
{
    protected string $view = '';

    protected ?string $viewNamespace = '';

    public function setView(string $view = '', string $namespace = ''): static
    {
        $this->view = $view;
        $this->viewNamespace = $namespace;

        return $this;
    }

    public function getViewPath(): string
    {
        $viewPath = $this->view;

        if (!empty($this->viewNamespace)) {
            $viewPath = $this->viewNamespace . '::' . $viewPath;
        }

        return $viewPath;
    }
}
