@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>Thank You for registering</h1>
                    <a href="{{ route('home') }}" class="btn btn-primary">Continue</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
