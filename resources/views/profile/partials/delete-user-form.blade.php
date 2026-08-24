<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium" style="color: #0f172a;">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm" style="color: #64748b;">
            {{ __('Setelah akun Anda dihapus, semua data dan sumber daya akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi yang ingin Anda simpan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        {{ __('Hapus Akun') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium" style="color: #0f172a;">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm" style="color: #64748b;">
                {{ __('Setelah akun Anda dihapus, semua data dan sumber daya akan dihapus secara permanen. Masukkan password Anda untuk konfirmasi.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" :value="__('Password')" class="sr-only" style="color: #0f172a; font-weight: 600; font-size: 14px;" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                    placeholder="{{ __('Password') }}"
                    style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; background: #fafbfc; color: #0f172a; width: 100%;"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" style="color: #dc2626; font-size: 13px;" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<style>
    /* Focus style untuk input password di modal */
    #password:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
        background: #ffffff;
        outline: none;
    }
</style>