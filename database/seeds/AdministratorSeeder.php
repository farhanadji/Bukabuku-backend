<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("users")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $administrator = new \App\User;
        $administrator->id= "99";
        $administrator->username = "farhanadji";
        $administrator->name = "Farhan Adji";
        $administrator->email = "farhan@adji.com";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("farhanadji");

        $administrator->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}
