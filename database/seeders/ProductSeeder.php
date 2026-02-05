<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\RentalPeriod;
use App\Models\RentalPrice;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Bailarina Compactadora Mikasa',
                'description' => 'Modelo MT74FAF. Motor a gasolina Subaru EH-12D. 3.5hp. Dimensiones de la Zapata. (mm). 285X340. Fuerza de impacto. (Kn).13.79.',
                'image' => 'images/mini/R_001.jpg', // Using mini for rental list usually, or high res
                'category' => 'Compactación',
                'is_rental' => true,
                'is_for_sale' => true, // Assuming keeping both true for overlap
                'prices' => [
                    ['period' => 'day', 'price' => 500],
                    ['period' => 'week', 'price' => 2100],
                    ['period' => 'month', 'price' => 6900],
                ]
            ],
            [
                'name' => 'Revolvedora',
                'description' => 'Marca CIPSA modelo ultra 10. Con motor a gasolina. Honda o mpower de 9 hp. Capacidad de mezcla (lt) 255. Producción (m3) 5. Velocidad de olla (RPM) 28-32. Llantas neumáticas.',
                'image' => 'images/mini/R_002.jpg',
                'category' => 'Concreto',
                'is_rental' => true,
                'is_for_sale' => true,
                'prices' => [
                    ['period' => 'day', 'price' => 600],
                    ['period' => 'week', 'price' => 2100],
                    ['period' => 'month', 'price' => 6800],
                ]
            ],
            [
                'name' => 'Allanadora 36” SIN plato',
                'description' => 'Marca CIPSA. Modelo CA4HM. Motor a gasolina, Honda o Briggs sttraton de 6.5 HP. Peso de operación kg (41). Número de aspas 4. Diámetro de aro (cm) 61. RPM del motor 50-107.',
                'image' => 'images/mini/R_003.jpg',
                'category' => 'Concreto',
                'is_rental' => true,
                'is_for_sale' => false,
                'prices' => [
                    ['period' => 'day', 'price' => 615],
                    ['period' => 'week', 'price' => 3200],
                    ['period' => 'month', 'price' => 6200],
                ]
            ],
            [
                'name' => 'Allanadora 36” CON plato',
                'description' => 'Marca CIPSA. Modelo CA4HM. Motor a gasolina, Honda o Briggs sttraton de 6.5 HP. Peso de operación kg (41). Número de aspas 4. Diámetro de aro (cm) 61. RPM del motor 50-107.',
                'image' => 'images/mini/R_004.jpg',
                'category' => 'Concreto',
                'is_rental' => true,
                'is_for_sale' => false,
                'prices' => [
                    ['period' => 'day', 'price' => 800],
                    ['period' => 'week', 'price' => 4300],
                ]
            ],
            [
                'name' => 'Vibrador a gasolina',
                'description' => 'Marca CIPSA. Motor a gasolina. Motor honda o mpower de 6.5 HP. Con chicotes de 4 y 6 metros de largo. Sistemas de vibración pendular o exentrico.',
                'image' => 'images/mini/R_005.jpg',
                'category' => 'Concreto',
                'is_rental' => true,
                'is_for_sale' => true,
                'prices' => [
                    ['period' => 'day', 'price' => 450],
                    ['period' => 'week', 'price' => 1900],
                    ['period' => 'month', 'price' => 6000],
                ]
            ],
            [
                'name' => 'Rompedora de piso 30kg',
                'description' => 'Marca Makita. Peso aprox. 30 k. Modelo HM 1801. 120V. 15 A. 1.100 gpm.',
                'image' => 'images/mini/R_007.jpg',
                'category' => 'Demolición',
                'is_rental' => true,
                'is_for_sale' => true,
                'prices' => [
                    ['period' => 'day', 'price' => 650],
                    ['period' => 'week', 'price' => 3600],
                    ['period' => 'month', 'price' => 9300],
                ]
            ],
            [
                'name' => 'Generador 5,600 W',
                'description' => 'Marca Briggs sttraton. De 5.000 Watts. Con motor Briggs sttraton de 6.5 HP. Motor a gasolina.',
                'image' => 'images/mini/R_012.jpg',
                'category' => 'Generación',
                'is_rental' => true,
                'is_for_sale' => true,
                'prices' => [
                    ['period' => 'day', 'price' => 490],
                    ['period' => 'week', 'price' => 2200],
                    ['period' => 'month', 'price' => 6750],
                ]
            ],
            [
                'name' => 'Módulo andamio',
                'description' => 'Módulo de andamio estándar.',
                'image' => 'images/mini/R_013.jpg',
                'category' => 'Andamios',
                'is_rental' => true,
                'is_for_sale' => false,
                'prices' => [
                    ['period' => 'day', 'price' => 40],
                ]
            ],
            [
                'name' => 'Tablón para andamio',
                'description' => 'Tablón metálico o de madera para andamio.',
                'image' => 'images/mini/R_014.jpg',
                'category' => 'Andamios',
                'is_rental' => true,
                'is_for_sale' => false,
                'prices' => [
                    ['period' => 'day', 'price' => 35],
                ]
            ],
            [
                'name' => 'Motobomba 2" y 3"',
                'description' => 'Motobomba con mangueras. Marca MQ. Motor a gasolina. Motor honda o Kohler de 6.5 HP.',
                'image' => 'images/mini/R_013.jpg', // Placeholder, reusing existing or R_015 if I had it
                'category' => 'Bombeo',
                'is_rental' => true,
                'is_for_sale' => true,
                'prices' => [
                    ['period' => 'day', 'price' => 550],
                    ['period' => 'week', 'price' => 1900],
                    ['period' => 'month', 'price' => 5850],
                ]
            ],
            [
                'name' => 'Cortadora de concreto',
                'description' => 'Cortadora de concreto de piso con disco.',
                'image' => 'images/mini/R_011.jpg',
                'category' => 'Corte',
                'is_rental' => true,
                'is_for_sale' => false,
                'prices' => [
                    ['period' => 'day', 'price' => 900],
                    ['period' => 'week', 'price' => 4200],
                    ['period' => 'month', 'price' => 10500],
                ]
            ],
            // Additional items for Sale only (from venta_de_maquinaria.php that might differ)
            [
                'name' => 'Placa vibratoria',
                'description' => 'CIPSA modelo CM 13. Motor a gasolina, Marca mpower o Honda de 9 HP. Dimensiones de placa (cm)46X43.5. Fuerza centrifuga (KG) 1800. Frecuencia de vibración. (RPM) 4.500.',
                'image' => 'images/articulos/placa-vibratoria.png',
                'category' => 'Compactación',
                'is_rental' => false,
                'is_for_sale' => true,
                'prices' => []
            ],
        ];

        foreach ($products as $data) {
            $prices = $data['prices'];
            unset($data['prices']);

            $product = Product::create($data);

            foreach ($prices as $price) {
                $period = RentalPeriod::where('name', $price['period'])->first();
                if ($period) {
                    $product->rentalPrices()->create([
                        'rental_period_id' => $period->id,
                        'price' => $price['price'],
                        'currency' => 'MXN', // ensuring currency is set
                    ]);
                }
            }
        }
    }
}
