<?php

namespace Naimul\DbVisualizer\Http\Controllers;

use Illuminate\Http\Request;
use Naimul\DbVisualizer\Services\ModelScannerService;

class VisualizerController extends Controller
{
    protected $scanner;

    public function __construct(ModelScannerService $scanner)
    {
        $this->scanner = $scanner;
    }

    public function index()
    {
        return view('dbv::visualizer.index');
    }

    public function data(Request $request)
    {
        $data = $this->scanner->scan();

        $search = $request->get('search');

        if ($search) {
            $data = array_values(array_filter($data, function ($item) use ($search) {
                return str_contains(
                    strtolower($item['model']),
                    strtolower($search)
                );
            }));
        }

        return response()->json($data);
    }

    public function detail($model)
    {
        $data = collect($this->scanner->scan())->firstWhere('model', $model);
        if (!$data) {
            return response()->json(['message' => 'Model not found'], 404);
        }

        return response()->json($data);
    }
}