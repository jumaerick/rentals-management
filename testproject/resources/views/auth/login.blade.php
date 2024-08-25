@include('layouts.app')


{{-- @if ($errors->any())

<ul>
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ul>
@endif --}}

<div class="container">
    <div class="row justify-content-center">
    <h2>
        Login Section
    </h2>

    <form action="{{ route('user.login') }}" method="post">
        @csrf

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

        <!-- <div class="form-group">
            <label for="remember">
            <input type="checkbox" name="remember" id="remember" class="form-control">
<span class="">Remember Me</span>
            </label>
            @if ($errors->has('remember'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('remember') }}</strong>
                </span>
            @endif
        </div> -->


        <div class="form-group">
            <button class="btn-success">Login</button>
        </div>
    </form>
    </div>
    </div>
</div>

