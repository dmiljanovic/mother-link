<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportFileRequest;
use App\Jobs\ImportFileJob;
use App\Services\FileService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class HomeController
 * @package App\Http\Controllers\Download
 */
class FileController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

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

    public function importFile(ImportFileRequest $request): void
    {
        $file = $request->file('file');

        $filePath = $this->fileService->storeFile($file);

        dispatch(new ImportFileJob(storage_path('/app/public/').$filePath));
    }
}
