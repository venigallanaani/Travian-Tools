<?php

use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array('id'=>'h11','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Awareness'),
            array('id'=>'h12','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Enlightenment'),
            array('id'=>'h13','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Wisdom'),
            
            array('id'=>'h21','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Regeneration'),
            array('id'=>'h22','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Healthiness'),
            array('id'=>'h23','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Healing'),
            
            array('id'=>'h31','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Gladiator'),
            array('id'=>'h32','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Tribune'),
            array('id'=>'h33','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Consul'),
            
            array('id'=>'h41','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Mercenary'),
            array('id'=>'h42','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Warrior'),
            array('id'=>'h43','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Archon'),
            
            array('id'=>'h51','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Horseman'),
            array('id'=>'h52','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Cavalry'),
            array('id'=>'h53','tribe'=>'ALL','type'=>'HEAD','name'=>'Helmet of Heavy cavalry'),
            
            array('id'=>'l11','tribe'=>'ALL','type'=>'LEFT','name'=>'Map'),
            array('id'=>'l12','tribe'=>'ALL','type'=>'LEFT','name'=>'Standard'),
            array('id'=>'l13','tribe'=>'ALL','type'=>'LEFT','name'=>'Sheild'),            
            array('id'=>'l14','tribe'=>'ALL','type'=>'LEFT','name'=>'Pennant'),
            array('id'=>'l15','tribe'=>'ALL','type'=>'LEFT','name'=>'Bag'),
            array('id'=>'l16','tribe'=>'ALL','type'=>'LEFT','name'=>'Natarian Horn'),
            
            array('id'=>'f11','tribe'=>'ALL','type'=>'FEET','name'=>'Boots of Regeneration'),
            array('id'=>'f12','tribe'=>'ALL','type'=>'FEET','name'=>'Boots of Healthiness'),
            array('id'=>'f13','tribe'=>'ALL','type'=>'FEET','name'=>'Boots of Healing'),
            
            array('id'=>'f21','tribe'=>'ALL','type'=>'FEET','name'=>'Small spurs'),
            array('id'=>'f22','tribe'=>'ALL','type'=>'FEET','name'=>'Spurs'),
            array('id'=>'f23','tribe'=>'ALL','type'=>'FEET','name'=>'Nasty spurs'),
            
            array('id'=>'f31','tribe'=>'ALL','type'=>'FEET','name'=>'Boots of the Mercenary'),
            array('id'=>'f32','tribe'=>'ALL','type'=>'FEET','name'=>'Boots of the Warrior'),
            array('id'=>'f33','tribe'=>'ALL','type'=>'FEET','name'=>'Boots of the Archon'),
            
            array('id'=>'c11','tribe'=>'ALL','type'=>'CHEST','name'=>'Light armour of Regeneration'),
            array('id'=>'c12','tribe'=>'ALL','type'=>'CHEST','name'=>'Armour of Regeneration'),
            array('id'=>'c13','tribe'=>'ALL','type'=>'CHEST','name'=>'Heavy armour of Regeneration'),
            
            array('id'=>'c21','tribe'=>'ALL','type'=>'CHEST','name'=>'Light breastplate'),
            array('id'=>'c22','tribe'=>'ALL','type'=>'CHEST','name'=>'Breastplate'),
            array('id'=>'c23','tribe'=>'ALL','type'=>'CHEST','name'=>'Heavy breastplate'),
            
            array('id'=>'c31','tribe'=>'ALL','type'=>'CHEST','name'=>'Light scale armour'),
            array('id'=>'c32','tribe'=>'ALL','type'=>'CHEST','name'=>'Scale armour'),
            array('id'=>'c33','tribe'=>'ALL','type'=>'CHEST','name'=>'Heavy scale armour'),
            
            array('id'=>'c41','tribe'=>'ALL','type'=>'CHEST','name'=>'Light segmented armour'),
            array('id'=>'c42','tribe'=>'ALL','type'=>'CHEST','name'=>'Segmented armour'),
            array('id'=>'c43','tribe'=>'ALL','type'=>'CHEST','name'=>'Heavy segmented armour'),
            
            array('id'=>'RR1','tribe'=>'ROMAN','type'=>'RIGHT','name'=>'Legionnaire Sword'),
            array('id'=>'RR2','tribe'=>'ROMAN','type'=>'RIGHT','name'=>'Praetorian Sword'),
            array('id'=>'RR3','tribe'=>'ROMAN','type'=>'RIGHT','name'=>'Imperian Sword'),
            array('id'=>'RR4','tribe'=>'ROMAN','type'=>'RIGHT','name'=>'Imperatoris Sword'),
            array('id'=>'RR5','tribe'=>'ROMAN','type'=>'RIGHT','name'=>'Caesaris Lance'),

            array('id'=>'RG1','tribe'=>'GAUL','type'=>'RIGHT','name'=>'Phalanx Spear'),
            array('id'=>'RG2','tribe'=>'GAUL','type'=>'RIGHT','name'=>'Swordsman Sword'),
            array('id'=>'RG3','tribe'=>'GAUL','type'=>'RIGHT','name'=>'Theutates Bow'),
            array('id'=>'RG4','tribe'=>'GAUL','type'=>'RIGHT','name'=>'Druidrider Staff'),
            array('id'=>'RG5','tribe'=>'GAUL','type'=>'RIGHT','name'=>'Haeduan Lance'),
            
            array('id'=>'RT1','tribe'=>'TEUTON','type'=>'RIGHT','name'=>'Clubswinger Club'),
            array('id'=>'RT2','tribe'=>'TEUTON','type'=>'RIGHT','name'=>'Spearman Spear'),
            array('id'=>'RT3','tribe'=>'TEUTON','type'=>'RIGHT','name'=>'Axeman Axe'),
            array('id'=>'RT4','tribe'=>'TEUTON','type'=>'RIGHT','name'=>'Paladin Hammer'),
            array('id'=>'RT5','tribe'=>'TEUTON','type'=>'RIGHT','name'=>'Teutonic Knight Sword'),
            
            array('id'=>'RE1','tribe'=>'EGYPTIAN','type'=>'RIGHT','name'=>'Slave Militia Club'),
            array('id'=>'RE2','tribe'=>'EGYPTIAN','type'=>'RIGHT','name'=>'Ash Warden Axe'),
            array('id'=>'RE3','tribe'=>'EGYPTIAN','type'=>'RIGHT','name'=>'Warrior Khopesh'),
            array('id'=>'RE4','tribe'=>'EGYPTIAN','type'=>'RIGHT','name'=>'Anhor Guard Spear'),
            array('id'=>'RE5','tribe'=>'EGYPTIAN','type'=>'RIGHT','name'=>'resheph Chariot Bow'),
            
            array('id'=>'RH1','tribe'=>'HUN','type'=>'RIGHT','name'=>'Mercenary Axe'),
            array('id'=>'RH2','tribe'=>'HUN','type'=>'RIGHT','name'=>'Bowman Bow'),
            array('id'=>'RH3','tribe'=>'HUN','type'=>'RIGHT','name'=>'Steppe Rider Sword'),
            array('id'=>'RH4','tribe'=>'HUN','type'=>'RIGHT','name'=>'Marksman Bow'),
            array('id'=>'RH5','tribe'=>'HUN','type'=>'RIGHT','name'=>'Marauder Sword'),
        );
        
        DB::table('hero_items')->insert($data);
    }
}
