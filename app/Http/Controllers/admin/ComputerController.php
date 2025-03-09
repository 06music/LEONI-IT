<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComputersImport;
use Log;
use PgSql\Lob;

class ComputerController extends Controller
{
    public function index()
    {
        $computers = Computer::with('site')->get();
        return inertia('Admin/Computers/Index', ['computers' => $computers]);
    }

    public function uploadExcel(Request $request)
    {
        try {
            // Validate file type (only allow Excel files)


            if (!$request->hasFile('file')) {
                return redirect()->back()->withErrors(['error' => 'No file uploaded.']);
            }

            $file = $request->file('file');

            Log::info('Uploading Excel File:', [
                'name' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            // Process the Excel file
            Excel::import(new ComputersImport, $file);

            return redirect()->back()->with('success', 'Excel file imported successfully.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                Log::error("Row {$failure->row()} failed validation:", $failure->errors());
            }
            return redirect()->back()->withErrors(['error' => 'Excel validation failed. Check logs for details.']);
        } catch (\Exception $e) {
            Log::error('Excel Import Error:', ['message' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Failed to import Excel file. Check logs for details.']);
        }
    }
    }




