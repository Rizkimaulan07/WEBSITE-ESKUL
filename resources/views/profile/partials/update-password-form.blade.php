<section>
    <header>
        <h2 class="text-lg font-medium" style="color: #0f172a;">
            {{ __('Perbarui Password') }}
        </h2>

        <p class="mt-1 text-sm" style="color: #64748b;">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" style="color: #0f172a; font-weight: 600; font-size: 14px;" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" 
                autocomplete="current-password"
                style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; color: #0f172a; width: 100%;"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" style="color: #dc2626; font-size: 13px;" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Password Baru')" style="color: #0f172a; font-weight: 600; font-size: 14px;" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" 
                autocomplete="new-password"
                style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; color: #0f172a; width: 100%;"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" style="color: #dc2626; font-size: 13px;" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" style="color: #0f172a; font-weight: 600; font-size: 14px;" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" 
                autocomplete="new-password"
                style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; color: #0f172a; width: 100%;"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" style="color: #dc2626; font-size: 13px;" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); box-shadow: 0 4px 16px rgba(14,165,233,0.3); border: none; padding: 12px 32px; border-radius: 12px; font-weight: 600; font-size: 14px;">
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
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
    /* Focus style untuk semua input di form password */
    #update_password_current_password:focus,
    #update_password_password:focus,
    #update_password_password_confirmation:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
        background: #ffffff;
        outline: none;
    }
</style>