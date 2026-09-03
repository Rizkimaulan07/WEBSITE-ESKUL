<!-- resources/views/components/application-logo.blade.php -->
<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <img 
        src="{{ asset('images/logo-simskul.png') }}" 
        alt="Logo SIMSKUL" 
        class="h-12 w-auto object-contain"
        onerror="this.src='{{ asset('images/logo-simskul.png') }}'"
    />
    <div class="flex flex-col">
        <span class="text-lg font-bold leading-tight" style="color: #0f172a;">SIMSKUL</span>
        <span class="text-xs" style="color: #64748b;">Sistem Manajemen Ekstrakurikuler</span>
    </div>
</div>