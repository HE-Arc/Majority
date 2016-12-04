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
        
        $this->call(UsersTableSeeder::class);
        $this->call(QuestionsAnswersTablesSeeder::class);
		$this->call(GamesParticipantsRoundsSeeder::class);

		$this->call(Chosen_AnswersTablesSeeder::class);
    }
}
