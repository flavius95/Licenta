<?php

use Illuminate\Database\Seeder;

class StopWordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stopwords')->delete();
        DB::unprepared(file_get_contents(__DIR__ . '\stop_words.sql'));
    }
}
