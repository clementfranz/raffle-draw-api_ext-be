<?php

namespace Database\Factories;

use App\Models\ParticipantBatch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Exception; // Import Exception class

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

        $cleanName = $firstName . ' ' . $middleInitial . ' ' . $lastName;
        $rawName = $this->generateRawName($cleanName);

        $batchId = ParticipantBatch::inRandomOrder()->first()?->id;

        if (!$batchId) {
            throw new Exception('No ParticipantBatch records found. Seed batches first!');
        }

        return [
            'full_name_raw' => $cleanName,
            'id_entry' => $this->faker->numberBetween(1000, 9999),
            'raffle_code' => $this->generateRaffleCode(self::$raffleCounter),
            'regional_location' => $this->faker->randomElement($regions),
            'registered_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'uploaded_at' => now(),
            'is_drawn' => false,
            'drawn_at' => null,
            'participant_batch_id' => $batchId,
        ];
    }

    public static string $raffleBatchStamp = '';
    public static int $raffleCounter = 0;

    public static function init(): void
    {
        if (empty(self::$raffleBatchStamp)) {
            self::$raffleBatchStamp = self::initializeRaffleBatchStamp();
        }
    }

    public function generateFirstName(): string
    {
        $spanishNames = [
            'Juan', 'Maria', 'Jose', 'Antonio', 'Carlos', 'Isabel', 'Francisco', 'Ramon', 'Luis', 'Pedro',
            'Fernando', 'Manuel', 'Carmen', 'Eduardo', 'Vicente', 'Alejandro', 'Elena', 'Esteban', 'Teresa', 'Lorena',
            'Guillermo', 'Pilar', 'Alfonso', 'Mercedes', 'Roberto', 'Dolores', 'Catalina', 'Ignacio', 'Emilia', 'Raul',
            'Enrique', 'Carolina', 'Miguel', 'Beatriz', 'Salvador', 'Ines', 'Ricardo', 'Marta', 'Juanita', 'Ricarda',
            'Felipe', 'Victor', 'Sofia', 'Graciela', 'Alicia', 'Rosa', 'Gerardo', 'Jesús', 'Concepción',
            'Manuela', 'Margarita', 'Cecilia', 'Angel', 'Estela', 'Hernán', 'Omar', 'Eugenia', 'Luisa'
        ];

        $englishNames = [
            'John', 'Mary', 'James', 'Linda', 'Robert', 'Patricia', 'Michael', 'Elizabeth', 'David', 'Barbara',
            'William', 'Susan', 'Joseph', 'Jessica', 'Charles', 'Sarah', 'Thomas', 'Karen', 'Christopher', 'Nancy',
            'Daniel', 'Betty', 'Matthew', 'Helen', 'Anthony', 'Sandra', 'Mark', 'Dorothy', 'Steven',
            'George', 'Laura', 'Kenneth', 'Sharon', 'Paul', 'Andrew', 'Carol', 'Edward', 'Margaret',
            'Joshua', 'Diane', 'Kevin', 'Amy', 'Timothy', 'Rebecca', 'Kimberly', 'Jeffrey', 'Rachel'
        ];

        $firstName = $this->faker->randomElement($spanishNames);
        $secondName = $this->faker->randomElement($englishNames);

        return $this->faker->randomElement([
            $firstName . ' ' . $secondName,
            $secondName . ' ' . $firstName
        ]);
    }

    public function generateLastName(): string
    {
        $lastNames = [
            'Santos', 'Dela Cruz', 'Reyes', 'Gonzales', 'Cruz', 'Garcia', 'Lopez', 'Martinez', 'Perez', 'Ramirez',
            'Bautista', 'Torres', 'Ramos', 'Castillo', 'Diaz', 'Morales', 'Vargas', 'Jimenez', 'Serrano', 'Mendoza',
            'Delos Santos', 'Villanueva', 'Tan', 'Zamora', 'Estrada', 'Alvarez', 'Natividad', 'Aguirre', 'Gomez',
            'Escobar', 'Rivera', 'Pascual', 'Sison', 'Marquez', 'Benedicto', 'Salazar', 'Ferrer',
            'Bacani', 'Cabrera', 'Valencia', 'Abad', 'Mabanta', 'Baluyot', 'Escalante', 'Luna', 'Rios', 'Gonzalo',
            'Calderon', 'Ocampo', 'Del Rosario', 'De Guzman', 'Castro', 'Arias', 'Arroyo', 'Lucero',
            'Barretto', 'Fajardo', 'Guevarra', 'Nunez', 'Manlapig', 'Lacson', 'Flores', 'Salvador', 'Bagabaldo',
            'Macalino', 'Torralba', 'Soliman', 'Barrera', 'Arenas', 'Dimagiba', 'Abello'
        ];

        return $this->faker->randomElement($lastNames);
    }

    public function cleanFullName(string $fullName): string
    {
        $nameParts = explode(' ', $fullName);
        if (count($nameParts) > 2) {
            array_shift($nameParts);
        }
        return implode(' ', array_map('ucwords', $nameParts));
    }

    public function generateRawName(string $cleanedName): string
    {
        $rawName = strtoupper(str_replace(' ', '', $cleanedName));
        $rawName .= $this->faker->word();
        if (rand(0, 1) === 0) {
            $rawName = strtolower($rawName);
        }
        $rawName .= rand(100, 999);
        return $rawName;
    }

    public static function initializeRaffleBatchStamp(): string
    {
        $now = now();

        // Timestamp-based 5 characters
        $year = strtoupper(base_convert($now->format('y'), 10, 36));
        $month = strtoupper(base_convert($now->format('m'), 10, 36));
        $day = strtoupper(base_convert($now->format('d'), 10, 36));
        $hour = strtoupper(base_convert($now->format('H'), 10, 36));
        $minute = strtoupper(base_convert($now->format('i'), 10, 36));
        $minute = substr($minute, -1); // force 1 char
        $second = strtoupper(base_convert($now->format('s'), 10, 36)); // Convert seconds to base36

        return $year . $month . $day . $hour . $minute . $second;
    }


    public function generateRaffleCode(int $counter): string
    {
        // Ensure raffleBatchStamp is initialized before use
        self::init();

        // Base36 characters (0-9, A-Z)
        $allCharacters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($allCharacters); // 36 characters in base36
        $code = ''; // Start with an empty code string

        // Generate a 5-character code from the counter
        for ($i = 0; $i < 4; $i++) {
            $remainder = $counter % $base; // Get the base36 digit
            $code = $allCharacters[$remainder] . $code; // Prepend the character
            $counter = intdiv($counter, $base); // Divide the counter by 36 for the next iteration
        }

        self::$raffleCounter++; // Increment the counter for the next call
        return self::$raffleBatchStamp . $code;
    }
}
