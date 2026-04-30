<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ParentVerification extends Component
{
    use WithFileUploads;

    // Uploaded files
    public $parentIdFront;
    public $parentIdBack;
    public $parentSignature;
    public $parentSelfie;
    public $idFrontTempUrl;

    // Step tracking: 'upload' | 'liveness' | 'done'
    public string $step = 'upload';  // ← only declared ONCE

    // Verification results
    public bool  $faceVerified       = false;
    public float $matchScore         = 0.0;
    public bool  $livenessPassedFlag = false;

    protected $rules = [
        'parentIdFront'  => 'nullable|image|max:20480',
        'parentIdBack'   => 'nullable|image|max:20480',
        'parentSignature'=> 'nullable|image|max:20480',
    ];

    public function proceedToLiveness(): void
{
    $this->validate([
        'parentIdFront' => 'required|image|max:20480',
    ]);
     $this->idFrontTempUrl = $this->parentIdFront->temporaryUrl();

    $this->step = 'liveness';
}

    public function completeFaceVerification(array $payload): void
    {
        $this->faceVerified       = (bool)  ($payload['faceVerified']   ?? false);
        $this->livenessPassedFlag = (bool)  ($payload['livenessPassed'] ?? false);
        $this->matchScore         = (float) ($payload['matchScore']     ?? 0);
        $this->step               = 'done';

        $this->dispatch('verification-complete', [
            'faceVerified'   => $this->faceVerified,
            'livenessPassed' => $this->livenessPassedFlag,
            'matchScore'     => $this->matchScore,
        ]);
    }

    public function resetVerification(): void
    {
        $this->faceVerified       = false;
        $this->livenessPassedFlag = false;
        $this->matchScore         = 0.0;
        $this->step               = 'upload';
        $this->parentIdFront      = null;
        $this->parentIdBack       = null;
        $this->parentSignature    = null;
        $this->parentSelfie       = null;
        $this->dispatch('clear-id-storage');
    }

    /**
     * Exposes the uploaded ID front as a temporary URL
     * so face-api.js can load it directly — no base64/sessionStorage needed.
     */
    public function getIdFrontUrlProperty(): ?string
    {
        return $this->parentIdFront?->temporaryUrl();
    }

    public function render()
    {
        return view('livewire.parent-verification');
    }
}