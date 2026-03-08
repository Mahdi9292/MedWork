@env('staging')
    <div class="alert alert-danger p-0 text-center" role="alert" style="color: white; background-color: red">
        TEST SERVER
    </div>
@endenv

@env('local')
    <div class="alert alert-danger p-0 text-center" role="alert" style="color: white; background-color: cadetblue">
        DEVELOPMENT SERVER
    </div>
@endenv

@stack('info_bar')
