<?php

use Illuminate\Database\Seeder;

class unitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array('id'=>'r01','tribe'=>'Roman','tribe_id'=>'1','name'=>'Legionnaire','type'=>'1','upkeep'=>'1','carry'=>'50','speed'=>'6','offense'=>'40','offense_max'=>'52.4','defense_inf'=>'35','defense_inf_max'=>'46.6','defense_cav'=>'50','defense_cav_max'=>'63.9','cost'=>'400','cost_wood'=>'120','cost_clay'=>'100','cost_iron'=>'150','cost_crop'=>'30','time'=>'0','image'=>'r01.png'),
            array('id'=>'r02','tribe'=>'Roman','tribe_id'=>'1','name'=>'Praetorian','type'=>'2','upkeep'=>'1','carry'=>'20','speed'=>'5','offense'=>'30','offense_max'=>'40.9','defense_inf'=>'65','defense_inf_max'=>'81.1','defense_cav'=>'35','defense_cav_max'=>'46.6','cost'=>'460','cost_wood'=>'100','cost_clay'=>'130','cost_iron'=>'160','cost_crop'=>'70','time'=>'0','image'=>'r02.png')
        );
        DB::table('units')->insert($data);
    }
}
