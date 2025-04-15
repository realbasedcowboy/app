<?php

namespace App\Domains\Airdrop\Jobs;

use App\Domains\Airdrop\Models\Airdrop;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeactivateAirdropJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Airdrop $airdrop
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->airdrop->deactivate();
    }
}
