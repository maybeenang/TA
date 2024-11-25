<x-app-layout>
    <x-alert.flash />
    <div
        class="min-h-screen space-y-4 rounded-md border border-b-4 border-t-4 border-zinc-100 border-b-yellow-500 border-t-red-500 p-2"
    >
        <span class="flex items-center gap-1 text-sm">
            <x-icons.backpack-icon />
            Edit Profil
        </span>

        <div class="">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="max-w-xl">
                    @include("profile.partials.update-profile-information-form")
                </div>

                <div class="max-w-xl">
                    @include("profile.partials.update-password-form")
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
