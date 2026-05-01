<?php
namespace App\Livewire;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;

class ParentVerification extends Component
{
    use WithFileUploads;

    public $parentIdFront;
    public $parentIdBack;
    public $parentSignature;
    public $parentSelfie;
    public $idFrontTempUrl;

    public string $step = 'upload';

    public bool  $faceVerified       = false;
    public float $matchScore         = 0.0;
    public bool  $livenessPassedFlag = false;

    protected $rules = [
        'parentIdFront'   => 'nullable|image|max:20480',
        'parentIdBack'    => 'nullable|image|max:20480',
        'parentSignature' => 'nullable|image|max:20480',
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

        $paths = [];
        if ($this->parentIdFront)   $paths['parent_id_front']  = $this->parentIdFront->store('parent_id', 'public');
        if ($this->parentIdBack)    $paths['parent_id_back']   = $this->parentIdBack->store('parent_id', 'public');
        if ($this->parentSignature) $paths['parent_signature'] = $this->parentSignature->store('parent_id', 'public');
        if ($this->parentSelfie)    $paths['parent_selfie']    = $this->parentSelfie->store('parent_id', 'public');

        Session::put('verification_files', $paths);

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
        Session::forget('verification_files');
        $this->dispatch('clear-id-storage');
    }

    public function getIdFrontUrlProperty(): ?string
    {
        return $this->parentIdFront?->temporaryUrl();
    }

    public function render()
    {
        return view('livewire.parent-verification');
    }
}