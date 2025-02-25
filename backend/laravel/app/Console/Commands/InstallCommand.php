<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fisical:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicializa el sistema con los datos de pruebas del proyecto fisicalcoach';

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
     * @return void
     */
    public function handle()
    {
        // Used to preset the order in which every module shall be executed
        $modules = [
            'Generality',
            'Sport',
            'Address',
            'User',
            'Activity',
            'Family',
            'Package',
            'Subscription',
            'Payment',
            'Club',
            'Team',
            'Staff',
            'Player',
            'Competition',
            'Nutrition',
            'Scouting',
            'Psychology',
            'Test',
            'Health',
            'Injury',
            'Fisiotherapy',
            'InjuryPrevention',
            'Exercise',
            'Training',
            'Calculator',
            'EffortRecovery',
            'Classroom',
            'Alumn',
            'AlumnControl',
            'Evaluation',
            'Qualification',
            'Tutorship',
        ];

        // Reset all migrations
        $this->call("migrate:reset");

        // Migrate all modules
        foreach ($modules as $module) {
            $this->call("module:migrate", ['module' => $module]);
        }

        // Then migrate base dependencies
        $this->call("migrate");
        $this->call("passport:install");
        $this->call("db:seed");

        // Then call every module seeder depending on the order setted before
        foreach ($modules as $module) {
            $this->call("module:seed", ['module' => $module]);
        }
    }
}
