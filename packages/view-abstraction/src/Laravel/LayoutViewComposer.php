<?php

namespace AbdAdmin\ViewAbstraction\Laravel;

use Illuminate\Contracts\View\View;

class LayoutViewComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('defaultColorScheme', config('abdadmin.layout.default-color-scheme'));
    }
}
