<?php

/**
 * * General
 */

use Modules\Scouting\Processors\SideEffects\General\Substitution as Substitution;

/**
 * * Football
 */

use Modules\Scouting\Processors\SideEffects\Football\AccountStatistic as FootballAccountStatistics;
use Modules\Scouting\Processors\SideEffects\Football\Goals as FootballGoals;
use Modules\Scouting\Processors\SideEffects\Football\Autogoals as FootballAutogoals;
use Modules\Scouting\Processors\SideEffects\Football\Shots as FootballShots;
use Modules\Scouting\Processors\SideEffects\Football\Duels as FootballDuels;
use Modules\Scouting\Processors\SideEffects\Football\AirDuels as FootballAirDuels;
use Modules\Scouting\Processors\SideEffects\Football\CornerKicks as FootballCornerKicks;
use Modules\Scouting\Processors\SideEffects\Football\ThrowsIn as FootballThrowsIn;
use Modules\Scouting\Processors\SideEffects\Football\SecondPlays as FootballSecondPlays;
use Modules\Scouting\Processors\SideEffects\Football\Penalties as FootballPenalties;
use Modules\Scouting\Processors\SideEffects\Football\ChangePeriod as FootballChangePeriod;

/**
 * * Indoor Soccer
 */

use Modules\Scouting\Processors\SideEffects\IndoorSoccer\AccountStatistic as IndoorSoccerAccountStatistics;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\DoublePenalties as IndoorSoccerDoublePenalties;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Penalties as IndoorSoccerPenalties;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\ThrowsIn as IndoorSoccerThrowsIn;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Passes as IndoorSoccerPasses;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Duels as IndoorSoccerDuels;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Goals as IndoorSoccerGoals;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Autogoals as IndoorSoccerAutoGoals;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Shots as IndoorSoccerShots;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\CornerKicks as IndoorSoccerCornerKicks;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\ChangePeriod as IndoorSoccerChangePeriod;

/**
 * * Handball
 */

use Modules\Scouting\Processors\SideEffects\Handball\AccountStatistic as HandballAccountStatistics;
use Modules\Scouting\Processors\SideEffects\Handball\Goals as HandballGoals;
use Modules\Scouting\Processors\SideEffects\Handball\Autogoals as HandballAutoGoals;
use Modules\Scouting\Processors\SideEffects\Handball\Duels as HandballDuels;
use Modules\Scouting\Processors\SideEffects\Handball\Passes as HandballPasses;
use Modules\Scouting\Processors\SideEffects\Handball\SevenMeterThrows as HandballSevenMeterThrows;
use Modules\Scouting\Processors\SideEffects\Handball\Throws as HandballThrows;
use Modules\Scouting\Processors\SideEffects\Handball\ChangePeriod as HandballChangePeriod;

/**
 * * Volleyball
 */

use Modules\Scouting\Processors\SideEffects\Volleyball\Serves as VolleyballServes;
use Modules\Scouting\Processors\SideEffects\Volleyball\Spikes as VolleyballSpikes;
use Modules\Scouting\Processors\SideEffects\Volleyball\Blocks as VolleyballBlocks;
use Modules\Scouting\Processors\SideEffects\Volleyball\Receptions as VolleyballReceptions;
use Modules\Scouting\Processors\SideEffects\Volleyball\Digs as VolleyballDigs;
use Modules\Scouting\Processors\SideEffects\Volleyball\FootKicks as VolleyballFootKicks;
use Modules\Scouting\Processors\SideEffects\Volleyball\Points as VolleyballPoints;
use Modules\Scouting\Processors\SideEffects\Volleyball\AccountStatistic as VolleyballAccountStatistics;

/**
 * * Beach Volleyball
 */

use Modules\Scouting\Processors\SideEffects\BeachVolleyball\Serves as BeachVolleyballServes;
use Modules\Scouting\Processors\SideEffects\BeachVolleyball\Points as BeachVolleyballPoints;
use Modules\Scouting\Processors\SideEffects\BeachVolleyball\Spikes as BeachVolleyballSpikes;
use Modules\Scouting\Processors\SideEffects\BeachVolleyball\Blocks as BeachVolleyballBlocks;
use Modules\Scouting\Processors\SideEffects\BeachVolleyball\Receptions as BeachVolleyballReceptions;
use Modules\Scouting\Processors\SideEffects\BeachVolleyball\Digs as BeachVolleyballDigs;
use Modules\Scouting\Processors\SideEffects\BeachVolleyball\FootKicks as BeachVolleyballFootKicks;
use Modules\Scouting\Processors\SideEffects\BeachVolleyball\AccountStatistic as BeachVolleyballAccountStatistics;

/**
 * * Badminton
 */

use Modules\Scouting\Processors\SideEffects\Badminton\PointsByWinnerShots as BadmintonPointsByWinnerShots;
use Modules\Scouting\Processors\SideEffects\Badminton\PointsError as BadmintonPointsError;
use Modules\Scouting\Processors\SideEffects\Badminton\AccountStatistic as BadmintonAccountStatistics;
use Modules\Scouting\Processors\SideEffects\Badminton\Shots as BadmintonShots;
use Modules\Scouting\Processors\SideEffects\Badminton\Calculate as BadmintonCalculate;

/**
 * * Basketball
 */

