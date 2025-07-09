<?php

namespace App\Livewire;

use Livewire\Component;

class BottomNav extends Component
{
    public function render()
    {
        return view('livewire.bottom-nav');
    }
    
    public function HomeBottomNav(){
 
        redirect()->route('dashboard');
        

    }
    public function AddBottomNav(){
 
    redirect()->route('addticket');

    }
    public function ProfileBottomNav(){
 
       redirect()->route('settings.profile');

    }
    public function requestBottomNav(){
 
        redirect()->route('RequestTicketNumber');

    }
}

