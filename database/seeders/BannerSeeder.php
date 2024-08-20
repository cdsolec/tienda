<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Banner::factory()->create(['name' => 'Slide 1', 'image' => 'slide1.jpg' ]);
    Banner::factory()->create(['name' => 'Slide 2', 'image' => 'slide2.jpg' ]);
    Banner::factory()->create(['name' => 'Slide 3', 'image' => 'slide3.jpg' ]);
  }
}
