<?php

namespace App\Console\Commands;

use App\Enums\AdminActions;
use Illuminate\Console\Command;
use function Functional\concat;
use function Functional\with;
use function Functional\matching;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class AdminCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "admin";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Choose an action";


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        with(
            $this->choice('Which command do you choose?', AdminActions::asSelectArray()),
            fn($choice) => matching([
                [fn($choice) => $choice === AdminActions::getDescription(AdminActions::Help), fn() => $this->call('list')],
                [fn($choice) => $choice === AdminActions::getDescription(AdminActions::TourFind), fn() => $this->call('tour:find')],
                [fn($choice) => $choice === AdminActions::getDescription(AdminActions::TourCreate), fn() => $this->call('tour:create')],
                [fn($choice) => $choice === AdminActions::getDescription(AdminActions::HotelFind), fn() => $this->call('hotel:find')],
                [fn($choice) => $choice === AdminActions::getDescription(AdminActions::HotelCreate), fn() => $this->call('hotel:create')],
            ])($choice)
        );
    }
}
