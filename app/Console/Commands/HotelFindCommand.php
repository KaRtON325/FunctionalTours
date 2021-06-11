<?php

namespace App\Console\Commands;

use App\Enums\HotelFindParameters;
use App\Models\Hotel;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use function Functional\none;
use function Functional\concat;
use function Functional\with;
use function Functional\select;
use function Functional\true;
use function Functional\some;

/**
 * Class HotelFindCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class HotelFindCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'hotel:find {--name= : Needed hotel\'s name} {--stars= : Needed hotel\'s stars} {--country= : Needed hotel\'s country} {--city= : Needed hotel\'s city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find needed hotel';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->option('none') !== none(HotelFindParameters::getKeys(), fn($option) => $this->option(strtolower($option)))
                ? with(
                $this->choice('Which parameter do you choose?', HotelFindParameters::asSelectArray()),
                fn($choice) => with(
                    $this->ask('What value is?'),
                    fn($value) => $this->call('hotel:find', [concat('--', strtolower($choice)) => $value])
                )
            )
                : with(
                (new Collection(select(Hotel::all(), fn(Hotel $hotel) => true([
                    some([empty($this->option('name')), $hotel->name === $this->option('name')]),
                    some([empty($this->option('stars')), $hotel->stars === $this->option('type')]),
                    some([empty($this->option('country')), $hotel->meals === $this->option('meals')]),
                    some([empty($this->option('city')), $hotel->hotel->name === $this->option('hotel')]),
                ]))))->whenEmpty(function() { $this->info('There is no hotels found.'); exit; }),
                fn(Collection $hotels) => tap(
                    $this->table(
                        array_keys($hotels->first()->toArray()),
                        $hotels->toArray()
                    ),
                    fn() => $this->call('admin')
                )
            );
        } catch (Exception $e) {
            $this->error($e->getMessage());
            $this->call('admin');
        }
    }
}
