<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeleteModal extends Component
{
  public $msg;
  public $model_id;
  public $route;
  public $method;
  public $open = false;

  public function mount($msg = '---', $model_id = 0, $route = 'dashboard', $method='destroy')
  {    
    $this->msg = $msg;
    $this->model_id = $model_id;
    $this->route = $route;
    $this->method = $method;
  }

  public function render()
  {
    return view('livewire.delete-modal');
  }

  public function confirmDeletion()
  {
    $this->open = true;
  }
}