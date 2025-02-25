<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title=" API fisicalcoach",
     *      description="fisicalcoach API Documentation",
     *      @OA\Contact(
     *          email="german.dev@appyweb.es"
     *      ),
     *      @OA\License(
     *          name="Owner",
     *          url="http://www.appyweb.es"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="API Server"
     * )
     *
     * @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      description="Login with email and password to get the authentication token",
     *      in="header",
     *      name="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     * )
     *
     * @OA\Parameter(
     *  parameter="_locale",
     *  description="Field locale translations, send (es) for Spanish and (en) for English",
     *  in="query",
     *  name="_locale",
     *  required=false,
     *  @OA\Examples(example="en", value="en", summary="English"),
     *  @OA\Examples(example="es", value="es", summary="Spanish"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="timezone",
     *  description="Field timezone",
     *  in="query",
     *  name="timezone",
     *  required=false,
     *  @OA\Examples(example="Europe/Madrid", value="Europe/Madrid", summary="Europe/Madrid"),
     *  @OA\Examples(example="America/Caracas", value="America/Caracas", summary="America/Caracas"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="external",
     *  description="Field locale translations, send (es) for Spanish and (en) for English",
     *  in="path",
     *  name="external",
     *  required=true,
     *  @OA\Examples(example="external", value="external", summary="External"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="per_page",
     *  description="Field to number register per page pagination",
     *  in="query",
     *  name="per_page",
     *  required=false,
     *  example=20,
     *  @OA\Schema(
     *     type="integer"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="page",
     *  description="Field to number page pagination",
     *  in="query",
     *  name="page",
     *  required=false,
     *  example=1,
     *  @OA\Schema(
     *     type="integer"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="search",
     *  description="Field to search in list",
     *  in="query",
     *  name="search",
     *  required=false,
     *  example="string",
     *  @OA\Schema(
     *     type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="order",
     *  description="Field sort the list",
     *  in="query",
     *  name="order",
     *  required=false,
     *  @OA\Examples(
     *      example="asc", value="asc", summary="Ascendent order"
     *  ),
     *  @OA\Examples(
     *      example="desc", value="desc", summary="Descendent order"
     *  ),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="active",
     *  description="Checks if active or not",
     *  in="query",
     *  name="active",
     *  required=false,
     *  @OA\Examples(
     *      example="true", value="true", summary="True value"
     *  ),
     *  @OA\Examples(
     *      example="false", value="false", summary="False value"
     *  ),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="all_statistics",
     *  description="Retrieve all statistics or not by default true",
     *  in="query",
     *  name="all_statistics",
     *  required=false,
     *  @OA\Examples(
     *      example="true", value="true", summary="True value"
     *  ),
     *  @OA\Examples(
     *      example="false", value="false", summary="False value"
     *  ),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="entity",
     *  description="Field type entity",
     *  in="path",
     *  name="entity",
     *  required=true,
     *  @OA\Examples(example="player", value="player", summary="Player"),
     *  @OA\Examples(example="alumn", value="alumn", summary="Alumn"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="type_profile",
     *  description="Type profile activities",
     *  in="query",
     *  name="type_profile",
     *  required=false,
     *  @OA\Examples(
     *      example="sport", value="sport", summary="Sport value"
     *  ),
     *  @OA\Examples(
     *      example="teacher", value="teacher", summary="Teacher value"
     *  ),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="list_all",
     *  description="Checks if must list every staff users or not (valid for Club entities only)",
     *  in="query",
     *  name="list_all",
     *  required=false,
     *  @OA\Examples(
     *      example="true", value="true", summary="True value"
     *  ),
     *  @OA\Examples(
     *      example="false", value="false", summary="False value"
     *  ),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="scouting",
     *  description="Determines if scouting must be a parameter to be selected.
     *  All sports may be returned it this parameter is not sent",
     *  in="query",
     *  name="scouting",
     *  required=false,
     *  @OA\Examples(example="", value="", summary="All sports"),
     *  @OA\Examples(example="true", value="true", summary="Only scouting related sports"),
     *  @OA\Examples(example="false", value="false", summary="Only NOT scouting related sports"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="sports",
     *  description="Sports list",
     *  in="query",
     *  name="sport",
     *  required=false,
     *  @OA\Examples(example="football", value="football", summary="Football"),
     *  @OA\Examples(example="basketball", value="basketball", summary="Basketball"),
     *  @OA\Examples(example="handball", value="handball", summary="Handball"),
     *  @OA\Examples(example="indoor_soccer", value="indoor_soccer", summary="Indoor soccer"),
     *  @OA\Examples(example="volleyball", value="volleyball", summary="Volleyball"),
     *  @OA\Examples(example="beach_volleyball", value="beach_volleyball", summary="Beach Volleyball"),
     *  @OA\Examples(example="badminton", value="badminton", summary="Badminton"),
     *  @OA\Examples(example="tennis", value="tennis", summary="Tennis"),
     *  @OA\Examples(example="padel", value="padel", summary="Pádel"),
     *  @OA\Examples(example="roller_hockey", value="roller_hockey", summary="Roller Hockey"),
     *  @OA\Examples(example="field_hockey", value="field_hockey", summary="Field Hockey"),
     *  @OA\Examples(example="ice_hockey", value="ice_hockey", summary="Ice Hockey"),
     *  @OA\Examples(example="rugby", value="rugby", summary="Rugby"),
     *  @OA\Examples(example="baseball", value="baseball", summary="Baseball"),
     *  @OA\Examples(example="cricket", value="cricket", summary="Cricket"),
     *  @OA\Examples(example="swimming", value="swimming", summary="Swimming"),
     *  @OA\Examples(example="waterpolo", value="waterpolo", summary="Waterpolo"),
     *  @OA\Examples(example="american_soccer", value="american_soccer", summary="American Soccer"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="entity_name",
     *  description="Type entity name for Test",
     *  in="query",
     *  name="entity_name",
     *  required=false,
     *  @OA\Examples(example="test", value="test", summary="Test"),
     *  @OA\Examples(example="rfd", value="rfd", summary="RFD"),
     *  @OA\Examples(example="fisiotherapy", value="fisiotherapy", summary="fisiotherapy"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="type_test_exercise",
     *  description="Field type test exercise",
     *  in="path",
     *  name="type_test_exercise",
     *  required=true,
     *  @OA\Examples(example="frecuency_cardiac", value="frecuency_cardiac", summary="Frecuencia cardiaca"),
     *  @OA\Examples(example="gps", value="gps", summary="Gps"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="filter",
     *  description="Field to filter list",
     *  in="query",
     *  name="Filter",
     *  required=false,
     *  example="type",
     *  @OA\Schema(
     *     type="string"
     *  )
     * )
     * @OA\Parameter(
     *  parameter="value",
     *  description="Field value to the filter",
     *  in="query",
     *  name="value",
     *  required=false,
     *  example="",
     *  @OA\Schema(
     *     type="string"
     *  )
     * )
     * @OA\Parameter(
     *  parameter="sport_id",
     *  description="Identificator of a sport",
     *  in="query",
     *  name="sport_id",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *     type="string"
     *  )
     * )
     * @OA\Parameter(
     *  parameter="id_path",
     *  description="Identificator of path",
     *  in="path",
     *  name="id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *     type="string"
     *  )
     * )
     * @OA\Parameter(
     *  parameter="code",
     *  description="Code to identify entity",
     *  in="path",
     *  name="code",
     *  required=true,
     *  example="code",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="modality_code",
     *  description="Code to identify modality",
     *  in="path",
     *  name="modality_code",
     *  required=false,
     *  example="code",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="school_center_id",
     *  description="Identificator of a school center",
     *  in="path",
     *  name="school_center_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="team_id",
     *  description="Identificator of the team",
     *  in="path",
     *  name="team_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     * @OA\Parameter(
     *  parameter="team_query_id",
     *  description="Identificator of the team",
     *  in="query",
     *  name="team_id",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="team_id_nr",
     *  description="Identificator of the team",
     *  in="query",
     *  name="team_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="subpackage_id",
     *  description="Identificator of the subpackage",
     *  in="path",
     *  name="subpackage_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="package_id",
     *  description="Identificator of the package",
     *  in="path",
     *  name="package_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="int"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="type",
     *  description="Code of the package",
     *  in="query",
     *  name="type",
     *  required=true,
     *  @OA\Examples(
     *      example="sport", value="sport", summary="Sport value"
     *  ),
     *  @OA\Examples(
     *      example="teacher", value="teacher", summary="Teacher value"
     *  ),
     * )
     *
     * @OA\Parameter(
     *  parameter="subpackage",
     *  description="Code of the subpackage (bronze, silver, gold)",
     *  in="query",
     *  name="subpackage",
     *  required=true,
     *  example="bronze",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="licenses",
     *  description="Number licenses",
     *  in="query",
     *  name="licenses",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="integer"
     *  )
     * )
     *
     *  @OA\Parameter(
     *   parameter="period",
     *   description="Period subscription",
     *   in="query",
     *   name="period",
     *   required=true,
     *   @OA\Examples(
     *      example="month", value="month", summary="Month value"
     *   ),
     *   @OA\Examples(
     *      example="year", value="year", summary="Year value"
     *   ),
     * )
     *
     * @OA\Parameter(
     *  parameter="file_id",
     *  description="Identificator of the file",
     *  in="path",
     *  name="file_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="daily_work_id",
     *  description="Identificator of the daily work",
     *  in="path",
     *  name="daily_work_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="player_id",
     *  description="Identificator of the player",
     *  in="path",
     *  name="player_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="contract_id",
     *  description="Identificator of the player contract",
     *  in="path",
     *  name="contract_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="injury_id",
     *  description="Identificator of the injury",
     *  in="path",
     *  name="injury_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="player_name",
     *  description="Name of the player",
     *  in="query",
     *  name="player_name",
     *  required=false,
     *  example="nathanael",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="injury_prevention_id",
     *  description="Identificator of the injury prevention program",
     *  in="path",
     *  name="injury_prevention_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="injury_type_id",
     *  description="Identificator of the injury type",
     *  in="path",
     *  name="injury_type_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="effort_recovery_id",
     *  description="Identificator of the effort recovery program
     *  - Identificador de programa de recuperacion del esfuerzo",
     *  in="path",
     *  name="effort_recovery_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="strategy_id",
     *  description="Identificator of the effort recovery strategy
     *  - Identificador de la estrategia programa de recuperacion del esfuerzo",
     *  in="query",
     *  name="strategy_id",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="questionnaire_item_type",
     *  description="Identificator of the questionnaire item type
     *  - Identificador de tipo de item de pregunta de questionario",
     *  in="path",
     *  name="questionnaire_item_type",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="calculator_history_id",
     *  description="Identificator of the calculation historic item - Identificador de historico de calculo reaizado",
     *  in="path",
     *  name="calculator_history_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="entity_id",
     *  description="Identificator of a polymorphic used entity
     *  - Identificador de tipo polimorfico para cuaquier entidad utilizada",
     *  in="path",
     *  name="entity_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="license_code",
     *  description="License unique uuid - Uuid de licencia unico",
     *  in="path",
     *  name="license_code",
     *  required=true,
     *  example="a342h-h34g32-hdsvb=bsadv-k5rk4",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="nutritional_sheet_id",
     *  description="Identificator of the nutritional sheet - Identificador de la ficha nutricional",
     *  in="path",
     *  name="nutritional_sheet_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     * @OA\Parameter(
     *  parameter="age_id",
     *  description="Identifier of the age associated to the resource",
     *  in="path",
     *  name="age_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     * @OA\Parameter(
     *  parameter="diet_id",
     *  description="Identificator of the diet - Identificador de la dieta",
     *  in="path",
     *  name="diet_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="supplement_id",
     *  description="Identificator of the supplement - Identificador del suplemento",
     *  in="path",
     *  name="supplement_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="exercise_session_code",
     *  description="Identificator of the exercise session",
     *  in="path",
     *  name="exercise_session_code",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="content_exercise_code",
     *  description="Identificator of the content exercise",
     *  in="path",
     *  name="content_exercise_code",
     *  required=true,
     *  @OA\Examples(example="technicians", value="technicians", summary="Technicians"),
     *  @OA\Examples(example="tactical", value="tactical", summary="Tactical"),
     *  @OA\Examples(example="physical_preparation", value="physical_preparation", summary="Physical Preparation"),
     *  @OA\Examples(example="psychosocial", value="psychosocial", summary="Psychosocial"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="subject_id",
     *  description="Identifier of the subject associated to the resource",
     *  in="path",
     *  name="subject_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="subject_code",
     *  description="Code of the subject associated to the resource",
     *  in="path",
     *  name="subject_code",
     *  required=true,
     *  example="math",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="sub_content_session_code",
     *  description="Identificator of the sub content exercise",
     *  in="path",
     *  name="sub_content_session_code",
     *  required=true,
     *  @OA\Examples(example="individual_technique", value="individual_technique", summary="Individual technique"),
     *  @OA\Examples(example="collective_technique", value="collective_technique", summary="Collective technique"),
     *  @OA\Examples(example="offensive", value="offensive", summary="Offensive"),
     *  @OA\Examples(example="defensive", value="defensive", summary="Defensive"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="teacher_id",
     *  description="Identifier of the teacher associated to the resource",
     *  in="path",
     *  name="teacher_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="sport_code",
     *  description="Identificator of the sport",
     *  in="path",
     *  name="sport_code",
     *  required=true,
     *  @OA\Examples(example="football", value="football", summary="Football"),
     *  @OA\Examples(example="basketball", value="basketball", summary="Basketball"),
     *  @OA\Examples(example="handball", value="handball", summary="Handball"),
     *  @OA\Examples(example="indoor_soccer", value="indoor_soccer", summary="Indoor soccer"),
     *  @OA\Examples(example="volleyball", value="volleyball", summary="Volleyball"),
     *  @OA\Examples(example="beach_volleyball", value="beach_volleyball", summary="Beach Volleyball"),
     *  @OA\Examples(example="badminton", value="badminton", summary="Badminton"),
     *  @OA\Examples(example="tennis", value="tennis", summary="Tennis"),
     *  @OA\Examples(example="padel", value="padel", summary="Pádel"),
     *  @OA\Examples(example="roller_hockey", value="roller_hockey", summary="Roller Hockey"),
     *  @OA\Examples(example="field_hockey", value="field_hockey", summary="Field Hockey"),
     *  @OA\Examples(example="ice_hockey", value="ice_hockey", summary="Ice Hockey"),
     *  @OA\Examples(example="rugby", value="rugby", summary="Rugby"),
     *  @OA\Examples(example="baseball", value="baseball", summary="Baseball"),
     *  @OA\Examples(example="cricket", value="cricket", summary="Cricket"),
     *  @OA\Examples(example="swimming", value="swimming", summary="Swimming"),
     *  @OA\Examples(example="waterpolo", value="waterpolo", summary="Waterpolo"),
     *  @OA\Examples(example="american_soccer", value="american_soccer", summary="American Soccer"),

     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="user_id",
     *  description="Identifier of the user associated to the resource",
     *  in="path",
     *  name="user_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     * @OA\Parameter(
     *       parameter="exercise_code",
     *       description="Code of exercise",
     *       in="path",
     *       name="exercise_code",
     *       required=true,
     *       example="code",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="test_code",
     *       description="Code of test category",
     *       in="path",
     *       name="test_code",
     *       required=true,
     *       example="code",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="session_exercise_code",
     *       description="Identificator of the session exercise",
     *       in="path",
     *       name="session_exercise_code",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="exercise_id",
     *       description="Identificator of the exercise",
     *       in="path",
     *       name="exercise_id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="classroom_id",
     *       description="Identifier of the classroom associated to the resource",
     *       in="path",
     *       name="classroom_id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="classroom_academic_year_id",
     *       description="Identifier of the relationship between classroom
     *       and academic year associated to the resource",
     *       in="path",
     *       name="classroom_academic_year_id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="team_code",
     *       description="Identificator of the team",
     *       in="path",
     *       name="team_code",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="club_id",
     *       description="Identificator of the club",
     *       in="path",
     *       name="club_id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="staff_id",
     *       description="Identificator of the staff",
     *       in="path",
     *       name="staff_id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="scouting_id",
     *       description="Identificator of the scouting",
     *       in="path",
     *       name="scouting_id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="club_id_nr",
     *       description="Identificator of the club (Not required)",
     *       in="path",
     *       name="club_id",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="questionnaire_id",
     *       description="Identificator of the questionnaire",
     *       in="path",
     *       name="questionnaire_id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="staff_code",
     *       description="Identificator of the staff",
     *       in="path",
     *       name="staff_code",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *           type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="skip",
     *       description="Field to skip in list",
     *       in="query",
     *       name="skip",
     *       required=false,
     *       example="",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *    parameter="limit",
     *    description="Field to limit in list",
     *    in="query",
     *    name="limit",
     *    required=false,
     *    example="",
     *    @OA\Schema(
     *       type="string"
     *    )
     * )
     *
     * @OA\Parameter(
     *    parameter="activity_entity_type",
     *    description="Type of entity to be searched for - Tipo de entidad a ser buscada",
     *    in="query",
     *    name="type",
     *    required=true,
     *    @OA\Examples(example="user", value="user", summary="User entity type"),
     *    @OA\Examples(example="club", value="club", summary="Club entity type"),
     *    @OA\Examples(example="team", value="team", summary="Team entity type"),
     *    @OA\Examples(example="license", value="license", summary="License entity type"),
     *    @OA\Schema(
     *          type="string"
     *    )
     * )
     *
     * @OA\Parameter(
     *    parameter="activity_entity_id",
     *    description="Entity identification - Identificacion de la entidad",
     *    in="query",
     *    name="id",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *          type="string"
     *    )
     * )
     *
     * @OA\Parameter(
     *       parameter="id",
     *       description="Field to id in list",
     *       in="query",
     *       name="id",
     *       required=false,
     *       example="",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="path_id",
     *       description="Field to id in list",
     *       in="path",
     *       name="id",
     *       required=true,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="classrooms_id",
     *       description="Field to id in list",
     *       in="query",
     *       name="classrooms_id",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="tax_id",
     *       description="Tax item identificator",
     *       in="query",
     *       name="tax_id",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="is_company",
     *       description="Is company comparator value",
     *       in="query",
     *       name="is_company",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="country_id",
     *       description="Country Identificator",
     *       in="query",
     *       name="country_id",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="province_id",
     *       description="Province Identificator",
     *       in="query",
     *       name="province_id",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     * @OA\Parameter(
     *       parameter="test_type_code",
     *       description="test type code",
     *       in="path",
     *       name="test_type_code",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="test_type_code_query",
     *       description="test type code",
     *       in="query",
     *       name="test_type",
     *       required=false,
     *       example="code",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="test_sub_type_code",
     *       description="test sub type code",
     *       in="path",
     *       name="test_sub_type_code",
     *       required=false,
     *       example="1",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *       parameter="test_sub_type_code_query",
     *       description="test sub type code",
     *       in="query",
     *       name="test_sub_type",
     *       required=false,
     *       example="code",
     *       @OA\Schema(
     *          type="string"
     *       )
     * )
     *
     * @OA\Parameter(
     *     parameter="alumn_id",
     *     description="Alumn Identificator",
     *     in="path",
     *     name="alumn_id",
     *     required=true,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     *
     * @OA\Parameter(
     *     parameter="qualification_pdf_id",
     *     description="Qualification Identificator",
     *     in="path",
     *     name="qualification_pdf_id",
     *     required=true,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     * @OA\Parameter(
     *     parameter="competition_id",
     *     description="Competition Identificator",
     *     in="path",
     *     name="competition_id",
     *     required=true,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     * @OA\Parameter(
     *     parameter="match_id",
     *     description="Competition Match Identificator",
     *     in="path",
     *     name="match_id",
     *     required=true,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     * @OA\Parameter(
     *     parameter="competition_match_id",
     *     description="Competition Match Identificator",
     *     in="path",
     *     name="competition_match_id",
     *     required=true,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     * @OA\Parameter(
     *     parameter="rubric_id",
     *     description="Rubric Identificator",
     *     in="path",
     *     name="rubric_id",
     *     required=false,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     * @OA\Parameter(
     *     parameter="competence_id",
     *     description="Competence Identificator",
     *     in="path",
     *     name="competence_id",
     *     required=false,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     *
     * @OA\Parameter(
     *     parameter="indicator_id",
     *     description="Indicator Identificator",
     *     in="path",
     *     name="indicator_id",
     *     required=false,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     * @OA\Parameter(
     *    parameter="permission_entity_type",
     *    description="Type of entity to be searched for - Tipo de entidad a ser buscada",
     *    in="query",
     *    name="type",
     *    required=true,
     *    @OA\Examples(example="club", value="club", summary="Club entity type"),
     *    @OA\Schema(
     *          type="string"
     *    )
     * )
     *
     * @OA\Parameter(
     *  parameter="permission_entity_id",
     *  description="Entity ID to be searched for - Identificador de entidad para ser buscada",
     *  in="query",
     *  name="id",
     *  required=true,
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="academic_year_id",
     *  description="Academic year identificator - Identificador de año academico",
     *  in="path",
     *  name="academic_year_id",
     *  required=true,
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="exercise_session_id",
     *  description="Exercise session identificator - Identificador de sesion de ejercicio",
     *  in="path",
     *  name="exercise_session_id",
     *  required=true,
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="daily_control_item_id",
     *  description="Daily control item identificator - Identificador de item de control diario",
     *  in="path",
     *  name="id",
     *  required=true,
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="classroom_academic_year_id_daily_control_list",
     *  description="Classroom academic year identificator",
     *  in="query",
     *  name="classroom_academic_year_id",
     *  required=false,
     *  @OA\Examples(example="1", value="1", summary="1"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="academic_period_id_daily_control_list",
     *  description="Academic peiod identificator",
     *  in="query",
     *  name="academic_period_id",
     *  required=false,
     *  @OA\Examples(example="1", value="1", summary="1"),
     *  @OA\Examples(example="2", value="2", summary="2"),
     *  @OA\Examples(example="3", value="3", summary="3"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="tutorship_id",
     *  description="Tutorship identificator - Identificador de tutoria",
     *  in="path",
     *  name="id",
     *  required=true,
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="tutorship_type_id",
     *  description="Tutorship Type identificator - Identificador de tipo de tutoria",
     *  in="path",
     *  name="id",
     *  required=true,
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="specialist_referral_id",
     *  description="Specialist Referral identificator - Identificador del especialista derivado",
     *  in="path",
     *  name="id",
     *  required=true,
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="qs_date",
     *  description="Date to filter by - Format: YYYY-MM-DD",
     *  in="query",
     *  name="date",
     *  required=false,
     *  example="2022-05-01",
     *  @OA\Schema(
     *      type="date-time"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="distribution_exercise_id",
     *  description="Identificator of distribution exercise type",
     *  in="query",
     *  name="Distribution Exercise ID",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *      type="int64"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="qualification_id",
     *  description="Identificator of qualification",
     *  in="query",
     *  name="qualification_id",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *      type="int64"
     *  )
     * )
     *
     *  @OA\Parameter(
     *     parameter="qualification_req_id",
     *     description="Qualification Identificator",
     *     in="path",
     *     name="qualification_req_id",
     *     required=true,
     *     example="1",
     *     @OA\Schema(
     *           type="string"
     *     )
     * )
     *
     * @OA\Parameter(
     *  parameter="difficulty",
     *  description="Exercise difficulty level number",
     *  in="query",
     *  name="Exercise number",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *      type="int64"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="intensity",
     *  description="Exercise intensity level number",
     *  in="query",
     *  name="Exercise intensity number",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *      type="int64"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="duration",
     *  description="Exercise duration level number",
     *  in="query",
     *  name="Exercise duration",
     *  required=false,
     *  example="1",
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="team_staff_id",
     *  description="Identificator of the team staff",
     *  in="path",
     *  name="team_staff_id",
     *  required=false,
     *  example="1",
     *  @OA\Schema(type="string")
     * )
     *
     * @OA\Parameter(
     *  parameter="start_date",
     *  description="Start date sort the list",
     *  in="query", name="start_date", required=false,
     *  @OA\Examples(example="asc", value="asc", summary="Ascendent order"),
     *  @OA\Examples(example="desc", value="desc", summary="Descendent order"),
     *  @OA\Schema(type="string")
     * )
     *
     * @OA\Parameter(
     *   parameter="team_staff_name",
     *   description="Any name of any staff member",
     *   in="query", name="team_staff_name",
     *   required=false, example="fred",
     *   @OA\Schema(type="string")
     * )
     *
     * @OA\Parameter(
     *   parameter="only_active",
     *   description="Checks active only",
     *   in="query", name="only_active",
     *   required=false,
     *   @OA\Examples(example="true", value="true", summary="True value"),
     *   @OA\Examples(example="false", value="false", summary="False value"),
     *   @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *  parameter="handle_license_action",
     *  description="Type of license handling",
     *  in="query",
     *  name="License handling action",
     *  required=true,
     *  @OA\Examples(example="accept", value="accept", summary="Accept license invitation"),
     *  @OA\Examples(example="reject", value="reject", summary="Rejects license invitation"),
     *  @OA\Schema(
     *      type="string"
     *  )
     * )
     *
     * @OA\Parameter(
     *  parameter="psychology_report_id",
     *  description="ID of report to filter by - Format: Integer",
     *  in="path",
     *  name="psychology_report_id",
     *  required=true,
     *  example="1",
     *  @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *  parameter="in_game_time",
     *  description="Time game scouting",
     *  in="query",
     *  name="in_game_time",
     *  required=false,
     *  example="1",
     *  @OA\Schema(type="string")
     * )
     *
     * @OA\Parameter(
     *  parameter="in_period_time",
     *  description="Time period scouting",
     *  in="query",
     *  name="in_period_time",
     *  required=false,
     *  example="1",
     *  @OA\Schema(type="string")
     * )
     *
     * @OA\Parameter(
     *  parameter="name",
     *  description="Name filter",
     *  in="query",
     *  name="name",
     *  required=false,
     *  example="filter",
     *  @OA\Schema(type="string")
     * )
     *
     * * @OA\Parameter(
     *  parameter="match_date",
     *  description="Date matches to filter by - Format: YYYY-MM-DD HH:mm",
     *  in="query",
     *  name="date_start",
     *  required=false,
     *  example="2022-05-01 12:00",
     *  @OA\Schema(type="date-time")
     * )
     *
     * @OA\Response(
     *  response="reponseSuccess",
     *  description="Return response success",
     *  @OA\JsonContent(
     *      @OA\Property(property="success", type="string", example="true"),
     *      @OA\Property(property="message", type="string"),
     *      @OA\Property(property="data", type="object", example="object"),
     *  )
     * )
     *
     * @OA\Response(
     *  response="responseCreated",
     *  description="Return response created",
     *  @OA\JsonContent(
     *      @OA\Property(property="success", type="string", example="true"),
     *      @OA\Property(property="message", type="string"),
     *      @OA\Property(property="data", type="object", example="object"),
     *  )
     * )
     *
     * @OA\Response(
     *  response="unprocessableEntity",
     *  description="Return when user into data was invalid.",
     *  @OA\JsonContent(
     *      @OA\Property(property="message", type="string", example="The given data was invalid."),
     *      @OA\Property(property="errors", type="object", example="object"),
     *  )
     * )
     *
     * @OA\Response(
     *      response="notAuthenticated",
     *      description="Return when user is not authenticated.",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="string", example="false"),
     *          @OA\Property(property="message", type="string", example="Unauthenticated."),
     *      )
     * )
     *
     * @OA\Response(
     *      response="resourceNotFound",
     *      description="Return when a specific resource is not found.",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="string", example="false"),
     *          @OA\Property(property="message", type="string", example="The resource is not found."),
     *      )
     *  )
     *
     * @OA\Response(
     *      response="resourceDeleted",
     *      description="Return when a specific resource deleted.",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="string", example="true"),
     *      )
     *  )
     *
     *  @OA\Tag(
     *      name="User",
     *      description="User Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="User/Subscriptions",
     *      description="User Subscriptions Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="User/Permissions",
     *      description="User Permissions Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Club",
     *      description="Club Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Club/Staff",
     *      description="Club Staff Users Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Club/Invitation",
     *      description="Club Invitation Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="School",
     *      description="School Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="School/Types",
     *      description="School Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="School/AcademicYears",
     *      description="School academic year Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="General",
     *      description="General Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Health",
     *      description="Health Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Family",
     *      description="Family Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Sport",
     *      description="Sport Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Competition/Match",
     *      description="Competition Match Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Packages",
     *      description="Packages Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Subscription",
     *      description="Subscription Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Subscription/License",
     *      description="Subscription License Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Test",
     *      description="Test Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Injury",
     *      description="Injuries Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Injury/DailyWork",
     *      description="Injury Daily Work Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Injury/Phase",
     *      description="Injury Phase Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Injury/RFD",
     *      description="Injury RFD Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Injury/ReinstatementCriteria",
     *      description="Injury Reistatement Criteria Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="InjuryPrevention",
     *      description="Injury Prevention Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="InjuryPrevention/ProgramType",
     *      description="Injury Prevention Program Types Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Exercise/ContentBlock",
     *      description="Exercise Content Block Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="Exercise/EducationLevel",
     *      description="Exercise Education Level Endpoints"
     *  )
     *
     *  @OA\Tag(
     *      name="EffortRecovery/WellnessQuestionnaire",
     *      description="Wellness Questionnaire for Effort Recovery Endpoints"
     *  )
     *
     * @OA\Tag(
     *      name="EffortRecovery",
     *      description="Effort Recovery Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Classroom",
     *      description="Classroom Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Classroom/Exercise",
     *      description="Classroom Exercise Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Classroom/Exercise/Session",
     *      description="Classroom Exercise Session Endpoints"
     * )
     *
     *  @OA\Tag(
     *      name="Classroom/AcademicYear",
     *      description="Classroom academic years Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Nutrition",
     *      description="Nutrition Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Team",
     *      description="Team Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Team/Staff",
     *      description="Team Staff Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Team/Exercise",
     *      description="Team Exercise Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Team/Exercise/Session",
     *      description="Team Exercise Session Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Team/Matches",
     *      description="Team Matches Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="ExerciseSession",
     *      description="Exercise Session Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Activity",
     *      description="Activity Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Player",
     *      description="Player Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Alumn/DailyControl",
     *      description="Daily control Endpoints for alumn"
     * )
     *
     * @OA\Tag(
     *      name="Alumn/DailyControl/Items",
     *      description="Daily control specific items Endpoints"
     * )
     *
     * @OA\Tag(
     *      name="Rubrics",
     *      description="Rubrics Endpoints"
     * )
     *
     *  @OA\Tag(
     *      name="Evaluations",
     *      description="Evaluations Endpoints"
     * )
     *
     *  @OA\Tag(
     *      name="Fisiotherapy",
     *      description="Fisiotherapys Endpoints"
     * )
     */
}
