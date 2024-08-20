<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WelcomeModal extends Component
{
    public $showingModal = true;

    public $listeners = [
        'hideMe' => 'hideModal'
    ];

    public function render()
    {
        return view('livewire.welcome-modal');
    }

    public function showModal()
    {
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }
}
