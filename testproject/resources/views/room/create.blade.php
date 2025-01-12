@extends('layouts.app')
@section('content')
@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Create Room</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{route('room.store')}}" method="post"
                    autocomplete="off">
                    @csrf

                    <div class="form-group">

                        <label for="name"> Select Company</label>
                        <select name="company_id" id="company_id" class="form-control" required>
                            <option value="" selected disabled>Select Company</option>
                            @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('company_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('company_id') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">

                        <label for="name"> Select Property</label>
                        <select name="property_id" id="property_id" class="form-control" required>
                            <option value="" selected disabled>Select Property</option>
                            @foreach ($properties as $property)
                            <option value="{{ $property->property_id }}">{{ $property->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('property_code'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('property_code') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="room_code">Room Code</label>
                        <input type="text" name="room_code" id="room_code" value="{{ old('room_code') }}" class="form-control">
                        @if ($errors->has('room_code'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('room_code') }}</strong>
                        </span>
                        @endif

                    </div>


                    <div class="form-group">
                        <input type="submit" name="save" class="btn btn-danger" value="Create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#company_id').change(function() {
            var company = $('#company_id').val();
            var updateRoute = "{{ route('company.properties', ':id') }}";
            updateRoute = updateRoute.replace(':id', company);


            $.ajax({
                url: updateRoute,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        console.log(data);
                        $('#property_id').empty();
                        $('#property_id').append(
                            '<option hidden>Select Property</option>');

                        $.each(data, function(key, property) {
                            $('select[name="property_id"]').append(
                                '<option value="' + property.id + '">' + property.name +
                                '</option>');
                        });
                    } else {
                        $('#property_id').empty();
                    }
                }
            });
        });
    });
</script>

@endsection