<?php

namespace App\Console\Commands;

use App\Domains\Affiliate\Events\AffiliateProcessed;
use Illuminate\Console\Command;

class FakeAffiliateSignup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:affiliate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushes a message saying an affiliate has been signed up';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        AffiliateProcessed::dispatch(
            '5v3fbGZc2rAeuugiNFHUN5t5jD6tmUbuoZw7nmCmL6mp',
            'New affiliate just signed up',
        );
    }
}
