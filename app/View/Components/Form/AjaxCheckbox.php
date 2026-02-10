<?php

declare(strict_types=1);
namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AjaxCheckbox extends Component
{
    use HandlesValidationErrors;

    /** @var string */
    public string $name;

    /** @var string */
    public string $id;

    /** @var string */
    public string $class;

    /** @var bool */
    public bool $checked;

    /** @var bool */
    public bool $switch;

    /** @var string */
    public string $ajaxUrl;

    /** @var string */
    public string $params;

    /** @var bool */
    public bool $hideLoader=false;

    /** @var bool */
    public bool $hideErrorIndicator=false;

    /** @var bool */
    public bool $reloadTable=false;

    public function __construct(
        string $name='',
        string $id = null,
        string $class = '',
        bool $checked = false,
        bool $switch = false,
        string $ajaxUrl = '',
        string $params = '',
        bool $hideLoader = false,
        bool $hideErrorIndicator = false,
        bool $reloadTable = false
    )
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->class = $class;
        $this->checked = (bool) $checked;
        $this->switch = $switch;
        $this->ajaxUrl = $ajaxUrl;
        $this->params = $params;
        $this->hideLoader = $hideLoader;
        $this->hideErrorIndicator = $hideErrorIndicator;
        $this->reloadTable = $reloadTable;
    }

    private function addParameters($attributes)
    {
        if(!isset($attributes['id']) && empty($this->id)){
            $attributes['id'] = $attributes['name'] ?: '';
        }

        if(!isset($attributes['class']) && empty($this->class)){
            $attributes['class'] = '';
        }

        if(!isset($attributes['switch'])){
            $attributes['switch'] = false;
        }

        if(!isset($attributes['params'])){
            $attributes['params'] = '';
        }

        if(!isset($attributes['hideLoader'])){
            $attributes['hideLoader'] = false;
        }

        if(!isset($attributes['hideErrorIndicator'])){
            $attributes['hideErrorIndicator'] = false;
        }

        if(!isset($attributes['reloadTable'])){
            $attributes['reloadTable'] = false;
        }

        if(!isset($attributes['successUrl'])){
            $attributes['successUrl'] = '';
        }

        return $attributes;
    }

    public function render($customAtt = []): View
    {
        return view('components.forms.ajax.ajax_checkbox', $this->addParameters($customAtt));
    }
}
