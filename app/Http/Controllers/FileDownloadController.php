<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileDownloadController extends Controller
{
    public function downloadRateSnap($filename)
    {
        $filePath = public_path('resources/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        dd("notworking");
    }

    public function downloadResume($filename)
    {
        $filePath = public_path('resources/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        dd("File not found");
    }

    public function downloadBgvs($filename)
    {
        $filePath = public_path('resources/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404);
        }
    }

    public function downloadVisa($filename)
    {
        $filePath = public_path('resources/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        dd("notworking");
    }

    public function downloadLicense($filename)
    {
        $filePath = public_path('resources/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        dd("File not found");
    }

    public function downloadPassport($filename)
    {
        $filePath = public_path('resources/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        dd("File not found");
    }

    public function downloadActivity($filename)
    {
        $filePath = public_path('sign-of-sheet/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404);
        }
    }

    public function proofDownload($filename)
    {
        $filePath = public_path('pdfs/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404);
        }
    }

    public function formNdaDownload($filename)
    {
        $filePath = public_path('client-nda/' . $filename); 
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404);
        }
    }
}
