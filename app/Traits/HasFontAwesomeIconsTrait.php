<?php

namespace App\Traits;

/**
 * Class HasFontAwesomeIconsTrait
 * provide Font Awesome Icons
 *
 *
 * @package App
 * @author Ehsan Farooqi <https://github.com/eafarooqi>
 */
trait HasFontAwesomeIconsTrait
{
    /**
     * Icon Theme
     * values: duotone, sharp, sharp-duotone
     * empty for default classic theme
     *
     * @var string
     */
    protected string $iconTheme = '';

    /**
     * Icon Type
     * values: solid, regular, light, thin
     *
     * @var string
     */
    protected string $iconType = 'solid';

    protected string $iconClass = '';

    private function iconType(String $type): static
    {
        $this->iconType = $type;
        return $this;
    }

    private function iconTheme(String $theme): static
    {
        $this->iconTheme = $theme;
        return $this;
    }

    private function iconClass(String $iconClass): static
    {
        $this->iconClass = $iconClass;
        return $this;
    }

    private function renderIcon(): String
    {
        $template = '<i class="fa-%s fa-%s %s"></i>';
        return sprintf($template, $this->iconTheme, $this->iconType, $this->iconClass);
    }

    private function editIcon(): static
    {
        $this->iconClass = 'fa-pen-to-square';
        return $this;
    }

    private function showIcon(): static
    {
        $this->iconClass = 'fa-eye';
        return $this;
    }

    private function deleteIcon(): static
    {
        $this->iconClass = 'fa-trash';
        return $this;
    }

    private function printIcon(): static
    {
        $this->iconClass = 'fa-file-pdf';
        return $this;
    }

    private function downloadIcon(): static
    {
        $this->iconClass = 'fa-download';
        return $this;
    }
}

