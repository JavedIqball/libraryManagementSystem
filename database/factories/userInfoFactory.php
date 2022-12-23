<?php

namespace Database\Factories;

use App\Models\userInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class userInfoFactory extends Factory
{
    protected $model = userInfo::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'username'=>$this->faker->name(),
                'email'=>$this->faker->unique()->safeEmail(),
                'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'role'=>'user',
        ];
    }
}
