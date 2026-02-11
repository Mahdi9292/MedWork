@props(['sidebar' => false])

<div {{ $attributes->merge(['class' => 'd-flex align-items-center gap-2 text-decoration-none text-dark']) }}>
    <div
        class="d-flex align-items-center justify-content-center rounded bg-primary text-white"
        style="width: 32px; height: 32px;"
    >
        <x-app-logo-icon style="width: 20px; height: 20px;" />
    </div>
    <span class="fw-bold">{{ __('Laravel Starter Kit') }}</span>
</div>
