<?php

namespace App\Domains\Deposit\Jobs;

use App\Domains\Deposit\Actions\ProcessDepositAction;
use App\Domains\Deposit\Models\Deposit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessDepositJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Deposit $deposit
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app(ProcessDepositAction::class)(
            deposit: $this->deposit,
        );
    }
}
