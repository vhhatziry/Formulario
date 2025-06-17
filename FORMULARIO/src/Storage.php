<?php

namespace App;

class Storage {
    private string $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath)) {
            // Initialize with an empty array if the file doesn't exist
            $this->writeAll([]);
        }
    }

    public function readAll(): array {
        if (!is_readable($this->filePath)) {
            // Or handle error appropriately
            return [];
        }
        $json_data = file_get_contents($this->filePath);
        if ($json_data === false) {
            // Or handle error appropriately
            return [];
        }
        $data = json_decode($json_data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Or handle error, e.g., return empty array or throw exception
            return [];
        }
        return $data ?? []; // Return empty array if null (e.g. empty file)
    }

    public function writeAll(array $data): bool {
        if (!is_writable(dirname($this->filePath))) {
             // Try to create the directory if it doesn't exist
            if (!mkdir(dirname($this->filePath), 0777, true) && !is_dir(dirname($this->filePath))) {
                // Or handle error appropriately if directory creation fails
                error_log("Storage: Directory is not writable and could not be created: " . dirname($this->filePath));
                return false;
            }
        }
        // Ensure the file itself is writable, or can be created.
        // For simplicity, we're relying on directory writability for file creation.
        // More robust error handling might be needed for production.

        $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json_data === false) {
            // Or handle error appropriately
            error_log("Storage: Failed to encode data to JSON.");
            return false;
        }
        $result = file_put_contents($this->filePath, $json_data);
        if ($result === false) {
            error_log("Storage: Failed to write data to file: " . $this->filePath);
        }
        return $result !== false;
    }
}
