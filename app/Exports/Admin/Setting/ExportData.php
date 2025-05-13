<?php

namespace App\Exports\Admin\Setting;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ExportData extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithCustomValueBinder
{
    use Exportable;
    protected $data;
    protected $headers;
    protected $mapping;

    public function __construct(Collection $data, array $headers, array $mapping)
    {
        $this->data = $data;
        $this->headers = $headers;
        $this->mapping = $mapping;
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() === 'A' || is_numeric($value)) {
            // Simpan sebagai string
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function map($row): array
    {
        $mappedData = [];
        foreach ($this->mapping as $key => $value) {
            if (is_callable($value)) {
                $mappedData[] = $value($row);
            } else {
                $mappedData[] =  $row->{$value} ?? null;
            }
        }
        return $mappedData;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
