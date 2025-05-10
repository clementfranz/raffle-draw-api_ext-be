<?php

namespace Database\Factories;

use App\Models\ParticipantBatch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regions = [
            'Northern Luzon',
            'Central Luzon',
            'Southern Luzon',
            'Visayas',
            'Mindanao',
            'GMA',
            'Metro Manila'
        ];

        // Generate full name
        $firstName = $this->generateFirstName();
        $lastName = $this->generateLastName();
        $middleInitial = strtoupper($this->faker->randomLetter()) . '.'; // Random middle initial

        $fullName = $firstName . ' ' . $middleInitial . ' ' . $lastName;
        $cleanedName = $this->cleanFullName($fullName); // Cleaned name

        return [
            'full_name_raw' => $this->generateRawName($cleanedName), // Generate messy version
            'full_name_cleaned' => $fullName, // Cleaned version
            'id_entry' => $this->faker->numberBetween(1000, 9999),
            'raffle_code' => $this->generateRaffleCode(),
            'regional_location' => $this->faker->randomElement($regions),
            'registered_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'uploaded_at' => now(),
            'is_drawn' => false,
            'drawn_at' => null,
            'participant_batch_id' => ParticipantBatch::factory(),
        ];
    }

    /**
     * Generate a first name with Filipino influences (Spanish or English).
     *
     * @return string
     */
    public function generateFirstName(): string
{
    // Define Filipino first names (Spanish-like and English names)
    $spanishNames = [
        'Juan', 'Maria', 'Jose', 'Antonio', 'Carlos', 'Isabel', 'Francisco', 'Ramon', 'Luis', 'Pedro',
        'Fernando', 'Manuel', 'Carmen', 'Eduardo', 'Vicente', 'Alejandro', 'Elena', 'Esteban', 'Teresa', 'Lorena',
        'Guillermo', 'Pilar', 'Alfonso', 'Mercedes', 'Roberto', 'Dolores', 'Catalina', 'Ignacio', 'Emilia', 'Raul',
        'Enrique', 'Carolina', 'Miguel', 'Beatriz', 'Salvador', 'Ines', 'Ricardo', 'Marta', 'Juanita', 'Ricarda',
        'Felipe', 'Victor', 'Sofia', 'Antonio', 'Graciela', 'Alicia', 'Rosa', 'Gerardo', 'Jesús', 'Concepción',
        'Manuela', 'Margarita', 'Dolores', 'Cecilia', 'Angel', 'Estela', 'Hernán', 'Omar', 'Eugenia', 'Luisa'
    ];

    $englishNames = [
        'John', 'Mary', 'James', 'Linda', 'Robert', 'Patricia', 'Michael', 'Elizabeth', 'David', 'Barbara',
        'William', 'Susan', 'Joseph', 'Jessica', 'Charles', 'Sarah', 'Thomas', 'Karen', 'Christopher', 'Nancy',
        'Daniel', 'Betty', 'Matthew', 'Helen', 'Anthony', 'Sandra', 'Mark', 'Dorothy', 'Steven', 'Betty',
        'George', 'Laura', 'Kenneth', 'Sharon', 'Paul', 'Betty', 'Andrew', 'Carol', 'Edward', 'Margaret',
        'Joshua', 'Diane', 'Kevin', 'Amy', 'Timothy', 'Rebecca', 'Daniel', 'Kimberly', 'Jeffrey', 'Rachel'
    ];

    // Randomly select one name from each array
    $firstName = $this->faker->randomElement($spanishNames);
    $secondName = $this->faker->randomElement($englishNames);

    // Randomly shuffle the order and return the combination
    return $this->faker->randomElement([$firstName . ' ' . $secondName, $secondName . ' ' . $firstName]);
}


    /**
     * Generate a random Filipino last name from predefined list.
     *
     * @return string
     */
    public function generateLastName(): string
    {
        // List of Filipino last names (common ones)
        $lastNames = [
            'Santos', 'Dela Cruz', 'Reyes', 'Gonzales', 'Cruz', 'Garcia', 'Lopez', 'Martinez', 'Perez', 'Ramirez',
            'Bautista', 'Torres', 'Ramos', 'Castillo', 'Diaz', 'Morales', 'Vargas', 'Jimenez', 'Serrano', 'Mendoza',
            'Delos Santos', 'Pereira', 'Villanueva', 'Tan', 'Zamora', 'Estrada', 'Alvarez', 'Serrano', 'Natividad',
            'Aguirre', 'Gomez', 'Escobar', 'Rivera', 'Pascual', 'Sison', 'Marquez', 'Benedicto', 'Salazar', 'Ferrer',
            'Bacani', 'Cabrera', 'Valencia', 'Abad', 'Mabanta', 'Baluyot', 'Escalante', 'Luna', 'Rios', 'Gonzalo',
            'Calderon', 'Ocampo', 'Del Rosario', 'De Guzman', 'Castro', 'Arias', 'Villanueva', 'Arroyo', 'Lucero',
            'Barretto', 'Fajardo', 'Guevarra', 'Nunez', 'Manlapig', 'Lacson', 'Flores', 'Salvador', 'Bagabaldo',
            'Guevara', 'Macalino', 'Torralba', 'Soliman', 'Barrera', 'Arenas', 'Bismark', 'Dimagiba', 'Abello'
        ];

        return $this->faker->randomElement($lastNames);
    }

    /**
     * Clean the full name to remove unwanted parts and return a proper name.
     *
     * @param string $fullName
     * @return string
     */
    public function cleanFullName(string $fullName): string
    {
        // Here we clean the name by ensuring the first letter of each name part is capitalized
        // and removing any middle names or prefixes if necessary.
        $nameParts = explode(' ', $fullName);

        // We'll assume the name consists of first, middle, and last name, so we clean to remove middle name.
        if (count($nameParts) > 2) {
            array_shift($nameParts); // Remove the first part if we have extra
        }

        // Capitalize each word
        $cleanedName = implode(' ', array_map('ucwords', $nameParts));

        return $cleanedName;
    }

    /**
     * Generate a raw version of the cleaned name by adding randomness.
     *
     * @param string $cleanedName
     * @return string
     */
    public function generateRawName(string $cleanedName): string
    {
        // Create some variation by mixing upper and lower case and adding random unrelated strings
        $rawName = strtoupper($cleanedName); // Start by making it uppercase
        $rawName = str_replace(' ', '', $rawName); // Remove spaces

        // Add random unrelated words or characters to make the name "messy"
        $rawName .= $this->faker->word(); // Add some random word to the name
        if (rand(0, 1) === 0) {
            $rawName = strtolower($rawName); // Randomly make it all lowercase
        }

        // Add a random number or word for further variation
        $rawName .= rand(100, 999);

        return $rawName;
    }

    /**
     * Generate a unique 10-character raffle code with at least 2 digits.
     *
     * @return string
     */
    public function generateRaffleCode(): string
    {
        $code = strtoupper($this->faker->bothify('?????###??')); // 10 chars, at least 3 digits
        // Ensure at least 2 digits are included in the code.
        $code = preg_replace_callback('/[A-Z]/', function($match) {
            return $match[0];
        }, $code);

        // If there are fewer than 2 digits, replace some letters with digits.
        $digits = substr_count($code, '0-9');
        if ($digits < 2) {
            $code = substr_replace($code, rand(1, 9), 6, 1);
            $code = substr_replace($code, rand(1, 9), 8, 1);
        }

        return $code;
    }
}
