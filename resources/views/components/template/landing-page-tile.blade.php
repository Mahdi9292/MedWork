@hasanyrole($permissions)
{{-- The col class comes from the parent, h-100 ensures the column fills row height --}}
<div class="{{ $wrapClass }} h-100">
    <div class="card border-0 shadow h-100">
        <div class="card-header ps-3 pe-3 pb-2 pt-2">
            <div class="row align-items-center">
                <div class="col-10">
                    <h5 class="card-title mb-0">{{ $title }}</h5>
                </div>
                <div class="col-2 text-end">
                    <a href="{{ $url }}" class="btn btn-primary btn-sm"><i class="fas fa-external-link-alt"></i></a>
                </div>
            </div>
        </div>

        <div class="card-body d-flex flex-column">
            @if($version)
                <div class="small mb-2">
                    <i class="fas fa-code-branch me-2"></i>
                    <span class="text-success fw-bold">V{{ $version }}</span>
                </div>
            @endif
            <div class="small d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1"></i>
                <span title="{{ $shortInfo }}">{{ $subTitle }}</span>
            </div>
        </div>
    </div>
</div>
@endhasanyrole
