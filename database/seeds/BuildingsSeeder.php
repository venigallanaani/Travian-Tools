<?php

use Illuminate\Database\Seeder;

class BuildingsSeeder extends Seeder
{

    public function run()
    {
        $data=array(
            array('id'=>'ac1','name'=>'Academy','level'=>1,'wood'=>220,'clay'=>160,'iron'=>90,'crop'=>40,'all'=>510,'population'=>4,'culture'=>5),
            array('id'=>'ac1','name'=>'Academy','level'=>2,'wood'=>280,'clay'=>205,'iron'=>115,'crop'=>50,'all'=>650,'population'=>6,'culture'=>6),
            array('id'=>'ac1','name'=>'Academy','level'=>3,'wood'=>360,'clay'=>260,'iron'=>145,'crop'=>65,'all'=>830,'population'=>8,'culture'=>7),
            array('id'=>'ac1','name'=>'Academy','level'=>4,'wood'=>460,'clay'=>335,'iron'=>190,'crop'=>85,'all'=>1070,'population'=>10,'culture'=>8),
            array('id'=>'ac1','name'=>'Academy','level'=>5,'wood'=>590,'clay'=>430,'iron'=>240,'crop'=>105,'all'=>1365,'population'=>12,'culture'=>10),
            array('id'=>'ac1','name'=>'Academy','level'=>6,'wood'=>755,'clay'=>550,'iron'=>310,'crop'=>135,'all'=>1750,'population'=>15,'culture'=>12),
            array('id'=>'ac1','name'=>'Academy','level'=>7,'wood'=>970,'clay'=>705,'iron'=>395,'crop'=>175,'all'=>2245,'population'=>18,'culture'=>14),
            array('id'=>'ac1','name'=>'Academy','level'=>8,'wood'=>1240,'clay'=>900,'iron'=>505,'crop'=>225,'all'=>2870,'population'=>21,'culture'=>17),
            array('id'=>'ac1','name'=>'Academy','level'=>9,'wood'=>1585,'clay'=>1155,'iron'=>650,'crop'=>290,'all'=>3680,'population'=>24,'culture'=>21),
            array('id'=>'ac1','name'=>'Academy','level'=>10,'wood'=>2030,'clay'=>1475,'iron'=>830,'crop'=>370,'all'=>4705,'population'=>27,'culture'=>25),
            array('id'=>'ac1','name'=>'Academy','level'=>11,'wood'=>2595,'clay'=>1890,'iron'=>1065,'crop'=>470,'all'=>6020,'population'=>30,'culture'=>30),
            array('id'=>'ac1','name'=>'Academy','level'=>12,'wood'=>3325,'clay'=>2420,'iron'=>1360,'crop'=>605,'all'=>7710,'population'=>33,'culture'=>36),
            array('id'=>'ac1','name'=>'Academy','level'=>13,'wood'=>4255,'clay'=>3095,'iron'=>1740,'crop'=>775,'all'=>9865,'population'=>36,'culture'=>43),
            array('id'=>'ac1','name'=>'Academy','level'=>14,'wood'=>5445,'clay'=>3960,'iron'=>2230,'crop'=>990,'all'=>12625,'population'=>39,'culture'=>51),
            array('id'=>'ac1','name'=>'Academy','level'=>15,'wood'=>6970,'clay'=>5070,'iron'=>2850,'crop'=>1270,'all'=>16160,'population'=>42,'culture'=>62),
            array('id'=>'ac1','name'=>'Academy','level'=>16,'wood'=>8925,'clay'=>6490,'iron'=>3650,'crop'=>1625,'all'=>20690,'population'=>46,'culture'=>74),
            array('id'=>'ac1','name'=>'Academy','level'=>17,'wood'=>11425,'clay'=>8310,'iron'=>4675,'crop'=>2075,'all'=>26485,'population'=>50,'culture'=>89),
            array('id'=>'ac1','name'=>'Academy','level'=>18,'wood'=>14620,'clay'=>10635,'iron'=>5980,'crop'=>2660,'all'=>33895,'population'=>54,'culture'=>106),
            array('id'=>'ac1','name'=>'Academy','level'=>19,'wood'=>18715,'clay'=>13610,'iron'=>7655,'crop'=>3405,'all'=>43385,'population'=>58,'culture'=>128),
            array('id'=>'ac1','name'=>'Academy','level'=>20,'wood'=>23955,'clay'=>17420,'iron'=>9800,'crop'=>4355,'all'=>55530,'population'=>62,'culture'=>153),
            
            
        );
        
        DB::table('buildings')->insert($data);
    }
}
