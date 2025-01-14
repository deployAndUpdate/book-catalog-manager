<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $themes = [
            'The Mystery of the Lost Island',
            'Adventures in Space',
            'The Secrets of Ancient Civilizations',
            'A Journey Through Time',
            'The Art of War',
            'Cooking with Love',
            'The Science of Happiness',
            'Tales from the Wild West',
            'Under the Ocean',
            'Legends of the Forgotten Realms',
        ];

        return [
            'title' => $this->faker->randomElement($themes),
            'description' => $this->faker->paragraph(3),
            'author_id' => Author::inRandomOrder()->first()->id,
            'publication_year' => $this->faker->year,
        ];
    }
}
