<?php

use Illuminate\Database\Seeder;

class serversSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array('server_id'=>'t6angr1','url'=>'ts6.angolosphere.travian.com','country'=>'com','status'=>'ACTIVE','start_date'=>'2018-10-27','days'=>'35','maps_table'=>'maps_details','diff_table'=>'diff_details','timezone'=>'GMT','table_id'=>''),
            
            );       
        
        DB::table('servers')->insert($data);
    }
}
