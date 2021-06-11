<?php

namespace App\Console\Commands;

use App\Models\Hotel;
use Exception;
use Illuminate\Console\Command;

/**
 * Class TourCreateCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class HotelCreateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'hotel:create {--return : Should tour:create be called}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new hotel';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            with(
                (new Hotel()),
                fn(Hotel $hotel) => $hotel->setRawAttributes([
                    'name' => $this->ask('What hotel name is?'),
                    'stars' => $this->ask('How mush stars does hotel have?'),
                    'country' => $this->ask('What hotel country is?'),
                    'city' => $this->ask('What hotel city is?'),
                    'address' => $this->ask('What hotel address is?'),
                ])->save()
                    ? tap(
                        $this->info(sprintf('Your hotel was successfully created. It\'s ID is %d.', $hotel->id)),
                        $this->option('return') !== NULL
                            ? $this->call('tour:create', ['--hotel' => $hotel->id])
                            : $this->call('admin')
                    )
                    : tap(
                        $this->error('There was an error in your data.'),
                        $this->call('admin')
                    )
            );
        } catch (Exception $e) {
            $this->error($e->getMessage());
            $this->call('admin');
        }
    }
}
