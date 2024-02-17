<?php

namespace App\View\Components\modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class CheckCodeComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $code = null;
        if (env("IS_REGISTER_CODE")){
            $code = Cache::get('code_verification') ?? null;
        }

        return view('components.modal.check-code-component')
            ->with('code', $code);
    }
}
