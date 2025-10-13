<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition(): array
    {
        static $ebooks = [
            [
                'name' => 'Laravel Dominado',
                'description' => 'Ebook completo sobre arquitetura, boas práticas e performance em Laravel 12.',
                'price' => 2.90,
            ],
            [
                'name' => 'Vue.js 3 na Prática',
                'description' => 'Guia definitivo de SPA com Vue 3, Composition API, e TailwindCSS.',
                'price' => 1.99,
            ],
            [
                'name' => 'PostgreSQL Performance Pro',
                'description' => 'Segredos de consultas rápidas e índices avançados para bancos reais.',
                'price' => 1.50,
            ],
        ];

        static $index = 0;
        $ebook = $ebooks[$index % count($ebooks)];
        $index++;

        return [
            'name' => $ebook['name'],
            'description' => $ebook['description'],
            'price' => $ebook['price'],
        ];
    }
}
