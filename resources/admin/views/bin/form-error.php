@if (count($errors) > 0)
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger alert-alt">
                <strong><i class="fa fa-pencil"></i> Form Field Errors</strong><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <br/>
@endif