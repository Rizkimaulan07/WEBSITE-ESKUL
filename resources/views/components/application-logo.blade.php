<!-- resources/views/components/application-logo.blade.php -->
<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <img 
        src="{{ asset('images/logo-smk-bppi.png') }}" 
        alt="Logo SMK BPPI Baleendah" 
        class="h-12 w-auto object-contain"
        onerror="this.src='{{ asset('images/logo-smk-bppi.png') }}'"
    />
    <div class="flex flex-col">
        <span class="text-lg font-bold leading-tight" style="color: #0f172a;">SIMSKUL SMK BPPI Baleendah</span>
        <span class="text-xs" style="color: #64748b;">Sistem Manajemen Ekstrakurikuler</span>
    </div>
</div>