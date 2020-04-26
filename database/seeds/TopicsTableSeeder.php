<?php

use Illuminate\Database\Seeder;
use App\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('topics')->delete();

      Topic::create(
        [  'topic' => 'clothes', 'word' => 'apparel'],
        [  'topic' => 'clothes', 'word' => 'attire'],
        [  'topic' => 'clothes', 'word' => 'clobber'],
        [  'topic' => 'clothes', 'word' => 'clothes'],
        [  'topic' => 'clothes', 'word' => 'clothing'],
        [  'topic' => 'clothes', 'word' => 'dress'],
        [  'topic' => 'clothes', 'word' => 'garment'],
        [  'topic' => 'clothes', 'word' => 'gear'],
        [  'topic' => 'clothes', 'word' => 'get-up'],
        [  'topic' => 'clothes', 'word' => 'outfit'],
        [  'topic' => 'clothes', 'word' => 'raiment'],
        [  'topic' => 'clothes', 'word' => 'rig-out'],
        [  'topic' => 'clothes', 'word' => 'togs'],
        [  'topic' => 'clothes', 'word' => 'wardrobe'],
        [  'topic' => 'car', 'word' => 'ride'],
        [  'topic' => 'car', 'word' => 'car'],
        [  'topic' => 'car', 'word' => 'motor car'],
        [  'topic' => 'car', 'word' => 'motor'],
        [  'topic' => 'car', 'word' => 'auto'],
        [  'topic' => 'car', 'word' => 'automobile'],
        [  'topic' => 'car', 'word' => 'wheels'],
        [  'topic' => 'medical', 'word' => 'cure'],
        [  'topic' => 'medical', 'word' => 'cure-all'],
        [  'topic' => 'medical', 'word' => 'drug'],
        [  'topic' => 'medical', 'word' => 'medicament'],
        [  'topic' => 'medical', 'word' => 'medication'],
        [  'topic' => 'medical', 'word' => 'medicine'],
        [  'topic' => 'medical', 'word' => 'panacea'],
        [  'topic' => 'medical', 'word' => 'pharmaceuticals'],
        [  'topic' => 'medical', 'physic'],
        [  'topic' => 'medical', 'word' => 'placebo'],
        [  'topic' => 'medical', 'word' => 'preparation'],
        [  'topic' => 'medical', 'word' => 'prescription'],
        [  'topic' => 'medical', 'word' => 'remedy'],
        [  'topic' => 'food', 'word' => 'food'],
        [  'topic' => 'food', 'word' => 'meal'],
        [  'topic' => 'food', 'word' => 'cooking'],
        [  'topic' => 'food', 'word' => 'nutrition'],
        [  'topic' => 'food', 'word' => 'nourishment'],
        [  'topic' => 'food', 'word' => 'sustenance'],
        [  'topic' => 'food', 'word' => 'groceries'],
        [  'topic' => 'food', 'word' => 'fare'],
        [  'topic' => 'food', 'word' => 'speciality']
      );
    }
}
