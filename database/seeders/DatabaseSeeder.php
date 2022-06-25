<?php

use App\Models\Bill;
use App\Models\CafeBillItem;
use App\Models\Device;
use App\Models\devicesCategory;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\itemsCategory;
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
            ['name'=>'شاي','image'=>'tea.png', 'items_category_id'=>2, 'price'=>4, 'buy_price'=>1],
            ['name'=>'كافي ميكس','image'=>'Bonjorno.png', 'items_category_id'=>2, 'price'=>5, 'buy_price'=>2],
            ['name'=>'نسكافيه','image'=>'nescafe.jpg', 'items_category_id'=>2, 'price'=>5, 'buy_price'=>3],

            ['name'=>'بيبسي','image'=>'pepsi.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'مريندا برتقال','image'=>'mirinda orange.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'مريندا تفاح اخضر','image'=>'green apple.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'شويبس','image'=>'schweppes.png', 'items_category_id'=>1, 'price'=>7, 'buy_price'=>6],
            ['name'=>'راني','image'=>'schweppes.png', 'items_category_id'=>1, 'price'=>8, 'buy_price'=>6],
            ['name'=>'بشاير','image'=>'bashayer.png', 'items_category_id'=>1, 'price'=>3, 'buy_price'=>2],
            ['name'=>'جهينة','image'=>'juhayna.png', 'items_category_id'=>1, 'price'=>5, 'buy_price'=>4],
            ['name'=>'بيتي','image'=>'bety.jpg', 'items_category_id'=>1, 'price'=>5, 'buy_price'=>4],

            ['name'=>'شيبسي','image'=>'chipsy.png', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],
            ['name'=>'ويندوز','image'=>'windows5.jpg', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],
            ['name'=>'بريك','image'=>'break5.jpg', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],
            ['name'=>'دوريتوس','image'=>'doritos5.png', 'items_category_id'=>3, 'price'=>5, 'buy_price'=>4.5],

            ['name'=>'ويندوز','image'=>'windows2.png', 'items_category_id'=>3, 'price'=>2, 'buy_price'=>1.7],
            ['name'=>'بريك','image'=>'break2.png', 'items_category_id'=>3, 'price'=>2, 'buy_price'=>1.7],
            ['name'=>'برونتو','image'=>'pronto.png', 'items_category_id'=>3, 'price'=>2, 'buy_price'=>1.7],


            ['name'=>'هوهوز','image'=>'hohos.png', 'items_category_id'=>4, 'price'=>2, 'buy_price'=>1.7],
            ['name'=>'توينكز','image'=>'twinkies.jpg', 'items_category_id'=>4, 'price'=>3, 'buy_price'=>2.6],
            ['name'=>'لمبادا','image'=>'lambada.jpg', 'items_category_id'=>4, 'price'=>2, 'buy_price'=>1.7],


            ['name'=>'اندومي صغير','image'=>'indomie.jpg', 'items_category_id'=>5, 'price'=>6, 'buy_price'=>4],
            ['name'=>'اندومي كبير','image'=>'indomie.jpg', 'items_category_id'=>5, 'price'=>6, 'buy_price'=>4],
        ];
        foreach ($items_categories as $items_category) {
            itemsCategory::create($items_category);
        }
        foreach ($items as $item) {
            Item::create($item);
        }
        foreach ($device_categories as $category) {
            devicesCategory::create($category);
        }
        foreach ($device_categories as $category) {
            devicesCategory::create($category);
        }
        foreach ($devices as $device) {
            Device::create($device);
        }

    }
}
