<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionFormula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {            
        DB::unprepared('CREATE OR REPLACE FUNCTION calculate_formula(
            param1 numeric         
           ,param2 numeric         
           ,param3 numeric         
           ,param4 numeric    
           ,param5 numeric    
           ,param6 numeric  
           ,param7 numeric 
           ,param8 numeric 
           ,param9 numeric 
           ,param10 numeric  
           ,formula text
           ,OUT result numeric
        )  RETURNS numeric AS
        $func$
        BEGIN    
           EXECUTE \'SELECT \' || formula
           INTO   result
           USING  $1, $2, $3, $4, $5, $6, $7, $8 ,$9, $10;                                          
        END
        $func$ 
        LANGUAGE plpgsql SECURITY DEFINER IMMUTABLE; ');
    }

    public function down() 
    {
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_formula');
    }
}
