<div class="ajax-checkbox-wrapper">
    @if ($switch)<div class="form-check form-switch">@endif

        <input
            name="{{ $name }}"
            type="checkbox"
            id="{{ $id }}"
            class="ajax-checkbox @if ($switch) form-check-input @endif{{ $class }}"
            value="1"
            data-url="{{ $ajaxUrl }}"
            data-reload-table="{{ $reloadTable }}"
            data-success-url="{{ $successUrl }}"
            data-params="{{ $params }}"
            @if($checked) checked @endif
        />

    @if ($switch)</div>@endif

    @if(!$hideErrorIndicator)
        <i class="fa fa-exclamation-circle text-danger chk-error-indicator d-none"></i>
    @endif

    @if(!$hideLoader)
        <img class="d-none chk-loader @if ($switch) mt-1 @endif" width="16" height="16" src="{{ asset('assets/img/ajax-loader1.gif')}}" />
    @endif
</div>



