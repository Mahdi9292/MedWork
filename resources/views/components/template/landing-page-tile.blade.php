
@hasanyrole($permissions)
    <div class="{{ $wrapClass }}">
        <div class="card border-0 shadow">
            <div class="card-header ps-3 pe-3 pb-2 pt-2">
                <div class="row align-items-center">
                    <div class="col-10">
                        <h5 class="card-title mb-0">{{ $title }}</h5>
                    </div>
                    <div class="col-2 text-end">
                        <a href="{{ $url }}" class="btn btn-primary btn-sm float-end"><i class="fas fa-external-link-alt"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="w-100 d-sm-flex justify-content-between align-items-start">
                    <div>
                        @if($version)
                            <div class="small d-flex">
                                <div class="d-flex align-items-center me-2">
                                    <i class="fas fa-code-branch me-2"></i>
                                    <span class="text-success fw-bold">V{{ $version }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="small d-flex align-items-center">
                            <i class="fas fa-info-circle me-2" title="{{ $shortInfo }}"></i>
                            <span title="{{ $shortInfo }}">{{ $subTitle }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endhasanyrole
