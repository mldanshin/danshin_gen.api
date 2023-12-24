<?php

namespace App\Console\Commands;

use App\Support\SubscriptionCode;
use Illuminate\Console\Command;

final class SubscriberCodeClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears old code subscription';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(SubscriptionCode $support): int
    {
        $res = $support->clear();
        if ($res === true) {
            $this->info('The command code:clear was successful!');
            return 0;
        } else {
            $this->error("the command failed with an error");
            return 1;
        }
    }
}
