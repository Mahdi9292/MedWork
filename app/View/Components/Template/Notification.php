<?php

namespace App\View\Components\Template;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notification extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public bool $showErrors = false,
        public array $messages = []
    )
    {
        $this->getMessage();
    }

    private function getMessage(): void
    {
        if(session()->has('success')){
            $this->messages[] = ['type' => 'success', 'message' => session()->get('success')];
        }

        if(session()->has('completed')){
            $this->messages[] = ['type' => 'success', 'message' => session()->get('completed')];
        }

        if(session()->has('error')){
            $this->messages[] = ['type' => 'danger', 'message' => session()->get('error')];
        }

        if(session()->has('failed')){
            $this->messages[] = ['type' => 'danger', 'message' => session()->get('failed')];
        }

        if(session()->has('danger')){
            $this->messages[] = ['type' => 'danger', 'message' => session()->get('danger')];
        }

        if(session()->has('info')){
            $this->messages[] = ['type' => 'info', 'message' => session()->get('info')];
        }

        if(session()->has('warning')){
            $this->messages[] = ['type' => 'warning', 'message' => session()->get('warning')];
        }
    }
    
    public function render(): View
    {
        return view('components.template.notification');
    }
}
