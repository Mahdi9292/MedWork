<?php

declare(strict_types=1);
namespace App\View\Components\Form;

use App\Concerns\HandlesValidationErrors;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class VanillaDatepicker extends Component
{
    use HandlesValidationErrors;

    /** @var string */
    public string $name;

    /** @var string */
    public string $id;

    /** @var string */
    public string $type;

    /** @var string */
    public mixed $value;

    /** @var string */
    public string $label;

    /** @var string */
    public string $row;

    /** @var string */
    public string $wrap;

    /** @var string */
    public string $labelClass;

    /** @var bool */
    public bool $labelAsterisk;

    /** @var string */
    public string $leadingAddon;

    /** @var string */
    public string $leadingIcon;

    /** @var string */
    public string $trailingAddon;

    /** @var string */
    public string $trailingIcon;

    /** @var string */
    public string $fieldInfo;

    /** @var Collection */
    public Collection $dataList;

    /** @var bool */
    public bool $dataListMulti;

    /** @var bool */
    public bool $disableAutofill;

    public function __construct(
        string $name,
        string $id = null,
        string $type = 'text',
        ?string $value = '',
        bool $showErrors = true,
        string $label='',
        string $labelClass ='col-sm-2',
        bool $labelAsterisk =false,
        string $row ='row mb-3',
        string $wrap ='col-sm-8',
        string $leadingAddon = '',
        string $leadingIcon = '',
        string $trailingAddon = '',
        string $trailingIcon = '',
        string $fieldInfo = '',
        Collection $dataList = null,
        bool $dataListMulti = false,
        bool $disableAutofill = false,
    )
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->type = $type;
        $this->showErrors = $showErrors;
        $this->label = $label;
        $this->labelClass = $labelClass;
        $this->labelAsterisk = $labelAsterisk;
        $this->row = $row;
        $this->wrap = $wrap;
        $this->leadingAddon = $leadingAddon;
        $this->leadingIcon = $leadingIcon;
        $this->trailingAddon = $trailingAddon;
        $this->trailingIcon = $trailingIcon;
        $this->fieldInfo = $fieldInfo;
        $this->dataList = $dataList ?? collect();
        $this->dataListMulti = $dataListMulti;
        $this->disableAutofill = $disableAutofill;
        $this->value = old($name, $value ?? '');
    }

    public function inputClass(): string
    {
        return collect([
            'form-control left-border-radius',
            //$this->hasErrorsAndShow($this->name) ? 'is-invalid' : null,
        ])->filter()->implode(' ');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.forms.vanilla-datepicker');
    }
}
