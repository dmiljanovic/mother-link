<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class HomeController
 * @package App\Http\Controllers\Download
 */
class FileController extends Controller
{
    /**
     * @return BinaryFileResponse
     */
    public function downloadFile(): BinaryFileResponse
    {
        $file= public_path(). "/download/ImportSheet.csv";

        $headers = array(
            'Content-Type: application/scv',
        );

        return Response::download($file, 'ImportSheet.csv', $headers);
    }

    public function importFile(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('index');
    }
}
