<?php

use App\Models\Bill;
use App\Models\CafeBillItem;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\Game;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\playSession;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'ashraf6450@gmail.com',
            'password' => bcrypt('91919191917'),
        ]);
        $games = [
            ['name'=>"FIFA 18","type"=>"digital"],
            ['name'=>"FIFA 19","type"=>"digital"],
            ['name'=>"FIFA 20","type"=>"digital"],
            ['name'=>"FIFA 21","type"=>"digital"],
            ['name'=>"FIFA 22","type"=>"digital"],
            ['name'=>"FIFA 23","type"=>"digital"],
            ['name'=>"PES 18","type"=>"digital"],
            ['name'=>"PES 19","type"=>"digital"],
            ['name'=>"PES 20","type"=>"digital"],
            ['name'=>"PES 21","type"=>"digital"],
            ['name'=>"PES 22","type"=>"digital"],
            ['name'=>"GTA V","type"=>"digital"],
            ['name'=>"Mortal Combat","type"=>"disc"],
        ];
        $device_categories = [
            ['name'=>'بلايستيشن 5','price'=>20,'multi_price'=>30],
            ['name'=>'بلايستيشن 4','price'=>10,'multi_price'=>15],
            ['name'=>'بلايستيشن 3','price'=>5,'multi_price'=>10],
            ['name'=>'اكس بوكس','price'=>10,'multi_price'=>15],
            ['name'=>'بلياردو','price'=>20,'multi_price'=>20],
            ['name'=>'تنس','price'=>20,'multi_price'=>20],
            ['name'=>'واقع افتراضي','price'=>50,'multi_price'=>50],
        ];
        $devices = [
            ['name'=>'جهاز 1','devices_category_id'=>2],
            ['name'=>'جهاز 2','devices_category_id'=>2],
            ['name'=>'جهاز 3','devices_category_id'=>2],
            ['name'=>'جهاز 4','devices_category_id'=>2],
            ['name'=>'جهاز 5','devices_category_id'=>2],
            ['name'=>'جهاز 6','devices_category_id'=>2],
        ];
        $items_categories = [
            ['name'=>'مشروبات باردة'],
            ['name'=>'مشروبات ساخنه'],
            ['name'=>'شيبسي'],
            ['name'=>'بسكوت'],
            ['name'=>'اكل'],
        ];
        $items = [
            ['name'=>'شاي','image'=>'items/tea.png', 'items_category_id'=>2, 'price'=>4, 'buy_price'=>1],
            ['name'=>'كافي ميكس','image'=>'items/Bonjorno.png', 'items_category_id'=>2, 'price'=>5, 'buy_price'=>2],
            ['name'=>'نسكافيه','image'=>'items/nescafe.jpg', 'items_category_id'=>2, 'price'=>5, 'buy_price'=>3],

            ['name'=>'بيبسي','image'=>'items/pepsi.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'مريندا برتقال','image'=>'items/mirinda orange.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'مريندا تفاح اخضر','image'=>'items/green apple.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'شويبس','image'=>'items/schweppes.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'راني','image'=>'items/rani.png', 'items_category_id'=>1, 'price'=>8, 'buy_price'=>6],
            ['name'=>'بشاير','image'=>'items/bashayer.png', 'items_category_id'=>1, 'price'=>3, 'buy_price'=>2],
            ['name'=>'جهينة','image'=>'items/juhayna.png', 'items_category_id'=>1, 'price'=>5, 'buy_price'=>4],
            ['name'=>'بيتي','image'=>'items/bety.jpg', 'items_category_id'=>1, 'price'=>5, 'buy_price'=>4],

            ['name'=>'شيبسي 5','image'=>'items/chipsy.png', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],
            ['name'=>'ويندوز 5','image'=>'items/windows5.jpg', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],
            ['name'=>'بريك 5','image'=>'items/break5.jpg', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],
            ['name'=>'دوريتوس 5','image'=>'items/doritos5.png', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],

            ['name'=>'ويندوز 2','image'=>'items/windows2.png', 'items_category_id'=>3, 'price'=>2, 'buy_price'=>1.7],
            ['name'=>'بريك 2','image'=>'items/break2.png', 'items_category_id'=>3, 'price'=>2, 'buy_price'=>1.7],
            ['name'=>'برونتو','image'=>'items/pronto.png', 'items_category_id'=>3, 'price'=>2, 'buy_price'=>1.7],


            ['name'=>'هوهوز','image'=>'items/hohos.png', 'items_category_id'=>4, 'price'=>2, 'buy_price'=>1.7],
            ['name'=>'توينكز','image'=>'items/twinkies.jpg', 'items_category_id'=>4, 'price'=>3, 'buy_price'=>2.6],
            ['name'=>'لمبادا 2','image'=>'items/lambada.jpg', 'items_category_id'=>4, 'price'=>2, 'buy_price'=>1.7],


            ['name'=>'اندومي صغير','image'=>'items/indomie.jpg', 'items_category_id'=>5, 'price'=>7, 'buy_price'=>5],
            ['name'=>'اندومي كبير','image'=>'items/indomie.jpg', 'items_category_id'=>5, 'price'=>8, 'buy_price'=>6],
        ];
        foreach($games as $game){
            Game::create($game);
        }
        foreach ($items_categories as $items_category) {
            ItemCategory::create($items_category);
        }
        foreach ($items as $item) {
            Item::create($item);
        }
        foreach ($device_categories as $category) {
            DeviceCategory::create($category);
        }
        foreach ($device_categories as $category) {
            DeviceCategory::create($category);
        }
        foreach ($devices as $device) {
            Device::create($device);
        }

    }
}
