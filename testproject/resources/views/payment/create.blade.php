@include('layouts.app')

@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@php

@endphp

<h1>New payment</h1>

<form action="{{ route('payment.store') }}" method="post">
    @csrf


    <div class="form-group">

        <label for="name"> Select Property</label>
        <select name="property_id" id="property_id">

            <option value="" selected disabled>Select Property</option>
            @foreach ($properties as $property)
                <option value="{{ $property->id }}">{{ $property->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('property_id'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('property_id') }}</strong>
            </span>
        @endif
    </div>


    <div class="form-group">

        <label for="room_code"> Select Room</label>
        <select name="room_id" id="room_id">

            <option value="" selected disabled>Select Room</option>
            @foreach ($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->room_code }}</option>
            @endforeach
        </select>
        @if ($errors->has('room_id'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('room_id') }}</strong>
            </span>
        @endif
    </div>


    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="text" name="amount" id="amount" value="{{ old('amount') }}">
        @if ($errors->has('amount'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('amount') }}</strong>
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

        $('#property_id').change(function() {
            var property = $('#property_id').val();
            var updateRoute = "{{ route('property.rooms', ':id') }}";
            updateRoute = updateRoute.replace(':id', property);


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
                        $('#room_id').empty();
                        $('#room_id').append(
                            '<option hidden>Select Room</option>');

                        $.each(data, function(key, room) {

                            $('select[name="room_id"]').append(
                                '<option value="' + room.id + '">' + room
                                .room_code +
                                '</option>');

                        });

                    } else {
                        $('#room_id').empty();
                    }
                }
            });
        });

    });
</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
