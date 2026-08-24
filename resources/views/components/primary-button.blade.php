<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150', 'style' => 'background: linear-gradient(135deg, #0ea5e9, #38bdf8); box-shadow: 0 4px 16px rgba(14,165,233,0.3);']) }}>
    {{ $slot }}
</button>