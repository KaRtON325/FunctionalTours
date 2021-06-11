<?php

namespace App\Console\Commands;

use App\Enums\TourFindParameters;
use App\Models\Tour;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use function Functional\none;
use function Functional\concat;
use function Functional\with;
use function Functional\select;
use function Functional\true;
use function Functional\reject;
use function Functional\some;

/**
 * Class TourFindCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class TourFindCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'tour:find {--country= : Needed tour\'s country} {--type= : Needed tour\'s type} {--meals= : Needed tour\'s meals} {--hotel= : Needed tour\'s hotel name} {--none : Force all tour list}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find needed tour';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->option('none') !== NULL && none(TourFindParameters::getKeys(), fn($option) => $this->option(strtolower($option)))
                ? with(
                    $this->choice('Which parameter do you choose?', TourFindParameters::asSelectArray()),
                    fn($choice) => $choice !== TourFindParameters::getDescription(TourFindParameters::None)
                        ? with(
                            $this->ask('What value is?'),
                            fn($value) => $this->call('tour:find', [concat('--', strtolower($choice)) => $value])
                        )
                        : $this->call('tour:find', ['--none' => true])
                )
                : with(
                    (new Collection(select(Tour::all()->map(function(Tour $tour) { return $tour->setCountry($tour->hotel->country); }), fn(Tour $tour) => true([
                        some([empty($this->option('country')), $tour->country === $this->option('country')]),
                        some([empty($this->option('type')), $tour->type === $this->option('type')]),
                        some([empty($this->option('meals')), $tour->meals === $this->option('meals')]),
                        some([empty($this->option('hotel')), $tour->hotel->name === $this->option('hotel')]),
                    ]))))->whenEmpty(function() { $this->info('There is no tours found.'); exit; }),
                    fn(Collection $tours) => tap(
                        $this->table(
                            array_merge(reject(array_keys($tours->first()->toArray()), fn($header) => $header === 'hotel')),
                            $tours->each(function($tour) { unset($tour->hotel); })->toArray()
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
