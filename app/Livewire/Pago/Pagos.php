<?php

namespace App\Livewire\Pago;

use App\Models\Conferencia;
use App\Models\Pago;
use Livewire\Component;

class Pagos extends Component
{
    public $conferencia;
    public $user;
    public function mount($conferencia)
    {
        $conferenciaId = Conferencia::find($conferencia);
        $this->conferencia = $conferenciaId;

        $this->user = auth()->user();
    }

    public function realizarPago(){
        
        $user = Pago::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

    }

    public function render()
    {
        return view('livewire.Pagos.pagos', [
            'conferencia' => $this->conferencia,
            'user' => $this->user
        ]); 
    }
}
