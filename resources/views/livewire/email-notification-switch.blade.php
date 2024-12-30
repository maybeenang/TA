<div class="flex items-center space-x-4 rounded-md border p-4">
    <div class="flex-1 space-y-1">
        <p class="text-sm font-medium leading-none">Notifikasi Email</p>
        <p class="text-sm text-muted-foreground">
            Aktifkan notifikasi email untuk mendapatkan notifikasi terkait laporan di email anda
        </p>
    </div>
    <x-switch wire:model.live="notificationEmail" />
</div>
