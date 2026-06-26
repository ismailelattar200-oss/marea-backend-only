<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Seed sample job applications.
     */
    public function run(): void
    {
        $applications = [
            [
                'name'        => 'Laura Méndez',
                'email'       => 'laura.mendez@gmail.com',
                'phone'       => '+34 612 300 001',
                'position'    => 'Camarero/a',
                'message'     => 'Tengo 3 años de experiencia en restaurantes de alta gama. Hablo español, francés e inglés. Disponibilidad inmediata para turnos de tarde y noche.',
                'cv_path'     => null,
                'is_reviewed' => false,
            ],
            [
                'name'        => 'Omar Tazi',
                'email'       => 'omar.tazi@gmail.com',
                'phone'       => '+34 612 300 002',
                'position'    => 'Ayudante de Cocina',
                'message'     => 'Soy cocinero con formación en cocina marroquí tradicional. Busco unirme a un equipo donde pueda aportar mi conocimiento de la gastronomía del Magreb.',
                'cv_path'     => null,
                'is_reviewed' => true,
            ],
            [
                'name'        => 'Cristina Ruiz',
                'email'       => 'cristina.ruiz@hotmail.com',
                'phone'       => '+34 612 300 003',
                'position'    => 'Repartidor/a',
                'message'     => 'Dispongo de moto propia y carnet de conducir. Disponibilidad completa, incluidos fines de semana. Zona centro de Madrid.',
                'cv_path'     => null,
                'is_reviewed' => false,
            ],
            [
                'name'        => 'Alejandro Vega',
                'email'       => 'alex.vega@gmail.com',
                'phone'       => '+34 612 300 004',
                'position'    => 'Barman',
                'message'     => 'Barista y barman con experiencia en coctelería creativa. Me encantaría crear cócteles con inspiración mediterránea para MAREA.',
                'cv_path'     => null,
                'is_reviewed' => false,
            ],
        ];

        foreach ($applications as $app) {
            JobApplication::create($app);
        }
    }
}
