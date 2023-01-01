<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:credits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset credit for each users';

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
        User::where('type', 'regular')->update(['credit' => 20]);
        User::where('type', 'premium')->update(['credit' => 40]);

        $this->info('[' . date('Y-m-d m:s:') . '] Credit users has been reseted.');
    }
}
