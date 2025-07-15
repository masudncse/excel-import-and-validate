<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FailedRowsExport;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        // Read the first sheet as a collection
        $collection = Excel::toCollection(null, $request->file('file'))[0];
        $errors = [];
        $validRows = [];
        $invalidRows = [];

        // Get header row (first row)
        $header = null;
        foreach ($collection as $index => $row) {
            $rowValues = $row->toArray();
            if ($index === 0) {
                // First row is header
                $header = $rowValues;
                continue;
            }
            // Map row values to header keys
            $rowArray = [];
            foreach ($header as $colIdx => $colName) {
                $rowArray[$colName] = $rowValues[$colIdx] ?? null;
            }
            // Validate the row
            $validator = Validator::make($rowArray, [
                'name' => 'required|string',
                'email' => 'required|email',
                'age' => 'required|integer|min:0',
            ]);
            if ($validator->fails()) {
                // Add errors and row data for failed rows
                $invalidRows[] = array_merge($rowArray, ['errors' => $validator->errors()->toArray()]);
                // Row number in Excel = index + 1 (since index is 1-based for data rows)
                $errors[$index + 1] = $validator->errors()->toArray();
            } else {
                // Add to valid rows
                $validRows[] = $rowArray;
                // Save to DB if needed, e.g. Model::create($rowArray);
            }
        }

        // Optionally save validRows to DB here

        $failedFileUrl = null;
        if (count($invalidRows)) {
            $failedFileName = 'failed_rows_' . time() . '.xlsx';
            Excel::store(new FailedRowsExport($invalidRows), 'public/' . $failedFileName);
            $failedFileUrl = Storage::url($failedFileName);
        }

        // Return summary, errors, and failed rows download link
        return response()->json([
            'summary' => [
                'total' => count($collection) - 1, // exclude header
                'success' => count($validRows),
                'failed' => count($invalidRows),
            ],
            'errors' => $errors,
            'failed_rows_url' => $failedFileUrl,
        ]);
    }
}
