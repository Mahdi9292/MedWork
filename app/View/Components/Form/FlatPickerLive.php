<?php

namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class FlatPickerLive extends Component
{
    use HandlesValidationErrors;

    public function __construct(
        public string $name='',
        public string $uuid='',
        public ?string $id = null,
        public string $wrap = 'col-sm-8',
        public string $row = 'row mb-3',
        public string $leadingAddon = '',
        public string $leadingIcon = '',
        public string $trailingAddon = '',
        public string $trailingIcon = '',
        public string $label='',
        public string $labelClass ='col-sm-2',
        public bool $labelAsterisk =false,
        public ?string $value = '',
        public ?string $icon = null,
        public ?string $iconRight = null,
        public ?string $hint = null,
        public ?string $hintClass = 'label-text-alt text-gray-400 py-1 pb-0',
        public ?bool $inline = false,
        public ?array $config = [],
        public string $format = '',
        public string $altFormat = '',
        public bool $enableTime = false,
        public bool $time24Hr = true,
        public bool $weekNumbers = false,
        public bool $allowInput = false,

        // Validations
        public ?string $errorField = null,
        public ?string $errorClass = 'text-red-500 label-text-alt p-1',
        public ?bool $omitError = false,
        public ?bool $firstErrorOnly = false,
    ) {
        $this->id = $id ?? $name;
        $this->value = old($name, $value ?? '');
        $this->uuid = "twap" . md5(serialize($this));
        $this->format = $this->format ?: ($this->enableTime ? 'Y-m-d H:i' : 'Y-m-d');
        $this->altFormat = $this->altFormat ?: ($this->enableTime ? 'd.m.Y H:i' : 'd.m.Y');
    }

    public function modelName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first();
    }

    public function errorFieldName(): ?string
    {
        return $this->errorField ?? $this->modelName();
    }

    public function setup(): string
    {
        // Handle `wire:model.live` for `range` dates
        if (isset($this->config["mode"]) && $this->config["mode"] == "range" && $this->attributes->wire('model')->hasModifier('live')) {
            $this->attributes->setAttributes([
                'wire:model' => $this->modelName(),
                'live' => true
            ]);
        }

        $config = json_encode(array_merge([
            'dateFormat' => $this->format,
            'altInput' => true,
            //'static' => true,
            'disableMobile' => true,
            'clickOpens' => ! $this->attributes->has('readonly') || $this->attributes->get('readonly') == false,
            'allowInput' => $this->allowInput,
            'altFormat' => $this->altFormat,
            'enableTime' => $this->enableTime,
            'time_24hr' => $this->time24Hr,
            'weekNumbers' => $this->weekNumbers,
            'locale' => 'de',
            'defaultDate' => '#model#',
            'plugins' => ['#plugins#'],
        ], Arr::except($this->config, ["plugins"])));

        // Plugins
        $plugins = "";

        foreach (Arr::get($this->config, 'plugins', []) as $plugin) {
            $plugins .= "new " . key($plugin) . "( " . json_encode(current($plugin)) . " ),";
        }

        // Plugins
        $config = str_replace('"#plugins#"', $plugins, $config);

        // Sets default date as current bound model
        $config = str_replace('"#model#"', '$wire.get("' . $this->modelName() . '")', $config);

        return $config;
    }

    public function inputClass(): string
    {
        return collect([
            'form-control left-border-radius',
            //$this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.inputs.t-flat-pickr');
    }
}
