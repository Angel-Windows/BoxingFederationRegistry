<?php

namespace Database\Seeders\Linking;

use App\Models\Class\ClassType;
use App\Models\Linking\LinkingMembers;
use App\Traits\DataTypeTrait;
use Faker\Factory;
use Illuminate\Database\Seeder;

class LinkingMembersSeeder extends Seeder
{
    use DataTypeTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $create = [];
        $link_category = ClassType::whereIsset('linking');
        foreach ($link_category as $item) {
            $parent_table = \DB::table($item->link)->get();
            foreach ($parent_table as $item_parent) {
                foreach (json_decode($item->linking) as $item_link) {
                    $category_type = ClassType::getIdCategory($item_link);
                    $count_rand = random_int(2, 14);
                    $table_link = \DB::table($item_link)->inRandomOrder()->limit($count_rand)->get();
                    foreach ($table_link as $item_table) {
                        $create[] = [
                            'category_id' => $item_parent->id,
                            'category_type' => $item->id,
                            'member_id' => $item_table->id,
                            'member_type' => $category_type,
                            'type' => 1,
                            'role' => Factory::create()->jobTitle,
                            'date_start_at' => Factory::create()->date,
                            'date_end_at' => random_int(0,1) ? Factory::create()->date : null,
                        ];
                    }
                }
            }
        }

        LinkingMembers::truncate();
        LinkingMembers::insert($create);
    }
}
