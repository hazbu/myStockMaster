<?php

declare(strict_types=1);

namespace App\Http\Livewire\Suppliers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    /** @var mixed */
    public $supplier;

    /** @var string[] */
    public $listeners = ['editModal'];

    /** @var array */
    protected $rules = [
        'supplier.name'       => 'required|string|max:255',
        'supplier.email'      => 'nullable|max:255',
        'supplier.phone'      => 'required|numeric',
        'supplier.city'       => 'nullable|max:255',
        'supplier.country'    => 'nullable|max:255',
        'supplier.address'    => 'nullable|max:255',
        'supplier.tax_number' => 'nullable||max:255',
    ];

    public function render()
    {
        return view('livewire.suppliers.edit');
    }

    public function editModal($id)
    {
        abort_if(Gate::denies('supplier_update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->supplier = Supplier::where('id', $id)->firstOrFail();

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->supplier->save();

        $this->editModal = false;

        $this->alert('success', __('Supplier updated successfully.'));
    }
}