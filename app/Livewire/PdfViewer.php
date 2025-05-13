<?php

namespace App\Livewire;

use App\Models\Report;
use App\Services\PDFGeneratorService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PdfViewer extends Component
{
    public Report $report;
    public bool $isGenerating = false;
    public bool $isFailed = false;
    public bool $pdfExists = false;
    public $number = 0;

    public function mount(Report $report)
    {
        $this->report = $report;
        $this->checkPdfStatus();
    }

    public function checkPdfStatus()
    {
        if (!$this->report->pdf_path || !Storage::exists('pdfs/' . $this->report->pdf_path)) {
            $this->pdfExists = false;
            return false;
        } else {
            $this->pdfExists = true;
            return true;
        }
    }

    public function add()
    {
        $this->number++;
    }

    public function regeneratePdf()
    {
        Log::info('Regenerating PDF');

        if ($this->isGenerating) {
            return;
        }

        $this->isGenerating = true;

        try {
            $result = app(PDFGeneratorService::class)->generate($this->report);
            $this->isFailed = !$result;
            $this->checkPdfStatus();
        } catch (\Exception $e) {
            Log::error("PDF generation failed: " . $e->getMessage());
            $this->isFailed = true;
        } finally {
            $this->isGenerating = false;
        }
    }

    public function generatePdfIfNeeded()
    {
        if (!$this->checkPdfStatus()) {
            $this->regeneratePdf();
        }
    }

    public function render()
    {
        return view('livewire.pdf-viewer');
    }
}
