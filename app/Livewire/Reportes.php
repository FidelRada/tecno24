<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Insumo;
use App\Models\Movimiento;
use Carbon\Carbon;
use Livewire\Component;
use Dompdf\Dompdf;
use Dompdf\Options;

class Reportes extends Component
{
    public $consultaSeleccionada;
    public $resultados = [];
    public $fecha = ['inicio' => '', 'fin' => ''];
    public $encabezados = [];
    public $mostartMovimientos = false;
    public $mostartClientes = false;
    public $mostartInsumos = false;
    public $nombreHTML = '';

    public function estructurarTablaMovimientos()
    {
        $this->mostartMovimientos = true;
        $this->mostartClientes = false;
        $this->mostartInsumos = false;
        //dd($this->resultados);

    }
    public function estructurarTablaInsumos()
    {
        $this->mostartMovimientos = false;
        $this->mostartClientes = false;
        $this->mostartInsumos = true;
        //dd($this->resultados);

    }

    public function estructurarTablaClientes()
    {
        $this->mostartMovimientos = false;
        $this->mostartClientes = true;
        $this->mostartInsumos = false;
        //dd($this->resultados);

    }

    public function filtrarMovimientos()
    {
        $inicio = Carbon::parse($this->fecha['inicio'])->startOfDay();
        $fin = Carbon::parse($this->fecha['fin'])->endOfDay();

        $this->resultados = Movimiento::whereBetween('fecha', [$inicio, $fin])
            ->with('tipomovimiento')
            ->with('proveedor.persona')
            ->with('personal.persona')
            ->get();
        //dd($this->resultados);
        //dd($this->resultados, count($this->resultados));
    }

    public function filtrarInsumos()
    {
        $inicio = Carbon::parse($this->fecha['inicio'])->startOfDay();
        $fin = Carbon::parse($this->fecha['fin'])->endOfDay();

        //dd($inicio, $fin);
        $this->resultados = Insumo::whereBetween('created_at', [$inicio, $fin])
            ->with('categoriainsumo')
            ->get();

        //dd($this->resultados);
        //dd($this->resultados, count($this->resultados));
    }


    public function filtrarClientes()
    {
        $inicio = Carbon::parse($this->fecha['inicio'])->startOfDay();
        $fin = Carbon::parse($this->fecha['fin'])->endOfDay();

        //dd($inicio, $fin);
        $this->resultados = Cliente::whereBetween('created_at', [$inicio, $fin])
            ->with('persona')
            ->get();

        //dd($this->resultados);
        //dd($this->resultados, count($this->resultados));
    }

    public function filtrar()
    {
        switch ($this->consultaSeleccionada) {
            case 'Movimientos':
                $this->nombreHTML = 'reports.movimientos-report';
                $this->filtrarMovimientos();
                $this->estructurarTablaMovimientos();
                break;
            case 'Insumos':
                $this->nombreHTML = 'reports.insumos-report';
                $this->filtrarInsumos();
                $this->estructurarTablaInsumos();
                break;

            case 'Clientes':
                $this->nombreHTML = 'reports.clientes-report';
                $this->filtrarClientes();
                $this->estructurarTablaClientes();
                break;

            default:

                break;
        }
    }


    public function descargarPdf()
    {
        $this->filtrar(); // Asegúrate de que se han filtrado los movimientos antes de generar el PDF

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = view($this->nombreHTML, ['resultados' => $this->resultados])->render();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        try {
            return response()->streamDownload(function () use ($dompdf) {
                echo $dompdf->output();
            }, 'movimientos-reporte-' . Carbon::now()->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            dd('Error generating PDF: ' . $e->getMessage());
            //session()->flash('error', 'Error generating PDF. Please try again later.');
        }
    }


    public function mount()
    {
        $this->fecha['inicio'] = Carbon::now()->format('Y-m-d');
        $this->fecha['fin'] = Carbon::now()->format('Y-m-d');
        $this->consultaSeleccionada = 'Movimientos';
    }
    public function render()
    {
        return view('livewire.reportes');
    }
}
