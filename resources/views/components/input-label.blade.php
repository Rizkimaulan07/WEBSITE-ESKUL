@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm', 'style' => 'color: #0f172a;']) }}>
    {{ $value ?? $slot }}
</label>