<?php

namespace App\Livewire;

use App\Models\Insumo;
use App\Models\Movimiento;
use Illuminate\Support\Collection;
use Livewire\Component;

class SearchBar extends Component
{
    public $query;
    public $results = null;//new Collection();
    public $openModalBusqueda = false;
    public $mostrarResultados = false;
    public $resultadoIndex = null;

    public function buscar()
    {
        if (!empty($this->query)) {

            $result1 = Movimiento::search($this->query)->get();
            $result2 = Insumo::search($this->query)->get();
            //dd($result1, $result2);

            // Convertir los resultados a una única colección
            $this->results = $this->mergeResults([$result1, $result2]);
            //dd($result1, $result2, $this->query, $this->results);
            $this->mostrarResultados = true;
        } else {
            $this->results = new Collection();
        }

    }

    // Método para combinar los resultados en una única colección
    private function mergeResults(array $resultsArray)
    {
        $mergedResults = new Collection();

        foreach ($resultsArray as $results) {
            foreach ($results as $item) {
                $mergedResults->push($item);
            }
        }

        return $mergedResults;
    }


    public function clearResults()
    {
        $this->mostrarResultados = false;
    }

    public function mostrarModalBusqueda($result)
    {
        # code...
        $this->resultadoIndex = $this->results->get($result);
        //dd($result, $this->resultadoIndex);
        //dd($this->resultadoIndex->getTypeAndContent());
        $this->openModalBusqueda = true;
        //dd($this->openModalBusqueda);

        
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
