<?php

namespace App\Livewire;

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
        } else {
            $this->isGenerating = false;
        }
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
