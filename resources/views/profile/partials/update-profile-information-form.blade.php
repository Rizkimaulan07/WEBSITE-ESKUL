<section>
    <header>
        <h2 class="text-lg font-medium" style="color: #0f172a;">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm" style="color: #64748b;">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" style="color: #0f172a; font-weight: 600; font-size: 14px;" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name"
                style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; color: #0f172a; width: 100%;"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" style="color: #dc2626; font-size: 13px;" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" style="color: #0f172a; font-weight: 600; font-size: 14px;" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username"
                style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; color: #0f172a; width: 100%;"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" style="color: #dc2626; font-size: 13px;" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-lg" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
                    <p class="text-sm" style="color: #92400e;">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out" style="color: #0ea5e9; border: none; background: none; cursor: pointer; padding: 0;">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm" style="color: #10b981;">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); box-shadow: 0 4px 16px rgba(14,165,233,0.3); border: none; padding: 12px 32px; border-radius: 12px; font-weight: 600; font-size: 14px;">
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm"
                    style="color: #10b981; font-weight: 500;"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

<style>
    /* Focus style untuk semua input di form profil */
    #name:focus,
    #email:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
        background: #ffffff;
        outline: none;
    }
</style>