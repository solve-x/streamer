<?php

namespace Database\Migrations;

use DB;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20170914115603 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        DB::table('user_roles')
            ->insert([
                [
                    'id' => 1,
                    'name' => 'SuperAdmin',
                    'label' => 'Lastnik'
                ],
                [
                    'id' => 2,
                    'name' => 'Admin',
                    'label' => 'Administrator'
                ],
                [
                    'id' => 3,
                    'name' => 'User',
                    'label' => 'Uporabnik'
                ]
            ]);

        DB::table('stream_types')
            ->insert([
                [
                    'id' => 1,
                    'name' => 'Public',
                    'label' => 'Javno'
                ],
                [
                    'id' => 2,
                    'name' => 'Private',
                    'label' => 'Zasebno'
                ],
                [
                    'id' => 3,
                    'name' => 'Testing',
                    'label' => 'Testno'
                ]
            ]);

        DB::table('users')
            ->insert([
                'id' => 99,
                'name' => 'forge',
                'email' => 'admin@mail.com',
                'password' => '$2y$10$V9M3SnNF6JxhW/tXbMG8nuTK.Eij59xBtLodHSAPk1bHVXtZO5Y/m',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        DB::table('users_user_roles')
            ->insert([
                'user_id' => 99,
                'role_id' => 1
            ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        DB::table('user_roles')
            ->truncate();

        DB::table('stream_types')
            ->truncate();

        DB::table('users_user_roles')
            ->where('user_id', '=', 0)
            ->delete();

        DB::table('users')
            ->delete(0);
    }
}
