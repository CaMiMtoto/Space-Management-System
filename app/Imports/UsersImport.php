<?php

namespace App\Imports;

use App\Models\User;
use App\Notifications\UserCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;

    public array $errors = [];

    /**
     * @throws \Exception
     */
    public function model(array $row): ?User
    {
        info(json_encode($row));
        // Ensure the keys are correct based on your Excel headers
        $name = $row["name"]; // Ensure this matches the exact header in the file
        $email = $row["email"];
        $phone = $row["phone"];

        // Validate email format using Laravel's Validator
        $emailValidator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        // If email is invalid, log the error and skip this row
        if ($emailValidator->fails()) {
            $this->errors[] = "Invalid email format: {$email}";
            throw new \Exception("Invalid email format: {$email}");
        }

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            throw new \Exception("Email already exists: {$email}");
        }

        // Generate a random password
        $randomPassword = Str::random(8);

        // Create the user
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone,
            'password' => Hash::make($randomPassword), // Hash the password
        ]);
        // Send notification
        $user->notify(new UserCreated($user, $randomPassword));

        return $user;
    }

}
