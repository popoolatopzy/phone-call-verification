<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MembersFixture
 */
class MembersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'fullname' => 'Lorem ipsum dolor sit amet',
                'username' => 'Lorem ipsum dolor sit amet',
                'phone_no' => 'Lorem ipsum d',
                'password' => 'Lorem ipsum dolor sit amet',
                'verify_status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
