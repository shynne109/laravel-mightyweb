<?php

namespace MightyWeb\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use MightyWeb\Services\JsonExportService;

class JsonExportController extends Controller
{
    /**
     * The JSON export service instance.
     *
     * @var JsonExportService
     */
    protected $jsonExportService;

    /**
     * Create a new controller instance.
     *
     * @param JsonExportService $jsonExportService
     */
    public function __construct(JsonExportService $jsonExportService)
    {
        $this->jsonExportService = $jsonExportService;
    }

    /**
     * Export configuration to JSON file.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function export(Request $request): RedirectResponse
    {
        try {
            $path = $this->jsonExportService->exportToFile();
            
            if ($path === false) {
                return back()->with('error', 'Failed to export configuration. Please try again.');
            }
            
            return back()->with('success', 'Configuration exported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Download the exported JSON file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|RedirectResponse
     */
    public function download()
    {
        try {
            $download = $this->jsonExportService->downloadJson();
            
            if ($download === false) {
                return back()->with('error', 'JSON file not found. Please export the configuration first.');
            }
            
            return $download;
        } catch (\Exception $e) {
            return back()->with('error', 'Download failed: ' . $e->getMessage());
        }
    }
}
