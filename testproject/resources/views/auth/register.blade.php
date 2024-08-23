@include('layouts.app')


{{-- @if ($errors->any())

<ul>
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ul>
@endif --}}

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<div class="container">
    <div class="row justify-content-center">
    <h2>
        Kindly Create Your Account
    </h2>

    <form action="{{ route('user.create') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Full Names</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
            @if ($errors->has('name'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
            @if ($errors->has('email'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="Password">Password</label>
            <input type="Password" name="password" id="password" class="form-control">
            @if ($errors->has('password'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="Password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        @if ($errors->has('password_confirmation'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif

        <div class="form-group">
            <button class="btn-success">Register</button>
        </div>
    </form>
    </div>
    </div>
</div>

