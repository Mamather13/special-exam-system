{{-- resources/views/livewire/parent-verification.blade.php --}}
<div
    x-data="faceVerify()"
    x-init="init()"
    class="space-y-4"
>

    {{-- STEP 1: UPLOAD IDs --}}
    @if($step === 'upload')
    <div class="space-y-4">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                Parent Consent &amp; ID Verification
            </h3>

            <div class="mb-4">
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Parent ID &mdash; Front <span class="text-red-500">*</span>
                </label>
                <input type="file" wire:model="parentIdFront" accept="image/*"
                    id="parentIdFrontFile"
                    x-on:change="handleIdFrontUpload($event)"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                           file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1
                           file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100">
                @error('parentIdFront')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <img id="id-front-preview" src="" alt="ID Front Preview"
                    class="mt-2 h-24 w-auto rounded-lg border border-gray-200 object-cover hidden"
                    crossorigin="anonymous">
            </div>

            <div class="mb-4">
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Parent ID &mdash; Back <span class="text-red-500">*</span>
                </label>
                <input type="file" wire:model="parentIdBack" accept="image/*"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                           file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1
                           file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100">
                @error('parentIdBack')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Parent Signature <span class="text-red-500">*</span>
                </label>
                <input type="file" wire:model="parentSignature" accept="image/*"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                           file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1
                           file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-xs text-gray-400">Parent signs on paper, take photo, then upload.</p>
            </div>

            <button type="button"
                wire:loading.attr="disabled"
                wire:click="proceedToLiveness"
                class="mt-2 w-full rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold
                       text-white shadow-sm transition hover:bg-blue-700 active:scale-95 disabled:opacity-50">
                <span wire:loading.remove wire:target="proceedToLiveness">Continue to Face Verification</span>
                <span wire:loading wire:target="proceedToLiveness">Loading...</span>
            </button>
        </div>
    </div>
    @endif

    {{-- STEP 2: LIVENESS DETECTION --}}
    @if($step === 'liveness')
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Face Verification</h3>
            <button type="button" wire:click="resetVerification" class="text-xs text-gray-400 hover:text-gray-600">
                Back
            </button>
        </div>

        <div class="mb-3 rounded-lg bg-blue-50 px-4 py-2.5 text-sm text-blue-700" x-text="statusMessage"></div>

        <div class="mb-4 flex flex-wrap gap-2">
            <template x-for="(ch, idx) in challenges" :key="idx">
                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium"
                    :class="{
                        'bg-green-100 text-green-700': ch.done,
                        'bg-blue-100 text-blue-700': idx === currentChallenge && !ch.done,
                        'bg-gray-100 text-gray-500': idx > currentChallenge && !ch.done
                    }">
                    <span x-text="ch.done ? 'Done' : (idx === currentChallenge ? '>' : 'o')"></span>
                    <span x-text="ch.label"></span>
                </span>
            </template>
        </div>

        <div class="relative mx-auto w-full max-w-sm overflow-hidden rounded-xl bg-black">
            <video id="liveness-video" autoplay muted playsinline
                class="h-64 w-full object-cover" style="transform: scaleX(-1);"></video>
            <canvas id="liveness-canvas"
                class="pointer-events-none absolute inset-0 h-full w-full" style="transform: scaleX(-1);"></canvas>
            <div class="absolute bottom-2 right-2 rounded-lg bg-black/60 px-2 py-1 text-xs text-white"
                x-show="matchScoreDisplay > 0">
                Match: <span x-text="matchScoreDisplay + '%'"></span>
            </div>
            <div x-show="!modelsLoaded"
                class="absolute inset-0 flex flex-col items-center justify-center bg-black/70 text-white">
                <svg class="mb-2 h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                <span class="text-sm">Loading AI models...</span>
            </div>
        </div>

        <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-gray-100">
            <div class="h-full rounded-full bg-blue-500 transition-all duration-300"
                :style="'width:' + progress + '%'"></div>
        </div>
        <p class="mt-1 text-right text-xs text-gray-400">
            <span x-text="Math.round(progress)"></span>% complete
        </p>
    </div>
    @endif

    {{-- STEP 3: DONE --}}
    @if($step === 'done')
    <div class="rounded-xl border shadow-sm p-5 {{ $faceVerified ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
        <div class="flex items-start gap-3">
            <div class="text-2xl">{{ $faceVerified ? '&#10003;' : '&#10007;' }}</div>
            <div>
                <p class="font-semibold text-sm {{ $faceVerified ? 'text-green-700' : 'text-red-700' }}">
                    {{ $faceVerified ? 'Identity Verified Successfully' : 'Verification Failed' }}
                </p>
                <p class="text-xs mt-0.5 {{ $faceVerified ? 'text-green-600' : 'text-red-600' }}">
                    Match score: {{ number_format($matchScore, 1) }}%
                    &nbsp;&middot;&nbsp;
                    Liveness: {{ $livenessPassedFlag ? 'Passed' : 'Failed' }}
                </p>
                @if(!$faceVerified)
                    <button type="button" wire:click="resetVerification"
                        class="mt-2 text-xs font-medium text-red-600 underline hover:text-red-800">
                        Try Again
                    </button>
                @endif
            </div>
        </div>
        <input type="hidden" name="face_verified"   value="{{ $faceVerified ? '1' : '0' }}">
        <input type="hidden" name="liveness_passed" value="{{ $livenessPassedFlag ? '1' : '0' }}">
        <input type="hidden" name="match_score"     value="{{ $matchScore }}">
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.13/dist/face-api.js"></script>

    <script>
    // ── Image compressor (runs before wire:model upload, keeps files under 1MB) ──
    function compressImage(file, maxSizeMB = 1, maxWidthPx = 1200) {
        return new Promise((resolve) => {
            if (file.size <= maxSizeMB * 1024 * 1024) { resolve(file); return; }
            const img = new Image();
            const url = URL.createObjectURL(file);
            img.onload = () => {
                URL.revokeObjectURL(url);
                const scale   = Math.min(1, maxWidthPx / img.width);
                const canvas  = document.createElement('canvas');
                canvas.width  = Math.round(img.width  * scale);
                canvas.height = Math.round(img.height * scale);
                canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
                canvas.toBlob((blob) => {
                    const compressed = new File([blob], file.name, { type: 'image/jpeg' });
                    console.log('Compressed: ' + Math.round(file.size/1024) + 'KB -> ' + Math.round(compressed.size/1024) + 'KB');
                    resolve(compressed);
                }, 'image/jpeg', 0.82);
            };
            img.src = url;
        });
    }

    // ── Handles ID Front file pick: compress -> preview -> trigger wire:model ──
    async function handleIdFrontUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const compressed = await compressImage(file);

        // Show preview
        if (window._idFrontObjectURL) URL.revokeObjectURL(window._idFrontObjectURL);
        window._idFrontObjectURL = URL.createObjectURL(compressed);
        const preview = document.getElementById('id-front-preview');
        if (preview) { preview.src = window._idFrontObjectURL; preview.classList.remove('hidden'); }

        // Replace the file input value with the compressed file so wire:model uploads it
        const input = document.getElementById('parentIdFrontFile');
        const dt = new DataTransfer();
        dt.items.add(compressed);
        input.files = dt.files;

        console.log('ID front ready: ' + compressed.name + ' (' + Math.round(compressed.size/1024) + 'KB)');
    }

    // ── Alpine component ──────────────────────────────────────────────────────
    function faceVerify() {
        return {
            modelsLoaded:      false,
            statusMessage:     'Loading AI models, please wait...',
            currentChallenge:  0,
            progress:          0,
            matchScoreDisplay: 0,
            challenges: [
                { label: 'Blink',      done: false, key: 'blink'  },
                { label: 'Look Left',  done: false, key: 'left'   },
                { label: 'Look Right', done: false, key: 'right'  },
                { label: 'Look Up',    done: false, key: 'up'     },
                { label: 'Look Down',  done: false, key: 'down'   },
            ],
            idDescriptor: null, videoEl: null, canvasEl: null,
            stream: null, rafId: null, matchScores: [],
            EAR_THRESHOLD: 0.22, POSE_THRESHOLD: 8,

            async init() {
                this.$watch('$wire.step', async (val) => {
                    if (val === 'liveness') await this.loadModels();
                });
            },

            async loadModels() {
                try {
                    const MODEL_URL = '/models';
                    await Promise.all([
                        faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
                        faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                        faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
                    ]);
                    this.modelsLoaded = true;
                    this.statusMessage = 'Models ready. Loading ID face...';
                    await this.extractIdFace();
                } catch(e) {
                    this.statusMessage = 'Error loading models: ' + e.message;
                    console.error(e);
                }
            },

            async extractIdFace() {
                // Use Livewire temporaryUrl() via the computed property
                const tempUrl = await this.$wire.get('idFrontTempUrl');

                // Fallback to in-memory object URL if Livewire temp not ready
                const imgSrc = tempUrl || window._idFrontObjectURL;

                if (!imgSrc) {
                    this.statusMessage = 'ID image not found. Please go back and re-upload.';
                    return;
                }

                const img = new Image();
                img.crossOrigin = 'anonymous';
                img.src = imgSrc;

                await new Promise((resolve, reject) => {
                    img.onload  = resolve;
                    img.onerror = () => reject(new Error('Failed to load ID image'));
                });

                try {
                    const detection = await faceapi
                        .detectSingleFace(img, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.3 }))
                        .withFaceLandmarks()
                        .withFaceDescriptor();

                    if (!detection) {
                        this.statusMessage = 'No face detected in ID. Please go back and use a clearer photo.';
                        return;
                    }

                    this.idDescriptor = detection.descriptor;
                    this.statusMessage = 'ID face extracted. Starting camera...';
                    await this.startCamera();

                } catch(e) {
                    this.statusMessage = 'Error reading ID: ' + e.message;
                    console.error(e);
                }
            },

            async startCamera() {
                this.videoEl  = document.getElementById('liveness-video');
                this.canvasEl = document.getElementById('liveness-canvas');
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({
                        video: { width: 640, height: 480, facingMode: 'user' }
                    });
                    this.videoEl.srcObject = this.stream;
                    await new Promise(r => this.videoEl.addEventListener('loadedmetadata', r));
                    this.videoEl.play();
                    this.statusMessage = this.getChallengeInstruction();
                    this.runDetectionLoop();
                } catch(err) {
                    this.statusMessage = 'Camera access denied. Please allow camera and refresh.';
                    console.error(err);
                }
            },

            async runDetectionLoop() {
                if (this.currentChallenge >= this.challenges.length) { this.finalize(); return; }
                try {
                    const detection = await faceapi
                        .detectSingleFace(this.videoEl, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.3 }))
                        .withFaceLandmarks()
                        .withFaceDescriptor();

                    if (detection) {
                        this.drawOverlay(detection);
                        const distance = faceapi.euclideanDistance(this.idDescriptor, detection.descriptor);
                        const score    = Math.max(0, Math.round((1 - distance) * 100));
                        this.matchScoreDisplay = score;
                        this.matchScores.push(score);

                        const ch = this.challenges[this.currentChallenge];
                        if (this.checkChallenge(ch.key, detection.landmarks)) {
                            ch.done = true;
                            this.currentChallenge++;
                            this.progress = (this.currentChallenge / this.challenges.length) * 100;
                            if (this.currentChallenge < this.challenges.length) {
                                this.statusMessage = this.getChallengeInstruction();
                                await new Promise(r => setTimeout(r, 600));
                            }
                        }
                    } else {
                        this.statusMessage = 'Face not detected - please look at the camera.';
                    }
                } catch(e) { console.error('Detection error:', e); }

                if (this.currentChallenge < this.challenges.length) {
                    this.rafId = requestAnimationFrame(() => this.runDetectionLoop());
                } else {
                    this.finalize();
                }
            },

            checkChallenge(key, landmarks) {
                const pts = landmarks.positions;
                if (key === 'blink') {
                    const l = this.eyeAspectRatio(pts, 36, 37, 38, 39, 40, 41);
                    const r = this.eyeAspectRatio(pts, 42, 43, 44, 45, 46, 47);
                    return ((l + r) / 2) < this.EAR_THRESHOLD;
                }
                const nose = pts[33], chin = pts[8], lEye = pts[36], rEye = pts[45];
                const fw   = rEye.x - lEye.x, fh = chin.y - pts[24].y;
                const cx   = (lEye.x + rEye.x) / 2, cy = (pts[24].y + chin.y) / 2;
                const xOff = ((nose.x - cx) / fw) * 100;
                const yOff = ((nose.y - cy) / fh) * 100;
                if (key === 'left')  return xOff < -this.POSE_THRESHOLD;
                if (key === 'right') return xOff >  this.POSE_THRESHOLD;
                if (key === 'up')    return yOff < -this.POSE_THRESHOLD;
                if (key === 'down')  return yOff >  this.POSE_THRESHOLD;
                return false;
            },

            eyeAspectRatio(pts, p1, p2, p3, p4, p5, p6) {
                const d = (a, b) => Math.hypot(pts[a].x - pts[b].x, pts[a].y - pts[b].y);
                return (d(p2, p6) + d(p3, p5)) / (2 * d(p1, p4));
            },

            drawOverlay(detection) {
                this.canvasEl.width  = this.videoEl.offsetWidth;
                this.canvasEl.height = this.videoEl.offsetHeight;
                faceapi.matchDimensions(this.canvasEl, {
                    width:  this.videoEl.offsetWidth,
                    height: this.videoEl.offsetHeight
                });
                const resized = faceapi.resizeResults(detection, {
                    width:  this.videoEl.offsetWidth,
                    height: this.videoEl.offsetHeight
                });
                const ctx = this.canvasEl.getContext('2d');
                ctx.clearRect(0, 0, this.canvasEl.width, this.canvasEl.height);
                faceapi.draw.drawFaceLandmarks(this.canvasEl, resized);
            },

            finalize() {
                if (this.stream) this.stream.getTracks().forEach(t => t.stop());
                if (this.rafId)  cancelAnimationFrame(this.rafId);

                const allDone  = this.challenges.every(c => c.done);
                const avgScore = this.matchScores.length
                    ? Math.round(this.matchScores.reduce((a, b) => a + b, 0) / this.matchScores.length) : 0;
                const verified = allDone && avgScore >= 75;

                this.statusMessage = verified
                    ? 'Verification complete! Match: ' + avgScore + '%'
                    : 'Verification failed. Match: ' + avgScore + '%. Please try again.';

                if (window._idFrontObjectURL) {
                    URL.revokeObjectURL(window._idFrontObjectURL);
                    window._idFrontObjectURL = null;
                }

                this.$wire.call('completeFaceVerification', {
                    faceVerified:   verified,
                    livenessPassed: allDone,
                    matchScore:     avgScore,
                });
            },

            getChallengeInstruction() {
                const map = {
                    blink: 'Please BLINK your eyes',
                    left:  'Turn your head to the LEFT',
                    right: 'Turn your head to the RIGHT',
                    up:    'Tilt your head UP',
                    down:  'Tilt your head DOWN'
                };
                return map[this.challenges[this.currentChallenge]?.key] ?? 'Done!';
            },
        };
    }

    document.addEventListener('clear-id-storage', () => {
        if (window._idFrontObjectURL) {
            URL.revokeObjectURL(window._idFrontObjectURL);
            window._idFrontObjectURL = null;
        }
    });
    </script>

</div>
