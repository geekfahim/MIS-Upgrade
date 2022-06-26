<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JeebikaFamilyMultipleExcelReport implements WithMultipleSheets
{
    public function __construct(protected string $report, protected array $data)
    {
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->data['families'] as $family) {
            $family['project_name'] = $this->data['project_name'];
            $family['gro'] = $this->data['gro'];
            $family['isImageNeed'] = false;
            if (isset($this->data['from_date']) && isset($this->data['to_date'])) {
                $family['from_date'] = $this->data['from_date'];
                $family['to_date'] = $this->data['to_date'];
            }
            $sheets[] = new JeebikaFamilySingleReport($this->report, $family);
        }
        return $sheets;
    }
}
