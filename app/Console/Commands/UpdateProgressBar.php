<?php

namespace App\Console\Commands;

use App\Models\ClusterQuery;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateProgressBar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:progress {fileNum}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $queryFile = json_decode(Storage::disk('local')->get('xmlQueries.json'), true);

        $clusterQuery = ClusterQuery::find($queryFile['cluster_id']);
        $clusterQuery->countNowQueries = $this->argument('fileNum');
        $clusterQuery->save();

        return 0;
    }
}
