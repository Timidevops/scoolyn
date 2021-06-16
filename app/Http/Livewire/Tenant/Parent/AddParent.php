<?php

namespace App\Http\Livewire\Tenant\Parent;

use App\Http\Livewire\Tenant\Student\AddStudent;
use Livewire\Component;

class AddParent extends Component
{
    public string $parentGenderLabel = '-- choose a gender --';
    public bool $parentGenderDropdown = false;

    public string $parentFirstName = '';
    public string $parentLastName = '';
    public string $parentEmail = '';
    public string $parentPhoneNumber = '';
    public string $parentGender = '';
    public string $parentAddress = '';


    public function render()
    {
        return view('livewire.tenant.parent.add-parent');
    }

    public function store()
    {
    }
}