use Modules\Scouting\Processors\SideEffects\Basketball\Points as BasketballPoints;
use Modules\Scouting\Processors\SideEffects\Basketball\FreeThrows as BasketballFreeThrows;
use Modules\Scouting\Processors\SideEffects\Basketball\TwoPoints as BasketballTwoPoints;
use Modules\Scouting\Processors\SideEffects\Basketball\ThreePoints as BasketballThreePoints;
use Modules\Scouting\Processors\SideEffects\Basketball\Duels as BasketballDuels;
use Modules\Scouting\Processors\SideEffects\Basketball\Tactics as BasketballTactics;
use Modules\Scouting\Processors\SideEffects\Basketball\Passes as BasketballPasses;
use Modules\Scouting\Processors\SideEffects\Basketball\Fouls as BasketballFouls;
use Modules\Scouting\Processors\SideEffects\Basketball\AccountStatistic as BasketballAccountStatistics;
use Modules\Scouting\Processors\SideEffects\Basketball\ChangePeriod as BasketballChangePeriod;

/**
 * * Rugby
 */

use Modules\Scouting\Processors\SideEffects\Rugby\Conversions as RugbyConversions;
use Modules\Scouting\Processors\SideEffects\Rugby\Drops as RugbyDrops;
use Modules\Scouting\Processors\SideEffects\Rugby\LineOuts as RugbyLineOuts;
use Modules\Scouting\Processors\SideEffects\Rugby\Mauls as RugbyMauls;
use Modules\Scouting\Processors\SideEffects\Rugby\Passes as RugbyPasses;
use Modules\Scouting\Processors\SideEffects\Rugby\PenaltyKicks as RugbyPenaltyKicks;
use Modules\Scouting\Processors\SideEffects\Rugby\Recoveries as RugbyRecoveries;
use Modules\Scouting\Processors\SideEffects\Rugby\Rucks as RugbyRucks;
use Modules\Scouting\Processors\SideEffects\Rugby\Runs as RugbyRuns;
use Modules\Scouting\Processors\SideEffects\Rugby\Scrums as RugbyScrums;
use Modules\Scouting\Processors\SideEffects\Rugby\Tackles as RugbyTackles;
use Modules\Scouting\Processors\SideEffects\Rugby\Tries as RugbyTries;
use Modules\Scouting\Processors\SideEffects\Rugby\AccountStatistic as RugbyAccountStatistics;
use Modules\Scouting\Processors\SideEffects\Rugby\ChangePeriod as RugbyChangePeriod;

/**
 * * American Soccer
 */

use Modules\Scouting\Processors\SideEffects\AmericanSoccer\AccountStatistic as AmericanSoccerAccountStatistics;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\ExtraPoints as AmericanSoccerExtraPoints;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\TouchDowns as AmericanSoccerTouchDowns;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\FieldGoals as AmericanSoccerFieldGoals;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\Passes as AmericanSoccerPasses;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\Conversions as AmericanSoccerConversions;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\Clearences as AmericanSoccerClearences;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\Receptions as AmericanSoccerReceptions;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\Tackles as AmericanSoccerTackles;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\Safeties as AmericanSoccerSafeties;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\Yards as AmericanSoccerYards;
use Modules\Scouting\Processors\SideEffects\AmericanSoccer\ChangePeriod as AmericanSoccerChangePeriod;

/**
 * * Waterpolo
 */
use Modules\Scouting\Processors\SideEffects\Waterpolo\Autogoals as WaterpoloAutogoals;
use Modules\Scouting\Processors\SideEffects\Waterpolo\AccountStatistic as WaterpoloAccountStatistics;
use Modules\Scouting\Processors\SideEffects\Waterpolo\Throws as WaterpoloThrows;
use Modules\Scouting\Processors\SideEffects\Waterpolo\Penalties as WaterpoloPenalties;
use Modules\Scouting\Processors\SideEffects\Waterpolo\NeutralBlocks as WaterpoloNeutralBlocks;
use Modules\Scouting\Processors\SideEffects\Waterpolo\Passes as WaterpoloPasses;
use Modules\Scouting\Processors\SideEffects\Waterpolo\Duels as WaterpoloDuels;
use Modules\Scouting\Processors\SideEffects\Waterpolo\Goals as WaterpoloGoals;
use Modules\Scouting\Processors\SideEffects\Waterpolo\ChangePeriod as WaterpoloChangePeriod;

/**
 * * Ice Hockey
 */

use Modules\Scouting\Processors\SideEffects\IceHockey\AccountStatistic as IceHockeyAccountStatistics;
use Modules\Scouting\Processors\SideEffects\IceHockey\Goals as IceHockeyGoals;
use Modules\Scouting\Processors\SideEffects\IceHockey\Fouls as IceHockeyFouls;
use Modules\Scouting\Processors\SideEffects\IceHockey\FaceOffs as IceHockeyFaceOffs;
use Modules\Scouting\Processors\SideEffects\IceHockey\PenaltyShots as IceHockeyPenaltyShots;
use Modules\Scouting\Processors\SideEffects\IceHockey\Throws as IceHockeyThrows;
use Modules\Scouting\Processors\SideEffects\IceHockey\Passes as IceHockeyPasses;
use Modules\Scouting\Processors\SideEffects\IceHockey\Autogoals as IceHockeyAutogoals;
use Modules\Scouting\Processors\SideEffects\IceHockey\ChangePeriod as IceHockeyChangePeriod;

/**
 * * Roller Hockey
 */

