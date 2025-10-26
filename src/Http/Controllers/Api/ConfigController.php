<?php

namespace MightyWeb\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use MightyWeb\Services\JsonExportService;

class ConfigController extends Controller
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
     * Get full app configuration.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $config = $this->jsonExportService->generateConfig();
            
            return response()->json([
                'success' => true,
                'data' => $config,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate configuration',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get app settings only.
     *
     * @return JsonResponse
     */
    public function appSettings(): JsonResponse
    {
        try {
            $config = $this->jsonExportService->generateConfig();
            
            return response()->json([
                'success' => true,
                'data' => $config['app_settings'] ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get app settings',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get walkthrough screens.
     *
     * @return JsonResponse
     */
    public function walkthrough(): JsonResponse
    {
        try {
            $config = $this->jsonExportService->generateConfig();
            
            return response()->json([
                'success' => true,
                'data' => $config['walkthrough'] ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get walkthrough',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get menu items.
     *
     * @return JsonResponse
     */
    public function menu(): JsonResponse
    {
        try {
            $config = $this->jsonExportService->generateConfig();
            
            return response()->json([
                'success' => true,
                'data' => $config['menu'] ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get menu',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get tabs.
     *
     * @return JsonResponse
     */
    public function tabs(): JsonResponse
    {
        try {
            $config = $this->jsonExportService->generateConfig();
            
            return response()->json([
                'success' => true,
                'data' => $config['tabs'] ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get tabs',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get pages.
     *
     * @return JsonResponse
     */
    public function pages(): JsonResponse
    {
        try {
            $config = $this->jsonExportService->generateConfig();
            
            return response()->json([
                'success' => true,
                'data' => $config['pages'] ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get pages',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get theme configuration.
     *
     * @return JsonResponse
     */
    public function theme(): JsonResponse
    {
        try {
            $config = $this->jsonExportService->generateConfig();
            
            return response()->json([
                'success' => true,
                'data' => $config['theme'] ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get theme',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}

