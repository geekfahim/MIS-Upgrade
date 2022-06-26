<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Models\Base\Acl\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();
        $this->createAdmin();
        $this->createMisUsers();
//        $this->createMisTestUsers();
    }

    private function createAdmin()
    {

        User::create([
            'name' => 'Admin',
            'office_id' => 1001,
            'email' => 'ict@czm-bd.org',
            'password' => 999999,
            'status' => UserStatus::Active,
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }


    private function createMisUsers()
    {
        $items = [
            ['name' => 'Mijanaur Rahman', 'office_id' => 203, 'email' => 'mijanurrahman601@gmail.com', 'mobile' => '1710020036'],
            ['name' => 'Most. Zahedha Khatun', 'office_id' => 407, 'email' => 'adiyatrahman1997@gmail.com', 'mobile' => '1305824146'],
            ['name' => 'Sayeda Ayesha Binta Ahmed', 'office_id' => 447, 'email' => 'ayeshabintaahmed@gmail.com', 'mobile' => '1676301224'],
            ['name' => 'Milan Hosen', 'office_id' => 325, 'email' => 'milanhosen641819@gmail.com', 'mobile' => '1741609868'],
            ['name' => 'Md. Liaket Ali', 'office_id' => 275, 'email' => 'liakotczm88@gmail.com', 'mobile' => '1738149547'],
            ['name' => 'Shah Alam', 'office_id' => 300, 'email' => 'shahalamnaeb@gmail.co', 'mobile' => '1913991356'],
            ['name' => 'Md. Obaidullah', 'office_id' => 234, 'email' => 'obaidullah.uise@gmail.com', 'mobile' => '1919882361'],
            ['name' => 'Md. Safi Ullah', 'office_id' => 330, 'email' => 'demo1@gmail.com', 'mobile' => '1722277161'],
            ['name' => 'Moslem Uddin Sarker', 'office_id' => 446, 'email' => 'moslemuddin007@gmail.com', 'mobile' => '1744431743'],
            ['name' => 'Hurain Akter', 'office_id' => 390, 'email' => 'demo2@gmail.com', 'mobile' => '1818468713'],
            ['name' => 'Md. Ismail', 'office_id' => 193, 'email' => 'md.ismail@czm-bd.org', 'mobile' => '1798136477'],
            ['name' => 'Md. Shahjahan', 'office_id' => 161, 'email' => 'shahjahan@czm-bd.org', 'mobile' => '1735700019'],
            ['name' => 'Md. Shirajul Haque', 'office_id' => 117, 'email' => 'md.shirajulhaquetipu@gmail.com', 'mobile' => '1728872042'],
            ['name' => 'Abu Md. Kamruzzaman', 'office_id' => 174, 'email' => 'babucnap@gmail.com', 'mobile' => '1717387387'],
            ['name' => 'Md. Mizanur Rahman', 'office_id' => 204, 'email' => 'mizanuralvir@gmail.com', 'mobile' => '1722629161'],
            ['name' => 'Md. Ekramul Haque', 'office_id' => 168, 'email' => 'ekramulhaque238@yahoo.com', 'mobile' => '1719254601'],
            ['name' => 'Md. Nahid Hasan', 'office_id' => 388, 'email' => 'hnahid76@gmail.com', 'mobile' => '1740985951'],
            ['name' => 'Samia Aktar', 'office_id' => 163, 'email' => 'sanayasamia94@gmail.com', 'mobile' => '1744471318'],
        ];

        $data = [];
        $maxCount = count($items);
        for ($i = 0; $i < $maxCount; $i++) {
            $data[] = [
                'name' => $items[$i]['name'],
                'office_id' => $items[$i]['office_id'],
                'email' => $items[$i]['email'],
                'password' => bcrypt($items[$i]['email']),
                'status' => UserStatus::Active,
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => null,
            ];
        }
        User::insert($data);
    }

    private function createMisTestUsers()
    {
        for ($i = 4; $i < 20; $i++) {
            $data[] = [
                'id' => $i,
                'name' => "Test User {$i}",
                'office_id' => 400 + $i,
                'email' => "testUser{$i}@czm-bd.org",
                'password' => bcrypt("testUser{$i}@czm-bd.org"),
                'status' => \Arr::random(UserStatus::cases()),
                'created_by' => 1,
                'created_at' => now()
            ];
        }
        User::insert($data);
    }
}