use Modules\Scouting\Processors\SideEffects\RollerHockey\AccountStatistic as RollerHockeyAccountStatistics;
use Modules\Scouting\Processors\SideEffects\RollerHockey\Throws as RollerHockeyThrows;
use Modules\Scouting\Processors\SideEffects\RollerHockey\Goals as RollerHockeyGoals;
use Modules\Scouting\Processors\SideEffects\RollerHockey\Autogoals as RollerHockeyAutogoals;
use Modules\Scouting\Processors\SideEffects\RollerHockey\Fouls as RollerHockeyFouls;
use Modules\Scouting\Processors\SideEffects\RollerHockey\Cards as RollerHockeyCards;
use Modules\Scouting\Processors\SideEffects\RollerHockey\ShootOuts as RollerHockeyShootOuts;
use Modules\Scouting\Processors\SideEffects\RollerHockey\PenaltyShots as RollerHockeyPenaltyShots;
use Modules\Scouting\Processors\SideEffects\RollerHockey\Passes as RollerHockeyPasses;
use Modules\Scouting\Processors\SideEffects\RollerHockey\ChangePeriod as RollerHockeyChangePeriod;


/**
 * * Field Hockey
 */

use Modules\Scouting\Processors\SideEffects\FieldHockey\AccountStatistic as FieldHockeyAccountStatistics;
use Modules\Scouting\Processors\SideEffects\FieldHockey\Goals as FieldHockeyGoals;
use Modules\Scouting\Processors\SideEffects\FieldHockey\Cards as FieldHockeyCards;
use Modules\Scouting\Processors\SideEffects\FieldHockey\PenaltyStrokes as FieldHockeyPenaltyStrokes;
use Modules\Scouting\Processors\SideEffects\FieldHockey\PenaltyCorners as FieldHockeyPenaltyCorners;
use Modules\Scouting\Processors\SideEffects\FieldHockey\ShootOuts as FieldHockeyShootOuts;
use Modules\Scouting\Processors\SideEffects\FieldHockey\Throws as FieldHockeyThrows;
use Modules\Scouting\Processors\SideEffects\FieldHockey\Passes as FieldHockeyPasses;
use Modules\Scouting\Processors\SideEffects\FieldHockey\Autogoals as FieldHockeyAutogoals;
use Modules\Scouting\Processors\SideEffects\FieldHockey\ChangePeriod as FieldHockeyChangePeriod;


/**
 * * Tennis
 */

use Modules\Scouting\Processors\SideEffects\Tennis\PointsByWinnerShots as TennisPointsByWinnerShots;
use Modules\Scouting\Processors\SideEffects\Tennis\Shots as TennisShots;
use Modules\Scouting\Processors\SideEffects\Tennis\Serves as TennisServes;
use Modules\Scouting\Processors\SideEffects\Tennis\DoubleFouls as TennisDoubleFouls;
use Modules\Scouting\Processors\SideEffects\Tennis\Errors as TennisErrors;
use Modules\Scouting\Processors\SideEffects\Tennis\AccountStatistic as TennisAccountStatistic;
use Modules\Scouting\Processors\SideEffects\Tennis\Calculate as TennisCalculate;

/**
 * * Padel
 */

use Modules\Scouting\Processors\SideEffects\Padel\AccountStatistic as PadelAccountStatistic;
use Modules\Scouting\Processors\SideEffects\Padel\PointsByWinnerShots as PadelPointsByWinnerShots;
use Modules\Scouting\Processors\SideEffects\Padel\Shots as PadelShots;
use Modules\Scouting\Processors\SideEffects\Padel\Serves as PadelServes;
use Modules\Scouting\Processors\SideEffects\Padel\DoubleFouls as PadelDoubleFouls;
use Modules\Scouting\Processors\SideEffects\Padel\Errors as PadelErrors;
use Modules\Scouting\Processors\SideEffects\Padel\Calculate as PadelCalculate;

/**
 * * Baseball
 */

use Modules\Scouting\Processors\SideEffects\Baseball\AccountStatistic as BaseballAccountStatistic;
use Modules\Scouting\Processors\SideEffects\Baseball\Runs as BaseballRuns;
use Modules\Scouting\Processors\SideEffects\Baseball\Batter as BaseballBatter;
use Modules\Scouting\Processors\SideEffects\Baseball\Strikes as BaseballStrikes;
use Modules\Scouting\Processors\SideEffects\Baseball\Balls as BaseballBalls;
use Modules\Scouting\Processors\SideEffects\Baseball\Walks as BaseballWalks;
use Modules\Scouting\Processors\SideEffects\Baseball\Errors as BaseballErrors;
use Modules\Scouting\Processors\SideEffects\Baseball\Outs as BaseballOuts;
use Modules\Scouting\Processors\SideEffects\Baseball\Hits as BaseballHits;
use Modules\Scouting\Processors\SideEffects\Baseball\AccountScore as BaseballAccountScore;

/**
 * * Cricket
 */

use Modules\Scouting\Processors\SideEffects\Cricket\Runs as CricketRuns;
use Modules\Scouting\Processors\SideEffects\Cricket\FourRuns as CricketFourRuns;
use Modules\Scouting\Processors\SideEffects\Cricket\SixRuns as CricketSixRuns;
use Modules\Scouting\Processors\SideEffects\Cricket\ExtraPoints as CricketExtraPoints;
use Modules\Scouting\Processors\SideEffects\Cricket\Outs as CricketOuts;
use Modules\Scouting\Processors\SideEffects\Cricket\AccountStatistic as CricketAccountStatistic;
use Modules\Scouting\Processors\SideEffects\Cricket\AccountScore as CricketAccountScore;
use Modules\Scouting\Processors\SideEffects\Cricket\HalfCentury as CricketHalfCentury;
use Modules\Scouting\Processors\SideEffects\Cricket\Century as CricketCentury;

