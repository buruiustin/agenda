<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Phone;

class TestContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact = Contact::create([
            'nume' => 'Buruiana',
            'prenume' => 'Iustin',
            'sex' => 'M',
            'email' => 'buruiustin@gmail.com',
            'cnp' => '1920511330219',
            'data_nastere' => '1992-05-11',
        ]);

        Phone::create([
            'number' => '0740800798',
            'contact_id' => $contact->id,
        ]);

        Phone::create([
            'number' => '0230000000',
            'contact_id' => $contact->id,
        ]);

    }
}
