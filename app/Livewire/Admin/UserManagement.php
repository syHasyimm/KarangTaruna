<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $village_id = '';
    public string $selectedRole = 'warga';
    public bool $showForm = false;
    public ?int $editingId = null;
    public string $search = '';

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($this->editingId ? ',' . $this->editingId : ''),
            'selectedRole' => 'required|in:admin,bendahara,warga',
            'village_id' => 'nullable|string|max:50',
        ];

        if (!$this->editingId) {
            $rules['password'] = 'required|min:8';
        } else {
            $rules['password'] = 'nullable|min:8';
        }

        $this->validate($rules);

        if ($this->editingId) {
            $user = User::findOrFail($this->editingId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'village_id' => $this->village_id ?: null,
            ]);
            if ($this->password) {
                $user->update(['password' => bcrypt($this->password)]);
            }
            $user->syncRoles([$this->selectedRole]);
            session()->flash('success', 'Pengguna berhasil diperbarui.');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'village_id' => $this->village_id ?: null,
            ]);
            $user->assignRole($this->selectedRole);
            session()->flash('success', 'Pengguna berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->village_id = $user->village_id ?? '';
        $this->selectedRole = $user->roles->first()?->name ?? 'warga';
        $this->password = '';
        $this->showForm = true;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak bisa menghapus akun sendiri.');
            return;
        }
        $user->delete();
        session()->flash('success', 'Pengguna berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'village_id', 'selectedRole', 'showForm', 'editingId']);
        $this->selectedRole = 'warga';
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }
}
