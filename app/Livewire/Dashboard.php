<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalFaturas = \App\Models\Factura::count();
        $totalDespesas = \App\Models\Movimento::where('tipo', 'saida')->count();
        // Relatórios: total gerado a partir de faturas e despesas
        $totalRelatorios = $totalFaturas + $totalDespesas;
        return view('livewire.dashboard', [
            'totalFaturas' => $totalFaturas,
            'totalDespesas' => $totalDespesas,
            'totalRelatorios' => $totalRelatorios,
        ]);
    }
}
