<?php

namespace App\Console\Commands;

use App\Models\Hotel;
use App\Models\Tour;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use function Functional\matching;

/**
 * Class TourCreateCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class TourCreateCommand extends Command
{
    const CHOICE_CREATE_NEW_HOTEL = 'Create new hotel';
    const PAGE_LIMIT = 5;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'tour:create {--hotel= : Connected hotel\'s ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new tour';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            with(
                intval($this->option('hotel')) ?:
                    with(
                        with(
                            Hotel::all(),
                            fn(Collection $hotels) => $this->table(
                                array_keys($hotels->first()->toArray()),
                                $hotels->toArray()
                            )
                        ),
                        fn() => with(
                            $this->choice('Which hotel do you choose?',
                                Hotel::all(['id', 'name'])->mapWithKeys(function ($hotel) {
                                    return [$hotel->id => $hotel->id];
                                })->all() + [0 => static::CHOICE_CREATE_NEW_HOTEL]),
                            fn($hotel_id) => matching([
                                [fn($hotel_id) => $hotel_id === static::CHOICE_CREATE_NEW_HOTEL, fn() => $this->call('hotel:create', ['--return' => true])],
                                [fn() => true, fn($hotel_id) => $hotel_id],
                            ])($hotel_id)
                        )
                    ),
                fn(int $hotel_id) => with(
                    (new Tour()),
                    fn(Tour $tour) => $tour->setRawAttributes([
                        'hotel_id' => $hotel_id,
                        'name' => $this->ask('What tour name is?'),
                        'type' => $this->ask('What tour type is?'),
                        'meals' => $this->ask('What tour meals is?'),
                        'price' => floatval($this->ask('What tour price is?')),
                        'start_date' => $this->ask('What tour start date is?'),
                        'end_date' => $this->ask('What tour end date is?'),
                    ])->save()
                        ? tap(
                            $this->info(sprintf('Your tour was successfully created. It\'s ID is %d.', $tour->id)),
                            $this->call('admin')
                        )
                        : tap(
                            $this->error('There was an error in your data.'),
                            $this->call('admin')
                        )
                )
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            $this->call('admin');
        }
    }
}
