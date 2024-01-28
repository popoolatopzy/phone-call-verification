<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Member extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('members');
        $table->addColumn('fullname', 'string', [
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('username', 'string', [
            'limit' => 50,
            'null' => true,
        ]);
        $table->addColumn('phone_no', 'string', [
            'limit' => 15,
            'null' => true,
        ]);
        $table->addColumn('password', 'string', [
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('verify_status', 'string', [
            'limit' => 255,
            'null' => true,
            'default' => 'Pending',
        ]);
        $table->create();

    }
}