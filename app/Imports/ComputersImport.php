<?php

namespace App\Imports;

use App\Models\Computer;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ComputersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info('Imported Row:', $row);

        // Ensure MAC address is provided
        if (empty(trim($row['mac_address'] ?? ''))) {
            Log::warning('Skipping row due to empty MAC Address:', $row);
            return null;
        }

        // Ensure serial number is treated as a string
        $serialNumber = strval(trim($row['serial_number'] ?? ''));

        // Check if a computer already exists by MAC address or Serial Number
        $computer = Computer::where('mac_address', trim($row['mac_address']))
                            ->orWhere('serial_number', $serialNumber)
                            ->first();

        if ($computer) {
            // Update existing computer
            $computer->update([
                'computer_name'     => trim($row['computer_name'] ?? $computer->computer_name),
                'operating_system'  => trim($row['operating_system'] ?? $computer->operating_system),
                'model'             => trim($row['model'] ?? $computer->model),
                'ip_address'        => trim($row['ip_address'] ?? $computer->ip_address),
                'disk_size'         => trim($row['disk_size'] ?? $computer->disk_size),
                'ram'               => trim($row['ram'] ?? $computer->ram),
                'serial_number'     => $serialNumber, // Ensure serial number is updated safely
                'site_id'           => $computer->site_id ?? rand(1, 2), // Assign a random site if it's not set

            ]);

            Log::info("Updated Computer: " . $computer->mac_address);
            return null; // No need to insert a new record
        }

        // Create new computer if no existing record is found
        return new Computer([
            'computer_name'     => trim($row['computer_name'] ?? ''),
            'operating_system'  => trim($row['operating_system'] ?? ''),
            'model'             => trim($row['model'] ?? ''),
            'mac_address'       => trim($row['mac_address'] ?? ''),
            'ip_address'        => trim($row['ip_address'] ?? null),
            'disk_size'         => trim($row['disk_size'] ?? ''),
            'ram'               => trim($row['ram'] ?? ''),
            'serial_number'     => $serialNumber, // Ensure serial number is stored correctly
            'site_id'           => $computer->site_id ?? rand(1, 2), // Assign a random site if it's not set
        ]);
    }
}
