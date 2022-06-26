<?php

namespace App\Exports;

use App\Models\Base\Mustahiq\Mustahiq;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class JeebikaFamilySingleReport implements FromView, ShouldAutoSize, WithTitle, WithDrawings
{

    public function __construct(protected $report, protected $data)
    {
    }

    public function drawings(): Drawing
    {
        $path = $this->data->head->resource ? "storage/" . Mustahiq::RESOURCE_PATH . '/' . $this->data->head->resource->name : getDefaultAvatar();
        $drawing = new Drawing();
        $drawing->setName('Mustahiq');
        $drawing->setDescription('Mustahiq Family Head');
        $drawing->setPath(public_path($path));
        $drawing->setHeight(100);
        $drawing->setWidth(100);
        $drawing->setCoordinates('E2');
        return $drawing;
    }

    public function title(): string
    {
        return isset($this->data->name) ? str_replace('\'s family', '', $this->data->name) : "";
    }

    public function view(): View
    {
        return view($this->report, ['data' => $this->data]);
    }
}
