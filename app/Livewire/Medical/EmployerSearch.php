<?php

namespace App\Livewire\Medical;

use App\Models\Medical\Employer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection as DbCollection;

class EmployerSearch extends Component
{
    use WithPagination;

    public string $searchTerm='';
    public int $searchCount = 0;
    public DbCollection $employers;
    public bool $maximumRecordsInfo;
    public ?Collection $fields = null;
    public string $eventName = 'setEmployerData';

    public function mount(): void
    {
        $this->fields = $this->fields ?: collect([]);
    }

    public function doSearch(): void
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $this->employers = Employer::where('name','like', $searchTerm)
            ->orWhere('name', 'like', $searchTerm)
            ->orWhere('contact_person', 'like', $searchTerm)
            ->orWhere('address', 'like', $searchTerm)
            ->orWhere('street', 'like', $searchTerm)
            ->orWhere('house_number', 'like', $searchTerm)
            ->orWhere('city', 'like', $searchTerm)
            ->orWhere('postcode', 'like', $searchTerm)
            ->orWhere('phone', 'like', $searchTerm)
            ->orWhere('mobile', 'like', $searchTerm)
            //  ->orWhere('email', 'like', $searchTerm)
            ->limit(100)->get();
        $this->searchCount = count($this->employers);
        $this->maximumRecordsInfo = $this->searchCount === 100;
    }

    public function employerSelected(int $employerId): void
    {
        $employer = Employer::find($employerId);

        $this->dispatch('employerSelected', employer: $employer, fields: $this->fields);
    }

    public function render(): View
    {
        return view('livewire.medical.employer-search');
    }
}
