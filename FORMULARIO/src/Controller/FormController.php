<?php

namespace App\Controller;

use App\Storage;
use App\Submission;
use App\Config;

class FormController {
    private Storage $storage;

    public function __construct() {
        $this->storage = new Storage(Config::DATA_FILE);
    }

    public function handleRequest(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submission = Submission::fromPost($_POST);

            $data = $this->storage->readAll();
            $data[] = $submission->toArray();
            $this->storage->writeAll($data);

            // Redirect to index.php after POST
            header('Location: index.php');
            exit;
        }
    }
}
