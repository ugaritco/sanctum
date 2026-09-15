<?php

namespace Workbench\Database\Factories;

use Heritage\Database\Eloquent\Factories\Factory;
use Heritage\Support\Carbon;
use Ugarit\Sanctum\PersonalAccessToken;

/**
 * @phpstan-type TModel \Ugarit\Sanctum\PersonalAccessToken
 *
 * @extends \Heritage\Database\Eloquent\Factories\Factory<TModel>
 */
class PersonalAccessTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Heritage\Database\Eloquent\Model|TModel>
     */
    protected $model = PersonalAccessToken::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'token' => hash('sha256', 'test'),
            'created_at' => Carbon::now(),
            'expires_at' => null,
        ];
    }
}
