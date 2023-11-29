<?php

namespace App\Livewire;

use Livewire\Component;

class MoldeoCientifico extends Component
{
    public $m, $oh, $cmc, $pm;
    public $td, $vd, $vmc, $r2, $pi;

    public function render()
    {
        return view('livewire.moldeo-cientifico')->layout('layouts/guest');
    }

    public function calculate()
    {
        $this->calculate_vcm();
        $this->calculate_vd();
        $this->calculate_td();
    }

    public function calculate_vcm(){
        $pi = pi();
        $this->pi = number_format($pi, 4);  // Esto limitará a 2 decimales
        
        $r2 = $this->convertToCm($this->oh) / 2;
        $this->r2 = number_format($r2, 4);  // Esto limitará a 2 decimales
        
        $this->vmc = $this->pi * ($this->r2 * $this->r2) * $this->convertToCm($this->cmc);
    }

    public function calculate_vd() {
        $temp = $this->m / $this->pm;
        $this->vd = number_format($temp,4);
    }

    public function calculate_td() {
        $temp = $this->vd * ($this->convertToCm($this->cmc)) / $this->vmc;
        $this->td = number_format($temp , 2);
    }
    public function convertToCm($mm)
    {
        return $mm * 0.1;
    }
    public function convertToMm($cm)
{
    return $cm * 10;
}
}
