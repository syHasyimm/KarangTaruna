<?php

namespace App\Livewire\Finance;

use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    // Form fields
    public $category_id = '';
    public $amount = '';
    public $description = '';
    public $date = '';
    public $evidence_file;

    // State
    public bool $showForm = false;
    public ?int $editingId = null;
    public string $filterType = '';
    public string $search = '';

    protected function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:500',
            'date' => 'required|date',
            'evidence_file' => $this->editingId ? 'nullable|image|max:2048' : 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'category_id' => $this->category_id,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
        ];

        if ($this->evidence_file) {
            $data['evidence_file'] = $this->evidence_file->store('evidence', 'public');
        }

        if ($this->editingId) {
            Transaction::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Transaksi berhasil diperbarui.');
        } else {
            Transaction::create($data);
            session()->flash('success', 'Transaksi berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $trx = Transaction::findOrFail($id);
        $this->editingId = $trx->id;
        $this->category_id = $trx->category_id;
        $this->amount = $trx->amount;
        $this->description = $trx->description;
        $this->date = $trx->date->format('Y-m-d');
        $this->showForm = true;
    }

    public function delete($id)
    {
        Transaction::findOrFail($id)->delete();
        session()->flash('success', 'Transaksi berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['category_id', 'amount', 'description', 'date', 'evidence_file', 'showForm', 'editingId']);
    }

    public function render()
    {
        $query = Transaction::with(['category', 'user'])->latest('date');

        if ($this->filterType) {
            $query->whereHas('category', fn($q) => $q->where('type', $this->filterType));
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                  ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$this->search}%"));
            });
        }

        $totalIncome = Transaction::income()->sum('amount');
        $totalExpense = Transaction::expense()->sum('amount');

        return view('livewire.finance.index', [
            'transactions' => $query->paginate(10),
            'categories' => Category::all(),
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
        ]);
    }
}
