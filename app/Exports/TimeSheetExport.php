<?php

namespace App\Exports;

use App\Enums\ProjectType;
use App\Models\{Client, TimeEntry};
use Maatwebsite\Excel\Concerns\{FromCollection, WithColumnFormatting, WithHeadings, WithMapping, WithStyles};
use PhpOffice\PhpSpreadsheet\Style\{Border, NumberFormat};
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TimeSheetExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting
{
    public function __construct(private Carbon $from, private Carbon $to, private Client $client, private bool $bucketProjectsOnly = false)
    {
    }

    public function headings(): array
    {
        return [
            'Project',
            'Client',
            'Description',
            'Task',
            'Start Date',
            'Start Time',
            'End Date',
            'End Time',
            'Duration (h)',
            'Duration (decimal)',
        ];
    }

    public function map($row): array
    {
        return [
            $row->project->name,
            $row->project->client->name,
            $row->description,
            $row->task_name,
            $row->time_interval_start->format('d-m-Y'),
            $row->time_interval_start->format('H:i'),
            $row->time_interval_end->format('d-m-Y'),
            $row->time_interval_end->format('H:i'),
            $row->duration ? gmdate('H:i:s', $row->duration) : '00:00:00',
            $row->duration_rounded
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {
        $projectQuery = $this->client->projects();

        if ($this->bucketProjectsOnly) {
            $projectQuery->where('project_type', ProjectType::BUCKET);
        }

        $projects = $projectQuery->get();

        $query = TimeEntry::whereDate('time_interval_start', '>=', $this->from)
            ->whereDate('time_interval_end', '<=', $this->to)
            ->whereIn('clockify_project_id', $projects->pluck('clockify_project_id'));

        return $query->orderByDesc('time_interval_start')->get()
            ->map(function ($row) {
                $row->duration_rounded = (float) str_replace(',', '.', $row->duration_decimal);

                return $row;
            });
    }

    public function styles(Worksheet $sheet)
    {
        $headings = $this->headings();
        $lastColumn = Coordinate::stringFromColumnIndex(count($headings));

        // Bold headings and add border
        $sheet->getStyle("A1:{$lastColumn}1")
            ->getFont()->setBold(true);
        $sheet->getStyle("A1:{$lastColumn}1")
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        foreach (range(1, count($headings)) as $col) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }

        // Optional: add SUM formula at the bottom of the duration column
        $lastRow = $sheet->getHighestRow();
        $sheet->setCellValue("J" . ($lastRow + 1), "=SUM(J2:D{$lastRow})");
        $sheet->getStyle("J" . ($lastRow + 1))->getFont()->setBold(true);
    }

    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_NUMBER_00, // Duration column with 2 decimals
        ];
    }
}
