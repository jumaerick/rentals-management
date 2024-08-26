@include('layouts.app')

@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@php
    
@endphp

<h1>Add Room</h1>

<form action="{{ route('room.store') }}" method="post">
    @csrf

    <div class="form-group">

        <label for="name"> Select Company</label>
        <select name="company_id" id="company_id">

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
        <select name="property_code" id="property_code">

            <option value="" selected disabled>Select Property</option>
            @foreach ($properties as $property)
                <option value="{{ $property->property_code }}">{{ $property->name }}</option>
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
        <button class="btn-success">Create</button>
    </div>
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
                        $('#property_code').empty();
                        $('#property_code').append(
                            '<option hidden>Select Property</option>');

                        $.each(data, function(key, property) {
                            $('select[name="property_code"]').append(
                                '<option value="' + property.property_code + '">' + property.name +
                                '</option>');
                        });
                    } else {
                        $('#property_code').empty();
                    }
                }
            });
        });
    });
</script>
