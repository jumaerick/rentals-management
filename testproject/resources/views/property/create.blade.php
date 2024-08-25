@include('layouts.app')

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<h1>Add Property</h1>

<form action="{{ route('property.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Property Names</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
        @if ($errors->has('name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif

    </div>

    <div class="form-group">
        <label for="name">Property Code</label>
        <input type="text" name="property_code" id="property_code" value="{{ old('property_code') }}" class="form-control">
        @if ($errors->has('property_code'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('property_code') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">

        <label for="name"> Select Company</label>
        <select name="company_id" id="company_id">

            <option value="" selected disabled>Select Company</option>
            @foreach ($companies as $company)
            <option value="{{$company->id}}">{{$company->name}}</option>
            @endforeach
        </select>
        @if ($errors->has('company_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('company_id') }}</strong>
        </span>
        @endif
    </div>

<div class="form-group">
<label for="name">Property Location</label>
        <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-control">
        @if ($errors->has('location'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('location') }}</strong>
        </span>
        @endif
</div>

    <div class="form-group">
        <button class="btn-success">Create</button>
    </div>
</form>