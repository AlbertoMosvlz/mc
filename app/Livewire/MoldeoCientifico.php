<?php

namespace App\Livewire;

use Livewire\Component;

class MoldeoCientifico extends Component
{
    public $m, $oh, $cmc, $pm;
    public $td, $vd, $vmc;
    public $diametroTornillo, $posicionMaximaRecarga, $densidadMaterial, $resultado;
    public $pgr, $vt, $dm, $pgp, $vmm, $resv3_1, $resv3_2, $resv3;
    public $err, $msg, $err_bool = false;

    public function render()
    {
        return view('livewire.moldeo-cientifico')->layout('layouts/guest');
    }

    public function calculate()
    {
        try {
            $this->calculate_vcm();
            $this->calculate_vd();
            $this->calculate_td();
            $this->vmc = number_format($this->vmc,2);
            $this->vmc = number_format($this->vd,2);
            $this->vmc = number_format($this->td,2);
        } catch (\Throwable $th) {
            $this->err = $th->getMessage();
            $this->msg = "Ha ocurrido un error al calcular";
            $this->err_bool = true;
        }
    }

    public function calculate_vcm()
    {
        $temp = M_PI * pow($this->convertToCm($this->oh) / 2, 2) * $this->convertToCm($this->cmc);
        $this->vmc = $temp;
    }

    public function calculate_vd()
    {
        $temp = $this->m / $this->pm;
        $this->vd = $temp;
    }

    public function calculate_td()
    {
        $temp = $this->vd * ($this->convertToCm($this->cmc)) / $this->vmc;
        $this->td =$temp;
    }
    public function convertToCm($mm)
    {
        return (float)$mm * 0.1;
    }
    public function convertToMm($cm)
    {
        return (float)$cm * 10;
    }

    public function calculate_v2(){
        try {
            $this->resultado = $this->calcularTamanoDisparo();
        } catch (\Throwable $th) {
            $this->err = $th->getMessage();
            $this->msg = "Ha ocurrido un error al calcular";
            $this->err_bool = true;
        }
    }

    public function calcularTamanoDisparo() {
        // Convertir el diámetro del tornillo y la posición máxima de recarga a centímetros
        $diametroTornilloCM = $this->diametroTornillo / 10; // 1 cm = 10 mm
        $posicionMaximaRecargaCM = $this->posicionMaximaRecarga / 10;

        // Calcular el volumen de material en centímetros cúbicos
        $volumen = M_PI * pow($diametroTornilloCM / 2, 2) * $posicionMaximaRecargaCM;

        // Calcular la capacidad/tamaño de disparo de la máquina
        $tamañoDisparo = $volumen * $this->densidadMaterial;

        return $tamañoDisparo;
    }

    public function CalculateV3(){
        try {
            $this->pgr = $this->vt * $this->dm;
            $this->resv3_1  =   ($this->vmm * $this->pgp) / ($this->pgr - 100);
            $this->resv3_2  =   ($this->vmm * $this->pgp) / ($this->pgr + 100);
            $this->resv3    =   ($this->vmm * $this->pgp) / $this->pgr;
        } catch (\Throwable $th) {
            $this->err = $th->getMessage();
            $this->msg = "Ha ocurrido un error al calcular";
            $this->err_bool = true;
        }
    }

    public function closeError(){
        $this->err_bool = false;
        $this->msg = null;
        $this->err = null;
    }
}