/**
 * * Swimming
 */

use Modules\Scouting\Processors\SideEffects\Swimming\Turns as SwimmingTurns;
use Modules\Scouting\Processors\SideEffects\Swimming\Takeovers as SwimmingTakeovers;
use Modules\Scouting\Processors\SideEffects\Swimming\AccountStatistic as SwimmingAccountStatistic;
use Modules\Scouting\Processors\SideEffects\Swimming\AccountScore as SwimmingAccountScore;

/**
 * * Scoring Systems
 */

use Modules\Scouting\Processors\Score\BeachVolleyballScoringSystem;
use Modules\Scouting\Processors\Score\VolleyballScoringSystem;
use Modules\Scouting\Processors\Score\BadmintonScoringSystem;
use Modules\Scouting\Processors\Score\FootballScoringSystem;
use Modules\Scouting\Processors\Score\HandballScoringSystem;
use Modules\Scouting\Processors\Score\BasketballScoringSystem;
use Modules\Scouting\Processors\Score\AmericanSoccerScoringSystem;
use Modules\Scouting\Processors\Score\RugbyScoringSystem;
use Modules\Scouting\Processors\Score\WaterpoloScoringSystem;
use Modules\Scouting\Processors\Score\IceHockeyScoringSystem;
use Modules\Scouting\Processors\Score\RollerHockeyScoringSystem;
use Modules\Scouting\Processors\Score\FieldHockeyScoringSystem;
use Modules\Scouting\Processors\Score\TennisScoringSystem;
use Modules\Scouting\Processors\Score\PadelScoringSystem;
use Modules\Scouting\Processors\Score\BaseballScoringSystem;
use Modules\Scouting\Processors\Score\CricketScoringSystem;
use Modules\Scouting\Processors\Score\SwimmingScoringSystem;

use Modules\Sport\Entities\Sport;

