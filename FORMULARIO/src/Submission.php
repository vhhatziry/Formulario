<?php

namespace App;

class Submission {
    public string $id;
    public int $timestamp;
    public array $functionalUnits = []; // Stores data for each functional unit

    public function __construct() {
        $this->id = uniqid();
        $this->timestamp = time();
    }

    public static function fromPost(array $postData): self {
        $submission = new self();

        foreach (Config::FUNCS as $cuCode => $cuLabel) {
            $submission->functionalUnits[$cuCode] = [
                'label' => $cuLabel,
                'completo' => $postData['completo'][$cuCode] ?? 'no', // Default to 'no' if not set
                'tiempo' => isset($postData['completo'][$cuCode]) && $postData['completo'][$cuCode] === 'si' ? (int)($postData['tiempo'][$cuCode] ?? 0) : null,
                'errores' => isset($postData['completo'][$cuCode]) && $postData['completo'][$cuCode] === 'si' ? (int)($postData['errores'][$cuCode] ?? 0) : null,
                'notas' => isset($postData['completo'][$cuCode]) && $postData['completo'][$cuCode] === 'si' ? ($postData['notas'][$cuCode] ?? '') : null,
            ];
        }
        return $submission;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'timestamp' => $this->timestamp,
            'functional_units' => $this->functionalUnits,
        ];
    }
}
