@if ($errors->any())
    <x-base.alert type="danger" :message="'Some required information is missing or incomplete'" :removable="true" />
@endif

@if ($errors->any() && $showErrors)
    <div class="card card-validation-errors mb-3">
        <div class="card-header alert alert-danger mb-0 py-2">
            {{ __('Please fix the following errors:') }}
        </div>
        <div class="card-body">
            <ul class="ms-2 list-group ">
                @foreach ($errors->all() as $error)
                    <li class="p-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@foreach ($messages as $message)
    <x-base.alert :type="$message['type']" :message="$message['message']" :removable="true" />
@endforeach
