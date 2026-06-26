<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Seed sample contact form submissions.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name'    => 'Patricia Moreno',
                'email'   => 'patricia@gmail.com',
                'message' => '¡Hola! Me gustaría saber si es posible reservar el restaurante completo para una boda de 80 personas el próximo septiembre. ¿Podrían enviarme información sobre menús y precios?',
                'is_read' => false,
            ],
            [
                'name'    => 'Francisco López',
                'email'   => 'flopez@empresa.com',
                'message' => 'Somos una empresa de 30 personas y nos gustaría organizar una cena de empresa. ¿Tienen menú de grupo? ¿Cuál es el presupuesto aproximado por persona?',
                'is_read' => true,
            ],
            [
                'name'    => 'Sofía Herrera',
                'email'   => 'sofia.h@gmail.com',
                'message' => 'Felicidades por el restaurante, la comida estuvo increíble. El tajín de cordero es el mejor que he probado fuera de Marruecos. ¡Volveré seguro!',
                'is_read' => true,
            ],
            [
                'name'    => 'Daniel Martín',
                'email'   => 'dmartin@gmail.com',
                'message' => '¿Ofrecen opciones para celíacos? Mi pareja tiene intolerancia al gluten y nos gustaría cenar allí este fin de semana.',
                'is_read' => false,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
