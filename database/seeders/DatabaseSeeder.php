<?php

use App\Models\Bill;
use App\Models\CafeBillItem;
use App\Models\Device;
use App\Models\devicesCategory;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\itemsCategory;
use App\Models\playSession;
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
            'name' => 'أشرف الداودى',
            'email' => 'ashraf@gmail.com',
            'phone' => '0123456789',
            'password' => bcrypt('123456')
        ]);
        DevicesCategory::create([
            'name' => 'بلايستيشن 3',
            'price' => 5,
            'multi_price' => 10,
        ]);
        DevicesCategory::create([
            'name' => 'بلايستيشن 4',
            'price' => 10,
            'multi_price' => 15,
        ]);
        Device::create([
            'name' => 'جهاز 1',
            'games' => 'PES 2019, PES 2020',
            'devices_category_id' => 1,
        ]);
        Device::create([
            'name' => 'جهاز 2',
            'games' => 'PES 2019, PES 2020',
            'devices_category_id' => 1,
        ]);
        Device::create([
            'name' => 'جهاز 3',
            'games' => 'PES 2019, PES 2020',
            'devices_category_id' => 1,
        ]);
        Device::create([
            'name' => 'جهاز 4',
            'games' => 'PES 2019, PES 2020',
            'devices_category_id' => 1,
        ]);
        Device::create([
            'name' => 'جهاز 5',
            'games' => 'PES 2019, PES 2020',
            'devices_category_id' => 2,
        ]);
        Device::create([
            'name' => 'جهاز 6',
            'games' => 'PES 2019, PES 2020',
            'devices_category_id' => 2,
        ]);
        itemsCategory::create([
            'name' => 'مشروبات',
        ]);
        itemsCategory::create([
            'name' => 'مأكولات',
        ]);
        Item::create([
            'name' => 'مشروب 1',
            'price' => 5,
            'buy_price' => 4.5,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'مشروب 2',
            'price' => 10,
            'buy_price' => 9,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'مشروب 3',
            'price' => 15,
            'buy_price' => 10,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'مشروب 4',
            'price' => 20,
            'buy_price' => 18,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'مشروب 5',
            'price' => 25,
            'buy_price' => 20,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'اكلات 1',
            'price' => 10,
            'buy_price' => 8,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'اكلات 2',
            'price' => 15,
            'buy_price' => 12,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'اكلات 3',
            'price' => 20,
            'buy_price' => 12,
            'items_category_id' => 1,
        ]);
        Item::create([
            'name' => 'اكلات 4',
            'price' => 25,
            'buy_price' => 22,
            'items_category_id' => 1,
        ]);

        Inventory::create([
            'item_id' => 1,
            'quantity' => 10,
            'type' => 'BUY',
            'user_id' => 1,
        ]);
        Inventory::create([
            'item_id' => 2,
            'quantity' => 20,
            'type' => 'BUY',
            'user_id' => 1,
        ]);
        Inventory::create([
            'item_id' => 3,
            'quantity' => 33,
            'type' => 'BUY',
            'user_id' => 1,
        ]);
        Inventory::create([
            'item_id' => 4,
            'quantity' => 55,
            'type' => 'BUY',
            'user_id' => 1,
        ]);

        Bill::create([
            'user_id' => 1,
        ]);
        Bill::create([
            'user_id' => 1,
        ]);


        CafeBillItem::create([
            'bill_id' => 1,
            'item_id' => 1,
            'quantity' => 3,
            'price' => Item::find(1)->price,
        ]);

        CafeBillItem::create([
            'bill_id' => 1,
            'item_id' => 2,
            'quantity' => 2,
            'price' => Item::find(2)->price,
        ]);
        CafeBillItem::create([
            'bill_id' => 1,
            'item_id' => 4,
            'quantity' => 1,
            'price' => Item::find(3)->price,
        ]);

        CafeBillItem::create([
            'bill_id' => 2,
            'item_id' => 6,
            'quantity' => 8,
            'price' => Item::find(6)->price,
        ]);

        CafeBillItem::create([
            'bill_id' => 2,
            'item_id' => 7,
            'quantity' => 4,
            'price' => Item::find(7)->price,
        ]);
        CafeBillItem::create([
            'bill_id' => 2,
            'item_id' => 6,
            'quantity' => 2,
            'price' => Item::find(6)->price,
        ]);
    }
}
