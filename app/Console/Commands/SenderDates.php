<?php

namespace App\Console\Commands;

use App\Services\Dates\Events;
use Illuminate\Console\Command;

final class SenderDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:dates {pathPerson} {day?} {pastDay?} {nearestDay?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending events to subscribers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Events $events): int
    {
        $res = $events->send(
            empty($this->argument("day")) ? config("app.datetime") : new \DateTime($this->argument("day")),
            empty($this->argument("pastDay")) ? config("app.dates.past_day") : $this->argument("pastDay"),
            empty($this->argument("nearestDay")) ? config("app.dates.nearest_day") : $this->argument("nearestDay"),
            $this->argument("pathPerson")
        );

        if ($res === true) {
            $this->info('The command was successful!');
            return 0;
        } else {
            $this->error("The command failed with an error");
            return 1;
        }
    }
}
