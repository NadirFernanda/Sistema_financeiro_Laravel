<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalFaturas = \App\Models\Factura::count();
        $totalDespesas = \App\Models\Movimento::where('tipo', 'saida')->count();
        $totalRelatorios = \App\Models\Relatorio::count();
        return view('livewire.dashboard', [
            'totalFaturas' => $totalFaturas,
            'totalDespesas' => $totalDespesas,
            'totalRelatorios' => $totalRelatorios,
        ]);
    }
}
