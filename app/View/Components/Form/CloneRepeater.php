<?php

declare(strict_types=1);

namespace App\View\Components\Form;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CloneRepeater extends Component
{
    /** @var string */
    public string $name;

    /** @var string */
    public string $id;

    /** @var string */
    public string $class;

    /** @var string */
    public string $label;

    /** @var string */
    public string $row;

    /** @var string */
    public string $wrap;

    /** @var string */
    public string $labelClass;

    /** @var string */
    public string $leadingAddon;

    /** @var string */
    public string $leadingIcon;

    /** @var string */
    public string $trailingAddon;

    /** @var string */
    public string $trailingIcon;

    /** @var string */
    public string $heading;

    /** @var string */
    public string $subHeading;

    /** @var string */
    public string $description;

    /** @var bool */
    public bool $loadJquery;

    public function __construct(
        string $name,
        string $id = '',
        string $class = '',
        string $label='',
        string $labelClass ='col-sm-2',
        string $row ='row mb-3',
        string $wrap ='col-sm-8',
        string $leadingAddon = '',
        string $leadingIcon = '',
        string $trailingAddon = '',
        string $trailingIcon = '',
        string $heading = '',
        string $subHeading = '',
        string $description = '',
        bool $loadJquery = true
    )
    {
        $this->name = $name;
        $this->id = $id ?: $name;
        $this->class = $class;
        $this->label = $label;
        $this->labelClass = $labelClass;
        $this->row = $row;
        $this->wrap = $wrap;
        $this->leadingAddon = $leadingAddon;
        $this->leadingIcon = $leadingIcon;
        $this->trailingAddon = $trailingAddon;
        $this->trailingIcon = $trailingIcon;
        $this->heading = $heading;
        $this->subHeading = $subHeading;
        $this->description = $description;
        $this->loadJquery = $loadJquery;
    }

    public function render(): View
    {
        return view('components.forms.clone-repeater');
    }
}
