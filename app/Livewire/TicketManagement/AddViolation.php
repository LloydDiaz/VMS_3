<?php

namespace App\Livewire\TicketManagement;

use \Livewire\WithPagination;
use App\Models\AuditTrail;
use App\Models\Violation;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;


class AddViolation extends Component
{
    use WithPagination;


    public $violation_type;
    public $amount;
    public $violation_id;


    public $search = "";

    public $editingViolationID;

    public $editingViolationType;
    public $editingViolationAmount;



    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {


        if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'user') {

            $violations = Violation::where('violation_type', 'like', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            return view('livewire.ticket-management.add-violation', compact('violations'));
        } else {
            return abort(404);
        }
    }
    //edit violation type
    public function editViolation($id)
    {

        if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'user') {

            $this->editingViolationID = $id;
            $this->editingViolationType = Violation::find($id)->violation_type;
            $this->editingViolationAmount = Violation::find($id)->amount;
        } else {
            return abort(404);
        }
    }

    //update Violation
    public function updateViolation()
    {
        if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'user') {
            $user_id = Auth::user();
            //clone old vaiolation type and amount
            $violation = Violation::find($this->editingViolationID);
            $copy = clone $violation;
            $old_violation_type = $copy->violation_type;
            $old_amount = $copy->amount;




            Violation::find($this->editingViolationID)->update([
                'violation_type' => $this->editingViolationType,
                'amount' => $this->editingViolationAmount
            ]);






            $this->reset('editingViolationID', 'editingViolationType', 'editingViolationAmount');
        } else {
            return abort(404);
        }
    }

    //cancel edit

    public function CancelEdit()
    {
        $this->reset('editingViolationID', 'editingViolationType', 'editingViolationAmount');
    }


    //delete violation type
    public function delete($id)
    {
        if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'user') {
            $user_id = Auth::user();
            $violation = Violation::find($id);
            $copy = clone $violation;
            $old_violation_id = $copy->id;
            $old_violation_type = $copy->violation_type;
            $old_amount = $copy->amount;
            Violation::find($id)->delete();
        } else {
            return abort(404);
        }
    }
public function addViolationType()
{
    $this->validate([
        'violation_type' => 'required|min:3|max:50',
        'amount' => 'required|numeric'
    ]);

    Violation::create([
        'violation_type' => $this->violation_type,
        'amount' => $this->amount
    ]);

    session()->flash('violation_success', 'Violation added successfully.');

    return redirect()->route('violations');
}
}
