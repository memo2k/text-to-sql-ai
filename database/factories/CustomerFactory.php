<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => fake()->numerify('###-###-####'),
            'email' => strtolower($firstName.'.'.$lastName.'.'.fake()->unique()->numerify('###').'@'.fake()->freeEmailDomain()),
        ];
    }
}
