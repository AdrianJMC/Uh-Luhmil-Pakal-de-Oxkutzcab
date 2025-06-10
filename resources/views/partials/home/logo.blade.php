{{-- resources/views/partials/logo.blade.php --}}
@php
    $logoPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
@endphp

<img src="@assetAuto('storage/' . $logoPath)" alt="Logo" width="196" height="47" class="me-2">
