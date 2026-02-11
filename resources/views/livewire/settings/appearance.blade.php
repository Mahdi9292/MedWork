<section class="w-full">
    @include('sections.default.head')

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <div class="btn-group mt-4" role="group" aria-label="Appearance toggle">
            <input type="radio" class="btn-check" name="appearance" id="light_mode" value="light" x-model="$flux.appearance">
            <label class="btn btn-outline-primary" for="light_mode">
                <i class="bi bi-sun me-1"></i> {{ __('Light') }}
            </label>

            <input type="radio" class="btn-check" name="appearance" id="dark_mode" value="dark" x-model="$flux.appearance">
            <label class="btn btn-outline-primary" for="dark_mode">
                <i class="bi bi-moon me-1"></i> {{ __('Dark') }}
            </label>

            <input type="radio" class="btn-check" name="appearance" id="system_mode" value="system" x-model="$flux.appearance">
            <label class="btn btn-outline-primary" for="system_mode">
                <i class="bi bi-display me-1"></i> {{ __('System') }}
            </label>
        </div>
    </x-settings.layout>
</section>
