<?php

namespace App\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Livewire;


class UserIndex extends Component
{
    public string $firstname = '';
    public string $lastname = '';
    public string $middlename = '';
    public string $xname = '';
    public string $user_role = '';

    public string $email = '';

    public string $password = '';
    public string $username = '';
    public $showModal = false;
    public string $password_confirmation = '';
    public string $search = '';
    use  \Livewire\WithPagination;
    protected $paginationTheme = 'tailwind';
    protected $listeners = ['userCreated' => '$refresh'];
    public $confirmingDeleteId = null;
    public $editingUserId = null;


    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'user_role' => 'required',
        'password' => 'required|min:6'
    ];

    public function updatedSearch()
    {
        $this->resetPage(); // Reset pagination when search changes
    }


    public function openModal()
    {
        $this->showModal = true;
    }
    public function editUser($id)
    { 
    }
    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }
    public function deleteUser()
    {
    }


    public function createUser()
    {
        $this->validate();

        User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'middlename' => $this->middlename,
            'xname' => $this->xname,
            'user_role' => $this->user_role,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('user_success', 'User Created successfully.');

        return redirect()->route('userManagement');
    }


    public function render()
    {
        $users = User::query()
            ->where('firstname', 'like', '%' . $this->search . '%')
            ->orWhere('lastname', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user-management.user-index', compact('users'));
    }
}
