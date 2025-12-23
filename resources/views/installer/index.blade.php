@extends('installer.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">{{ $pageTitle }}</h3>
                </div>
                <div class="card-body">
                    @if (count($errors))
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endif
                    @if (Route::is('install.index'))
                        <form action="{{ route('install.set.db') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="db_name">Database Name</label>
                                <input type="text" class="form-control" id="db_name" name="db_name" value="{{ env('DB_DATABASE') }}" placeholder="Enter database name">
                            </div>
                            <div class="form-group">
                                <label for="db_username">Username</label>
                                <input type="text" class="form-control" id="db_username" name="db_username" value="{{ env('DB_USERNAME') }}" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="db_password">Password</label>
                                <input type="password" class="form-control" id="db_password" name="db_password" value="{{ env('DB_PASSWORD') }}" placeholder="Enter password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    @endif
                    @if (Route::is('install.billing'))
                        <form action="{{ route('install.set.billing') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="set_api_key">Set API Key</label>
                                <input type="text" class="form-control" id="set_api_key" name="set_api_key" placeholder="Set API Key">
                            </div>
                            <div class="form-group">
                                <label for="set_invoice_id">Set Invoice ID</label>
                                <input type="text" class="form-control" id="set_invoice_id" name="set_invoice_id" placeholder="Set Invoice ID">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
