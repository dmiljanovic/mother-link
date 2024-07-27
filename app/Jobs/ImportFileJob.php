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
        (new MediaImport())->import($this->file);

        $result['total_count'] = session()->get('total_count');
        $result['total_imported'] = session()->get('total_imported');
        $result['import_statuses'] = session()->get('import_statuses');

        event(new ImportNotification(json_encode($result)));

        session()->forget('total_count');
        session()->forget('total_imported');
        session()->forget('import_statuses');
    }
}
