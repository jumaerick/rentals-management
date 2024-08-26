@include('layouts.app')

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<h1>Add Company</h1>

<form action="{{ route('company.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Company Names</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
            @if ($errors->has('name'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
</div>

<div class="form-group">
            <button class="btn-success">Create</button>
        </div>
</form>
