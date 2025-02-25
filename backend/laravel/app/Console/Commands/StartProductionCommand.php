<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartProductionCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'fisical:init-prod';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Ejecuta las migraciones y seeders del sistema con los datos iniciales del proyecto fisicalcoach';

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
      'Tutorship'
    ];

    //Seeder by modules executed
    $seeders = [
      'Generality' => [
        'CountriesTableSeeder',
        'ProvincesTableSeeder',
        'JobsAreaTableSeeder',
        'KinshipsTableSeeder',
        'StudyLevelsTableSeeder',
        'SeasonsTableSeeder',
        'WeathersTableSeeder',
        'WeekDayTableSeeder',
        'TaxTableSeeder',
        'SplashTableSeeder',
        'BusinessTableSeeder',
        'TypeNotificationsTableSeeder'
      ],
      'Sport' => [
        'SportsTableSeeder',
        'SportsPositionsTableSeeder',
        'SportPositionSpecTableSeeder'
      ],
      'User' => [
        'RolesTableSeeder',
        'PermissionsTableSeeder',
        'UsersProdTableSeeder'
      ],
      'Activity' => [
        'ActivityTypeTableSeeder'
      ],
      'Family' => [
        'FamilyMemberTypeTableSeeder'
      ],
      'Package' => [
        'PackagesTableSeeder',
        'AttributesPackTableSeeder',
        'SubpackagesTableSeeder',
        'AttributesSubpackageTableSeeder',
        'PackagesPriceTableSeeder',
        'SubpackageSportsTableSeeder'
      ],
      'Club' => [
        'PermissionTableSeeder',
        'ClubTypeTableSeeder',
        'ClubUserTypeTableSeeder',
        'PositionStaffTableSeeder',
        'SchoolCenterTypeTableSeeder'
      ],
      'Team' => [
        'TeamsTypeTableSeeder',
        'TeamsModalityTableSeeder',
        'TypeLineupsTableSeeder',
        'ActivityTypeTableSeeder',
      ],
      'Player' => [
        'LineupPlayerTypeTableSeeder',
        'ClubArrivalTypeTableSeeder',
        'PunctuationTableSeeder',
        'SkillsTableSeeder'
      ],
      'Competition' => [
        'TypeCompetitionsTableSeeder',
        'TypeCompetitionSportsTableSeeder',
        'TestCategoriesMatchTableSeeder',
        'TestTypeCategoriesMatchTableSeeder',
        'TypeModalitiesMatchTableSeeder'
      ],
      'Nutrition' => [
        'SupplementsTableSeeder',
        'DietsTableSeeder',
        'ActivityTypeTableSeeder',
        'NutritionalSheetTableSeeder' #
      ],
      'Scouting' => [
        'ActionsTableSeeder'
      ],
      'Psychology' => [
        'PsychologySpecialistsTableSeeder'
      ],
      'Test' => [
        'TestTypeTableSeeder',
        'TypeValorationTableSeeder',
        'UnitTableSeeder',
        'TestSubTypeTableSeeder',
        'ConfigurationTableSeeder',
        'QuestionTableSeeder',
        'ResponseTableSeeder',
        'UnitGroupTableSeeder',
        'TestTableSeeder',
        'FormulaTableSeeder'
      ],
      'Health' => [
        'DiseasesTableSeeder',
        'AllergiesTableSeeder',
        'PhysicalProblemsTableSeeder',
        'TypeMedicinesTableSeeder',
        'AlcoholConsumptionsTableSeeder',
        'TobaccoConsumptionsTableSeeder',
        'AreasBodyTableSeeder'
      ],
      'Injury'=> [
        'ClinicalTestTypeTableSeeder',
        'InjuryTypeTableSeeder',
        'InjuryTypeSpecTableSeeder',
        'InjuryLocationTableSeeder',
        'InjurySituationTableSeeder',
        'MechanismsInjuryTableSeeder',
        'InjuryExtrinsicFactorTableSeeder',
        'InjuryIntrinsicFactorTableSeeder',
        'InjurySeverityTableSeeder',
        'CurrentSituationTableSeeder',
        'QuestionCategoryTableSeeder',
        'QuestionTableSeeder', #
        'PhaseTableSeeder',
        'ResponseTableSeeder', #
        'TestTableSeeder',
        'ReinstatementCriteriaTableSeeder',
        'InjurySeverityLocationTableSeeder'
      ],
      'Fisiotherapy' => [
        'TreatmentTableSeeder',
        'TestTableSeeder'
      ],
      'InjuryPrevention' => [
        'PreventiveProgramTypeTableSeeder',
        'EvaluationQuestionTableSeeder'
      ],
      'Exercise' => [
        'DistributionExercisesTableSeeder',
        'ContentsExerciseTableSeeder',
        'ExerciseContentBlockTableSeeder',
        'ExerciseEducationLevelTableSeeder'
      ],
      'Training' => [
        'TypeExerciseSessionsTableSeeder',
        'TrainingPeriodsTableSeeder',
        'SubContentSesionsTableSeeder',
        'SubjecPerceptEffortTableSeeder',
        'TargetSessionsTableSeeder',
        'ActivityTypeTableSeeder',
        'TestTableSeeder'
      ],
      'Calculator' => [
        'CalculatorDatabaseSeeder'
      ],
      'EffortRecovery' => [
        'EffortRecoveryStrategyTableSeeder',
        'WellnessQuestionnaireAnswerTypeTableSeeder',
        'WellnessQuestionnaireAnswerItemTableSeeder'
      ],
      'Classroom' => [
        'AgeTableSeeder',
        'SubjectTableSeeder',
        'TeacherAreaTableSeeder'
      ],
      'Alumn' => [
        'AcneaeTableSeeder'
      ],
      'AlumnControl' => [
        'DailyControlItemTableSeeder'
      ],
      'Evaluation' => [
        'CompetenceSeeder'
      ],
      'Tutorship' => [
        'SpecialistReferralSeeder',
        'TutorshipTypesSeeder'
      ]
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

    // Then call every seeder depending on the order setted before
    foreach ($seeders as $module => $modules) {
      foreach ($modules as $seed) {
        $this->info($module.'/'.$seed);

        $this->call("db:seed", [
          "--class" => "Modules\\{$module}\\Database\\Seeders\\{$seed}"
        ]);
      }


    }

    return Command::SUCCESS;
  }
}
