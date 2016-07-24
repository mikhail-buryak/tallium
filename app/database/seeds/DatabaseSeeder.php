<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('SectionsTableSeeder');
        $this->call('PlacesTableSeeder');
    }
}

/**
 * Class SectionsTableSeeder
 *
 * Seeds database sectors table
 *
 */
class SectionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sections')->delete();

        $sections = [];
        $alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        for ($i=0, $p=0, $alphaCount = count($alpha); $i < $alphaCount; $i++) {

            for ($j = 1; $j <= 8; $j++) {

                $sections[]['title'] = $alpha[$p].'-'.$j;

                if($j != 0 && $j % 8 == 0)
                    $p++;
            }
        }

        DB::table('sections')->insert($sections);
    }
}

/**
 * Class PlacesTableSeeder
 *
 * Seeds database places table
 *
 */
class PlacesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('places')->delete();

        $sections = DB::table('sections')->select('id')->get();
        $places = [];
        $iter = new \ArrayIterator($sections);

        foreach ($iter as $item) {

            for ($i = 1; $i <= 30; $i++) {

                for ($j = 1; $j <= 50; $j++) {

                    $place['section_id'] = $item->id;
                    $place['row'] = $i;
                    $place['place'] = $j;
                    $place['price'] = rand(900, 1600);
                    $places[] = $place;
                }

                if($i % 4 || $i == 12) {
                    DB::table('places')->insert($places);
                    $places = [];
                }
            }
        }

    }
}