@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Update Property</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{ route('property.update', $property->id) }}" method="post"
                    autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Property Name</label>
                        <input type="text" class="form-control" placeholder="name" name="name"
                            value="{{ $property->name }}" required>
                        @error('name')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Property Code</label>
                        <input type="text" class="form-control" placeholder="property_code" name="property_code"
                            value="{{ $property->property_code }}" required>
                        @error('property_code')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Company</label>
                        <select name="company_id" id="company_id" class="form-control" required>
                            <option value=""selected>Select Company</option>
@foreach($companies as $company)
<option value="{{$company->id}}"{{(old('company_id', $company->id) == $cid) ? 'selected' : ''}}>{{$company->name}}</option>
@endforeach
</select>
                        @error('company')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" placeholder="location" name="location"
                            value="{{ $property->location}}" required>
                        @error('location')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <input type="submit" name="save" class="btn btn-danger" value="Update">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection