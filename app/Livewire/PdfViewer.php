<?php

namespace App\Livewire;

use App\Jobs\GenerateReportPDF;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PdfViewer extends Component
{
    public Report $report;

    public bool $isGenerating = true;

    public function checkPdfStatus()
    {
        if (!$this->report->pdf_path || !Storage::exists('pdfs/' . $this->report->pdf_path)) {
            $this->isGenerating = true;
            GenerateReportPDF::dispatch($this->report);
        } else {
            $this->isGenerating = false;
        }
    }

    public function getReportIdProperty()
    {
        return $this->report->id;
    }

    public function pdfHasGenerated()
    {
        $this->isGenerating = false;
    }

    public function mount(Report $report)
    {
        $this->report = $report;
    }

    public function render()
    {
        return view('livewire.pdf-viewer');
    }
}
