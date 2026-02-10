@section('pageScripts')
    @parent

    <script src="{{ asset('assets/js/repeater.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $("#{{$id}}").createRepeater({
                showFirstItemToDefault: true,
            });

            // Simulate click to add new row
            let addButtons = document.querySelectorAll('.sim-add-btn');
            addButtons.forEach(addButton => {
                addButton.addEventListener('click', function (event) {
                    let clickAdd = document.querySelector('.repeater-add-btn');
                    clickAdd.click();
                });
            });
        });
    </script>
@endsection

@include('components.forms.before')
@include('components.forms.leading-addons')

<div class="card">
    @if($heading)
        <div class="card-header header-light">
            <h5 class="float-start">{{ $heading }}</h5>

            <button type="button" class="btn btn-sm btn-primary float-end sim-add-btn" title="{{ __('hinzufügen') }}">
                <i class="fas fa-plus-circle"></i>
            </button>
        </div>
    @endif
    <div class="card-body">
        @if($subHeading)
            <h5 class="card-title">{{ $subHeading }}t</h5>
        @endif

        @if($description)
            <p class="card-text">{{ $description }}</p>
        @endif

        <div id="{{$id}}" class="{{$class}}">

            @if(isset($addButton) && $addButton->isNotEmpty())
                {{ $addButton }}
            @else
                <div class="repeater-heading d-none">
                    <button type="button" class="btn btn-sm btn-primary float-end repeater-add-btn" title="{{ __('hinzufügen') }}">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            @endif
            <div class="clearfix"></div>
            <!-- Repeater Items -->
            @if(isset($existingItems) && $existingItems->isNotEmpty())
                {{ $existingItems }}

            @elseif(isset($customItems) && $customItems->isNotEmpty())
                {{ $customItems }}
            @else
                @if(isset($slot) && $slot->isNotEmpty())
                    <div class="items" data-group="{{ $name }}">
                        <!-- Repeater Item Content -->
                        <div class="item-content">
                            {{ $slot }}
                        </div>
                        <!-- Repeater Remove Btn -->

                        @if(isset($removeButton) && $removeButton->isNotEmpty())
                            {{ $removeButton }}
                        @else
                            <div class="float-end repeater-remove-btn">
                                <button type="button" class="btn btn-danger remove-btn" title="{{ __('Löschen') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                @endif

            @endif

        </div>

    </div>

    <div class="card-footer border-success p-2 footer-light">
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary sim-add-btn"><i class="fas fa-plus"></i> {{ __('hinzufügen') }}</button>
        </div>
    </div>
</div>
<!-- Repeater End -->

@include('components.forms.after')
