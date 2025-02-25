<?php

namespace Modules\Test\Functions;

class CalculateFormulaFunction {

   public function getResult($params,$formula)
    {
        return \DB::select('SELECT calculate_formula(?,?,?,?,?,?,?,?,?,?,?)', 
        array(
            $params[0],
            $params[1],
            $params[2],
            $params[3],
            $params[4],
            $params[5],
            $params[6],
            $params[7],
            $params[8],
            $params[9],
            $formula
        ));

    }
}