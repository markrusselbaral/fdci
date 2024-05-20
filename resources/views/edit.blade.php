@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <a href="{{ route('home') }}" class="btn btn-info" style="margin-bottom: 10px;">Back</a>
            <div class="card">
                <div class="card-header">Contact info</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('contact.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" value="{{ $data->name }}" name="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="name">
                        </div>
                        <div class="form-group">
                            <label for="company">Company</label>
                            <input type="text" value="{{ $data->company }}" name="company" class="form-control" id="company" placeholder="company">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" value="{{ $data->phone }}" name="phone" class="form-control" id="phone" placeholder="phone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" value="{{ $data->email }}" name="email" class="form-control" id="email" placeholder="email">
                        </div>
                        <button class="btn btn-primary" style="margin-top: 10px;" id="openModal">Save Contact</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>

</script>
@endsection
