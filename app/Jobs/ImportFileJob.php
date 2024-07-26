<?php

namespace App\Jobs;

use App\Events\ImportNotification;
use App\Imports\MediaImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $file;

    /**
     * Create a new job instance.
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new MediaImport())->import($this->file, null, \Maatwebsite\Excel\Excel::CSV);

        $response = [];

        event(new ImportNotification(json_encode($response)));
    }
}