return [
    'name' => 'Scouting',
    /*
    |--------------------------------------------------------------------------
    | Side Effects
    |--------------------------------------------------------------------------
    | Register the side effects associated to a sport
    | using the sport code as the key of the array.
    |
    | These side effects will be used for the actions
    | on the scoutings to define the activities that
    | modify the results of a scouting for a player,
    | competition or competition match
    */
    'side_effects' => [
        Sport::FOOTBALL => [
            FootballGoals::SIDE_EFFECT,
            FootballShots::SHOT_ON_TARGET_SIDE_EFFECT,
            FootballShots::SHOT_OFF_TARGET_SIDE_EFFECT,
            FootballDuels::DUEL_WON_SIDE_EFFECT,
            FootballDuels::DUEL_LOST_SIDE_EFFECT,
            FootballAirDuels::AIR_DUEL_WON_SIDE_EFFECT,
            FootballAirDuels::AIR_DUEL_LOST_SIDE_EFFECT,
            FootballCornerKicks::CORNER_KICK_WON_SIDE_EFFECT,
            FootballCornerKicks::CORNER_KICK_LOST_SIDE_EFFECT,
            FootballThrowsIn::THROW_IN_WON_SIDE_EFFECT,
            FootballThrowsIn::THROW_IN_LOST_SIDE_EFFECT,
            FootballSecondPlays::SECOND_PLAY_WON_SIDE_EFFECT,
            FootballSecondPlays::SECOND_PLAY_LOST_SIDE_EFFECT,
            FootballPenalties::PENALTY_SCORED_SIDE_EFFECT,
            FootballPenalties::PENALTY_MISSED_SIDE_EFFECT,
            FootballChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::INDOOR_SOCCER => [
            IndoorSoccerGoals::SIDE_EFFECT,
            IndoorSoccerAutoGoals::SIDE_EFFECT,
            IndoorSoccerThrowsIn::THROW_IN_WON_SIDE_EFFECT,
            IndoorSoccerThrowsIn::THROW_IN_LOST_SIDE_EFFECT,
            IndoorSoccerShots::SHOT_ON_TARGET_SIDE_EFFECT,
            IndoorSoccerShots::SHOT_OFF_TARGET_SIDE_EFFECT,
            IndoorSoccerPenalties::PENALTY_SCORED_SIDE_EFFECT,
            IndoorSoccerPenalties::PENALTY_MISSED_SIDE_EFFECT,
            IndoorSoccerDoublePenalties::DOUBLE_PENALTY_SCORED_SIDE_EFFECT,
            IndoorSoccerDoublePenalties::DOUBLE_PENALTY_MISSED_SIDE_EFFECT,
            IndoorSoccerPasses::PASS_SUCCESSFUL_SIDE_EFFECT,
            IndoorSoccerPasses::PASS_MISSED_SIDE_EFFECT,
            IndoorSoccerDuels::DUEL_WON_SIDE_EFFECT,
            IndoorSoccerDuels::DUEL_LOST_SIDE_EFFECT,
            IndoorSoccerCornerKicks::CORNER_KICK_WON_SIDE_EFFECT,
            IndoorSoccerCornerKicks::CORNER_KICK_LOST_SIDE_EFFECT,
            IndoorSoccerCornerKicks::CORNER_KICK_LOST_SIDE_EFFECT,
            IndoorSoccerChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::HANDBALL => [
            HandballGoals::SIDE_EFFECT,
            HandballAutoGoals::SIDE_EFFECT,
            HandballThrows::THROW_ON_TARGET_SIDE_EFFECT,
            HandballThrows::THROW_OFF_TARGET_SIDE_EFFECT,
            HandballSevenMeterThrows::SEVEN_METER_SCORED_SIDE_EFFECT,
            HandballSevenMeterThrows::SEVEN_METER_MISSED_SIDE_EFFECT,
            HandballDuels::DUEL_WON_SIDE_EFFECT,
            HandballDuels::DUEL_LOST_SIDE_EFFECT,
            HandballPasses::PASS_SUCCESSFUL_SIDE_EFFECT,
            HandballPasses::PASS_MISSED_SIDE_EFFECT,
            HandballChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::VOLLEYBALL => [
            VolleyballServes::SERVE_SIDE_EFFECT,
            VolleyballSpikes::SPIKE_SIDE_EFFECT,
            VolleyballBlocks::BLOCK_SIDE_EFFECT,
            VolleyballReceptions::RECEPTION_SIDE_EFFECT,
            VolleyballDigs::DIG_SIDE_EFFECT,
            VolleyballFootKicks::FOOT_KICK_SIDE_EFFECT,
            VolleyballPoints::POINT_WON_SIDE_EFFECT,
            VolleyballPoints::POINT_LOST_SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::BEACH_VOLLEYBALL => [
            BeachVolleyballServes::SERVE_SIDE_EFFECT,
            BeachVolleyballSpikes::SPIKE_SIDE_EFFECT,
            BeachVolleyballBlocks::BLOCK_SIDE_EFFECT,
            BeachVolleyballReceptions::RECEPTION_SIDE_EFFECT,
            BeachVolleyballDigs::DIG_SIDE_EFFECT,
            BeachVolleyballPoints::POINT_WON_SIDE_EFFECT,
            BeachVolleyballPoints::POINT_LOST_SIDE_EFFECT,
            BeachVolleyballFootKicks::FOOT_KICK_SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::BADMINTON => [
            BadmintonShots::SHOT_SIDE_EFFECT,
            BadmintonPointsByWinnerShots::POINT_SIDE_EFFECT,
            BadmintonPointsError::POINT_ERROR_SIDE_EFFECT,
        ],
        Sport::BASKETBALL => [
            BasketballFreeThrows::FREE_THROW_SCORED_SIDE_EFFECT,
            BasketballFreeThrows::FREE_THROW_MISSED_SIDE_EFFECT,
            BasketballTwoPoints::TWO_POINTS_SCORED_SIDE_EFFECT,
            BasketballTwoPoints::TWO_POINTS_MISSED_SIDE_EFFECT,
            BasketballThreePoints::THREE_POINTS_SCORED_SIDE_EFFECT,
            BasketballThreePoints::THREE_POINTS_MISSED_SIDE_EFFECT,
            BasketballDuels::DUEL_WON_SIDE_EFFECT,
            BasketballDuels::DUEL_LOST_SIDE_EFFECT,
            BasketballPoints::TWO_POINT_SIDE_EFFECT,
            BasketballPoints::THREE_POINT_SIDE_EFFECT,
            BasketballTactics::TACTIC_WON_SIDE_EFFECT,
            BasketballTactics::TACTIC_LOST_SIDE_EFFECT,
            BasketballPasses::PASS_WON_SIDE_EFFECT,
            BasketballPasses::PASS_LOST_SIDE_EFFECT,
            BasketballFouls::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
            BasketballChangePeriod::SIDE_EFFECT,
        ],
        Sport::RUGBY => [
            RugbyConversions::CONVERSION_SCORED_SIDE_EFFECT,
            RugbyConversions::CONVERSION_MISSED_SIDE_EFFECT,
            RugbyDrops::DROP_SCORED_SIDE_EFFECT,
            RugbyDrops::DROP_MISSED_SIDE_EFFECT,
            RugbyLineOuts::LINE_OUT_WON_SIDE_EFFECT,
            RugbyLineOuts::LINE_OUT_LOST_SIDE_EFFECT,
            RugbyMauls::MAUL_WON_SIDE_EFFECT,
            RugbyMauls::MAUL_LOST_SIDE_EFFECT,
            RugbyPasses::PASS_WON_SIDE_EFFECT,
            RugbyPasses::PASS_LOST_SIDE_EFFECT,
            RugbyPenaltyKicks::PENALTY_SCORED_SIDE_EFFECT,
            RugbyPenaltyKicks::PENALTY_MISSED_SIDE_EFFECT,
            RugbyRecoveries::SIDE_EFFECT,
            RugbyRucks::RUCK_WON_SIDE_EFFECT,
            RugbyRucks::RUCK_LOST_SIDE_EFFECT,
            RugbyRuns::RUN_WON_SIDE_EFFECT,
            RugbyRuns::RUN_LOST_SIDE_EFFECT,
            RugbyScrums::SCRUM_WON_SIDE_EFFECT,
            RugbyScrums::SCRUM_LOST_SIDE_EFFECT,
            RugbyTackles::TACKLE_WON_SIDE_EFFECT,
            RugbyTackles::TACKLE_LOST_SIDE_EFFECT,
            RugbyTries::SIDE_EFFECT,
            RugbyChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::AMERICAN_SOCCER => [
            AmericanSoccerTouchDowns::SIDE_EFFECT,
            AmericanSoccerExtraPoints::EXTRA_POINT_SCORED_SIDE_EFFECT,
            AmericanSoccerExtraPoints::EXTRA_POINT_MISSED_SIDE_EFFECT,
            AmericanSoccerFieldGoals::FIELD_GOAL_SCORED_SIDE_EFFECT,
            AmericanSoccerFieldGoals::FIELD_GOAL_MISSED_SIDE_EFFECT,
            AmericanSoccerPasses::PASS_WON_SIDE_EFFECT,
            AmericanSoccerPasses::PASS_LOST_SIDE_EFFECT,
            AmericanSoccerConversions::CONVERSION_SCORED_SIDE_EFFECT,
            AmericanSoccerConversions::CONVERSION_MISSED_SIDE_EFFECT,
            AmericanSoccerClearences::CLEARENCE_WON_SIDE_EFFECT,
            AmericanSoccerClearences::CLEARENCE_LOST_SIDE_EFFECT,
            AmericanSoccerReceptions::RECEPTION_WON_SIDE_EFFECT,
            AmericanSoccerReceptions::RECEPTION_LOST_SIDE_EFFECT,
            AmericanSoccerTackles::TACKLE_WON_SIDE_EFFECT,
            AmericanSoccerTackles::TACKLE_LOST_SIDE_EFFECT,
            AmericanSoccerSafeties::SIDE_EFFECT,
            AmericanSoccerYards::TEN_YARDS_WON_SIDE_EFFECT,
            AmericanSoccerYards::TEN_YARDS_LOST_SIDE_EFFECT,
            AmericanSoccerYards::TWENTY_YARDS_WON_SIDE_EFFECT,
            AmericanSoccerYards::TWENTY_YARDS_LOST_SIDE_EFFECT,
            AmericanSoccerYards::FIFTY_YARDS_WON_SIDE_EFFECT,
            AmericanSoccerYards::FIFTY_YARDS_LOST_SIDE_EFFECT,
            AmericanSoccerChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::WATERPOLO => [
            WaterpoloGoals::SIDE_EFFECT,
            WaterpoloAutogoals::SIDE_EFFECT,
            WaterpoloThrows::THROW_ON_TARGET_SIDE_EFFECT,
            WaterpoloThrows::THROW_OFF_TARGET_SIDE_EFFECT,
            WaterpoloNeutralBlocks::NEUTRAL_BLOCK_WON_SIDE_EFFECT,
            WaterpoloNeutralBlocks::NEUTRAL_BLOCK_LOST_SIDE_EFFECT,
            WaterpoloPenalties::PENALTY_SCORED_SIDE_EFFECT,
            WaterpoloPenalties::PENALTY_MISSED_SIDE_EFFECT,
            WaterpoloPasses::PASS_WON_SIDE_EFFECT,
            WaterpoloPasses::PASS_LOST_SIDE_EFFECT,
            WaterpoloDuels::DUEL_WON_SIDE_EFFECT,
            WaterpoloDuels::DUEL_LOST_SIDE_EFFECT,
            WaterpoloChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::ICE_HOCKEY => [
            IceHockeyGoals::SIDE_EFFECT,
            IceHockeyAutogoals::SIDE_EFFECT,
            IceHockeyFouls::SIDE_EFFECT,
            IceHockeyFaceOffs::FACE_OFF_WON_TARGET_SIDE_EFFECT,
            IceHockeyFaceOffs::FACE_OFF_LOST_TARGET_SIDE_EFFECT,
            IceHockeyPenaltyShots::PENALTY_SHOT_SCORED_SIDE_EFFECT,
            IceHockeyPenaltyShots::PENALTY_SHOT_MISSED_SIDE_EFFECT,
            IceHockeyThrows::THROW_ON_TARGET_SIDE_EFFECT,
            IceHockeyThrows::THROW_OFF_TARGET_SIDE_EFFECT,
            IceHockeyPasses::PASS_WON_SIDE_EFFECT,
            IceHockeyPasses::PASS_LOST_SIDE_EFFECT,
            IceHockeyChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::ROLLER_HOCKEY => [
            RollerHockeyThrows::THROW_ON_TARGET_SIDE_EFFECT,
            RollerHockeyThrows::THROW_OFF_TARGET_SIDE_EFFECT,
            RollerHockeyGoals::SIDE_EFFECT,
            RollerHockeyAutogoals::SIDE_EFFECT,
            RollerHockeyFouls::SIDE_EFFECT,
            RollerHockeyCards::SIDE_EFFECT,
            RollerHockeyShootOuts::SHOOT_OUT_SCORED_SIDE_EFFECT,
            RollerHockeyShootOuts::SHOOT_OUT_MISSED_SIDE_EFFECT,
            RollerHockeyPenaltyShots::PENALTY_SHOT_SCORED_SIDE_EFFECT,
            RollerHockeyPenaltyShots::PENALTY_SHOT_MISSED_SIDE_EFFECT,
            RollerHockeyPasses::PASS_WON_SIDE_EFFECT,
            RollerHockeyPasses::PASS_LOST_SIDE_EFFECT,
            RollerHockeyChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::FIELD_HOCKEY => [
            FieldHockeyGoals::SIDE_EFFECT,
            FieldHockeyCards::SIDE_EFFECT,
            FieldHockeyAutogoals::SIDE_EFFECT,
            FieldHockeyPenaltyStrokes::PENALTY_STROKE_SCORED_SIDE_EFFECT,
            FieldHockeyPenaltyStrokes::PENALTY_STROKE_MISSED_SIDE_EFFECT,
            FieldHockeyPenaltyCorners::PENALTY_CORNER_SCORED_SIDE_EFFECT,
            FieldHockeyPenaltyCorners::PENALTY_CORNER_MISSED_SIDE_EFFECT,
            FieldHockeyShootOuts::SHOOT_OUT_SCORED_SIDE_EFFECT,
            FieldHockeyShootOuts::SHOOT_OUT_SCORED_SIDE_EFFECT,
            FieldHockeyThrows::THROW_ON_TARGET_SIDE_EFFECT,
            FieldHockeyThrows::THROW_OFF_TARGET_SIDE_EFFECT,
            FieldHockeyPasses::PASS_WON_SIDE_EFFECT,
            FieldHockeyPasses::PASS_LOST_SIDE_EFFECT,
            FieldHockeyChangePeriod::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::BASEBALL => [
            BaseballRuns::SIDE_EFFECT,
            BaseballBatter::SIDE_EFFECT,
            BaseballStrikes::SIDE_EFFECT,
            BaseballBalls::SIDE_EFFECT,
            BaseballWalks::SIDE_EFFECT,
            BaseballErrors::SIDE_EFFECT,
            BaseballOuts::SIDE_EFFECT,
            BaseballHits::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::CRICKET => [
            CricketRuns::SIDE_EFFECT,
            CricketFourRuns::SIDE_EFFECT,
            CricketSixRuns::SIDE_EFFECT,
            CricketExtraPoints::SIDE_EFFECT,
            CricketOuts::SIDE_EFFECT,
            CricketHalfCentury::SIDE_EFFECT,
            CricketCentury::SIDE_EFFECT,
            Substitution::SIDE_EFFECT,
        ],
        Sport::SWIMMING => [
            SwimmingTurns::TURNS_GOOD_SIDE_EFFECT,
            SwimmingTurns::TURNS_BAD_SIDE_EFFECT,
            SwimmingTakeovers::TAKEOVERS_GOOD_SIDE_EFFECT,
            SwimmingTakeovers::TAKEOVERS_BAD_SIDE_EFFECT,
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Processors
    |--------------------------------------------------------------------------
    | Register the classes defined as pipes associated
    | to a sport using the sport code as the key
    | of the array.
    |
    | These processors will be used for the calculation
    | of the scouting results
    */
    'processors' => [
        Sport::FOOTBALL => [
            FootballAutogoals::class,
            FootballGoals::class,
            FootballShots::class,
            FootballDuels::class,
            FootballAirDuels::class,
            FootballCornerKicks::class,
            FootballThrowsIn::class,
            FootballSecondPlays::class,
            FootballPenalties::class,
            FootballChangePeriod::class,
            Substitution::class,
            FootballAccountStatistics::class,
        ],
        Sport::INDOOR_SOCCER => [
            IndoorSoccerGoals::class,
            IndoorSoccerAutoGoals::class,
            IndoorSoccerThrowsIn::class,
            IndoorSoccerShots::class,
            IndoorSoccerPenalties::class,
            IndoorSoccerDoublePenalties::class,
            IndoorSoccerPasses::class,
            IndoorSoccerDuels::class,
            IndoorSoccerCornerKicks::class,
            Substitution::class,
            IndoorSoccerAccountStatistics::class,
            IndoorSoccerChangePeriod::class,
        ],
        Sport::HANDBALL => [
            HandballGoals::class,
            HandballAutoGoals::class,
            HandballThrows::class,
            HandballSevenMeterThrows::class,
            HandballDuels::class,
            HandballPasses::class,
            Substitution::class,
            HandballAccountStatistics::class,
            HandballChangePeriod::class,
        ],
        Sport::VOLLEYBALL => [
            VolleyballServes::class,
            VolleyballSpikes::class,
            VolleyballBlocks::class,
            VolleyballReceptions::class,
            VolleyballDigs::class,
            VolleyballFootKicks::class,
            VolleyballPoints::class,
            Substitution::class,
            VolleyballAccountStatistics::class,
        ],
        Sport::BEACH_VOLLEYBALL => [
            BeachVolleyballServes::class,
            BeachVolleyballSpikes::class,
            BeachVolleyballBlocks::class,
            BeachVolleyballReceptions::class,
            BeachVolleyballDigs::class,
            BeachVolleyballFootKicks::class,
            BeachVolleyballPoints::class,
            BeachVolleyballFootKicks::class,
            Substitution::class,
            BeachVolleyballAccountStatistics::class,
        ],
        Sport::BADMINTON => [
            // BadmintonPointsByWinnerShots::class,
            // BadmintonPointsError::class,
            BadmintonShots::class,
            Substitution::class,
            BadmintonAccountStatistics::class,
            BadmintonCalculate::class,
        ],
        Sport::BASKETBALL => [
            BasketballPoints::class,
            BasketballFreeThrows::class,
            BasketballTwoPoints::class,
            BasketballThreePoints::class,
            BasketballDuels::class,
            BasketballTactics::class,
            BasketballPasses::class,
            BasketballFouls::class,
            Substitution::class,
            BasketballAccountStatistics::class,
            BasketballChangePeriod::class
        ],
        Sport::RUGBY => [
            RugbyConversions::class,
            RugbyDrops::class,
            RugbyLineOuts::class,
            RugbyMauls::class,
            RugbyPasses::class,
            RugbyPenaltyKicks::class,
            RugbyRecoveries::class,
            RugbyRucks::class,
            RugbyRuns::class,
            RugbyScrums::class,
            RugbyTackles::class,
            RugbyTries::class,
            RugbyAccountStatistics::class,
            RugbyChangePeriod::class
        ],
        Sport::AMERICAN_SOCCER => [
            AmericanSoccerTouchDowns::class,
            AmericanSoccerExtraPoints::class,
            AmericanSoccerFieldGoals::class,
            AmericanSoccerPasses::class,
            AmericanSoccerConversions::class,
            AmericanSoccerClearences::class,
            AmericanSoccerReceptions::class,
            AmericanSoccerTackles::class,
            AmericanSoccerSafeties::class,
            AmericanSoccerYards::class,
            AmericanSoccerChangePeriod::class,
            Substitution::class,
            AmericanSoccerAccountStatistics::class
        ],
        Sport::WATERPOLO => [
            WaterpoloAutogoals::class,
            WaterpoloThrows::class,
            WaterpoloNeutralBlocks::class,
            WaterpoloPenalties::class,
            WaterpoloPasses::class,
            WaterpoloDuels::class,
            WaterpoloGoals::class,
            WaterpoloChangePeriod::class,
            Substitution::class,
            WaterpoloAccountStatistics::class
        ],
        Sport::ICE_HOCKEY => [
            IceHockeyGoals::class,
            IceHockeyFouls::class,
            IceHockeyPenaltyShots::class,
            IceHockeyFaceOffs::class,
            IceHockeyPasses::class,
            IceHockeyAutogoals::class,
            IceHockeyThrows::class,
            IceHockeyChangePeriod::class,
            Substitution::class,
            IceHockeyAccountStatistics::class
        ],
        Sport::ROLLER_HOCKEY => [
            RollerHockeyThrows::class,
            RollerHockeyGoals::class,
            RollerHockeyAutogoals::class,
            RollerHockeyFouls::class,
            RollerHockeyCards::class,
            RollerHockeyShootOuts::class,
            RollerHockeyPenaltyShots::class,
            RollerHockeyPasses::class,
            RollerHockeyChangePeriod::class,
            Substitution::class,
            RollerHockeyAccountStatistics::class
        ],
        Sport::FIELD_HOCKEY => [
            FieldHockeyGoals::class,
            FieldHockeyCards::class,
            FieldHockeyPenaltyStrokes::class,
            FieldHockeyPenaltyCorners::class,
            FieldHockeyShootOuts::class,
            FieldHockeyPasses::class,
            FieldHockeyAutogoals::class,
            FieldHockeyThrows::class,
            FieldHockeyChangePeriod::class,
            Substitution::class,
            FieldHockeyAccountStatistics::class
        ],
        Sport::TENNIS => [
            // TennisPointsByWinnerShots::class,
            TennisShots::class,
            TennisServes::class,
            TennisDoubleFouls::class,
            // TennisErrors::class,
            TennisAccountStatistic::class,
            TennisCalculate::class
        ],
        Sport::PADEL => [
            // PadelPointsByWinnerShots::class,
            PadelShots::class,
            PadelServes::class,
            PadelDoubleFouls::class,
            // PadelErrors::class,
            PadelAccountStatistic::class,
            PadelCalculate::class
        ],
        Sport::BASEBALL => [
            Substitution::class,
            BaseballAccountStatistic::class,
            BaseballAccountScore::class
        ],
        Sport::CRICKET => [
            Substitution::class,
            CricketAccountStatistic::class,
            CricketAccountScore::class
        ],
        Sport::SWIMMING => [
            SwimmingTurns::class,
            SwimmingTakeovers::class,
            Substitution::class,
            SwimmingAccountStatistic::class,
            SwimmingAccountScore::class
        ],
    ],
    'scoring_systems' => [
        Sport::FOOTBALL => FootballScoringSystem::class,
        Sport::INDOOR_SOCCER => FootballScoringSystem::class,
        Sport::HANDBALL => HandballScoringSystem::class,
        Sport::VOLLEYBALL => VolleyballScoringSystem::class,
        Sport::BEACH_VOLLEYBALL => BeachVolleyballScoringSystem::class,
        Sport::BADMINTON => BadmintonScoringSystem::class,
        Sport::BASKETBALL => BasketballScoringSystem::class,
        Sport::RUGBY => RugbyScoringSystem::class,
        Sport::AMERICAN_SOCCER => AmericanSoccerScoringSystem::class,
        Sport::WATERPOLO => WaterpoloScoringSystem::class,
        Sport::ICE_HOCKEY => IceHockeyScoringSystem::class,
        Sport::ROLLER_HOCKEY => RollerHockeyScoringSystem::class,
        Sport::FIELD_HOCKEY => FieldHockeyScoringSystem::class,
        Sport::TENNIS => TennisScoringSystem::class,
        Sport::PADEL => PadelScoringSystem::class,
        Sport::BASEBALL => BaseballScoringSystem::class,
        Sport::CRICKET => CricketScoringSystem::class,
        Sport::SWIMMING => SwimmingScoringSystem::class
    ]
];
