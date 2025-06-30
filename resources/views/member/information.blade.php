@section('jumbotron')
<div class="jumbotron bg-none">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="display-4">Activate Instant Blog</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container pt-5 pb-4">
    <div class="row">
        <div class="col-md-9">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/siteinstant') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="mb-3">
                    <label for="p_code">Enter Random Value:</label>
                    <input id="p_code" type="text" class="form-control" name="p_code" required autofocus>
                    <small id="p-codeHelp" class="form-text text-muted">Example : DoniaWeB</small>
                </div>
                <div class="mb-3">                    
                    <button type="submit" class="btn btn-primary btnpoint">
                        Activate
                    </button>
                </div>
                <div class="mb-3">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                    NULLED by <a style="color:red;" href="https://doniaweb.com" target="_blank">Licensed By DoniaWeB</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection