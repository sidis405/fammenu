<?php

use App\Dish;
use App\Menu;
use App\User;
use App\DishType;
use App\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'name' => 'Sid',
            'email' => 'forge405@gmail.com',
            'password' => Hash::make('password')
        ]);

        $restaurants = factory(Restaurant::class, 3)->create();

        foreach ($restaurants as $restaurant) {
            $restaurant->users()->attach($user);
        }

        factory(DishType::class)->create([
            'name' => 'Primo'
        ]);

        factory(DishType::class)->create([
            'name' => 'Secondo'
        ]);

        factory(DishType::class)->create([
            'name' => 'Contorno'
        ]);

        $dishTypes = DishType::all();

        foreach (range(1, 90) as $item) {
            factory(Dish::class)->create([
                'user_id' => $user->id,
                'restaurant_id' => $restaurants->random()->id,
                'dish_type_id' => $dishTypes->random()->id
            ]);
        }

        $dishes = Dish::all();

        foreach ($restaurants as $restaurant) {
            $menus = factory(Menu::class, 3)->create([
                'user_id' => $user->id,
                'restaurant_id' => $restaurant->id,
            ]);

            foreach ($menus as $menu) {
                $menu->dishes()->attach($dishes->where('dish_type_id', 1)->random());
                $menu->dishes()->attach($dishes->where('dish_type_id', 2)->random());
                $menu->dishes()->attach($dishes->where('dish_type_id', 3)->random());

                $menu->updateCal();
            }
        }
    }
}
