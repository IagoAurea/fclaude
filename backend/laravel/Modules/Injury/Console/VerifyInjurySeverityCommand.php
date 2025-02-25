<?php

namespace Modules\Injury\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Injury\Repositories\Interfaces\InjuryRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjurySeverityRepositoryInterface;

class VerifyInjurySeverityCommand extends Command
{
    /**
     * @var $injuryRepository
     */
    protected $injuryRepository;
     
    /**
     * @var $injurySeverityRepository
     */
    protected $injurySeverityRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'injury:severity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza grado de serveridad de las lesiones activas segun la fecha actual.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        InjuryRepositoryInterface $injuryRepository,
        InjurySeverityRepositoryInterface $injurySeverityRepository
    )
    {
        parent::__construct();

        $this->injuryRepository = $injuryRepository;
        $this->injurySeverityRepository = $injurySeverityRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $severities = $this->injurySeverityRepository->findAll();

        $injuries = $this->injuryRepository->findBy([
            'is_active' => TRUE,
            'deleted_at' => NULL
        ]);

        $now = Carbon::now();

        foreach($injuries as $injury) {
            $injury_date = Carbon::parse($injury->injury_date);

            $injury_days = $injury_date->diffInDays($now);

            $severity = $severities->first(function ($value, $key) use($injury_days) {
                return $injury_days <= $value->max && $injury_days >= $value->min;
            }); 

            $injury->injury_severity_id = isset($severity) ? $severity->id : 1;
            $injury->injury_day = $injury_days;
            $injury->save();
        }

        $message = 'Actualizacion de grado de severidad y dias de la lesion ejecutada sastifactoriamente, el ' . $now;
        \Log::info($message);
        $this->info($message);
    }

}
