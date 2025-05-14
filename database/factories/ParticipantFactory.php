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
            'full_name' => $cleanName,
            'id_entry' => self::$raffleCounter + 1,
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
    $reference = \Carbon\Carbon::create(2025, 5, 1, 0, 0, 0, 'UTC');
    $now = now('UTC');

    // Get total milliseconds since reference
    $milliseconds = $reference->diffInRealMilliseconds($now);

    // Convert to base36 (uppercase)
    $base36 = strtoupper(base_convert((string) $milliseconds, 10, 36));

    // Always return exactly 8 characters
    return str_pad($base36, 8, '0', STR_PAD_LEFT) . "00";
}


public function generateRaffleCode(): string
{
    // Ensure raffleBatchStamp is initialized
    self::init();

    // Convert the current counter to base36
    $counterBase36 = strtoupper(base_convert((string) self::$raffleCounter, 10, 36));

    // Add the base36 raffleCounter to the raffleBatchStamp
    $finalCode = self::addBase36(self::$raffleBatchStamp, $counterBase36);

    self::$raffleCounter++; // Increment for next use
    return $finalCode;
}

public static function addBase36(string $base36A, string $base36B): string
{
    // Convert both to decimal
    $decimalA = base_convert($base36A, 36, 10);
    $decimalB = base_convert($base36B, 36, 10);

    // Add them
    $sumDecimal = bcadd($decimalA, $decimalB); // bcadd handles large numbers as strings

    // Convert back to base36 and return uppercase
    return strtoupper(base_convert($sumDecimal, 10, 36));
}


}
