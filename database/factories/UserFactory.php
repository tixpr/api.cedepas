<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
			'firstname' => mb_strtoupper($this->faker->firstName),
			'lastname'	=> mb_strtoupper($this->faker->lastName),
            'email' => $this->faker->unique()->safeEmail,
			'email_verified_at' => now(),
			'active'=> $this->faker->boolean(),
			'cell_phone'=>$this->faker->phoneNumber,
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		   //'password' => bcrypt('password'),
		   	'remember_token' => Str::random(10),
        ];
    }
}
