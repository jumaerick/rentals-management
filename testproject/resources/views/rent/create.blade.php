@extends('layouts.app')
@section('content')
@if (Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Create Rent</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{ route('rent.store') }}" method="post" autocomplete="off">
                    @csrf

                    <div class="form-group">

                        <label for="name"> Select Company</label>
                        <select name="company_id" id="company_id" class="form-control">

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
                        <select name="property_id" id="property_id" class="form-control">

                            <option value="" selected disabled>Select Property</option>
                            @foreach ($properties as $property)
                            <option value="{{ $property->id }}">{{ $property->name }}</option>
                            @endforeach

                        </select>
                        @if ($errors->has('property_code'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('property_code') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">

                        <label for="room_code"> Select Room</label>
                        <select name="room_id" id="room_id" class="form-control">

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
                        <label for="rent_date">Rent Date</label>
                        <input type="date" class="form-control" name="rent_date" id="rent_date"
                            value="{{ old('rent_date') }}" onclick="this.showPicker()">
                        @if ($errors->has('rent_date'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('rent_date') }}</strong>
                        </span>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="deposit">Deposit</label>
                        <input type="text" name="deposit" class="form-control" id="deposit"
                            value="{{ old('deposit') }}">
                        @if ($errors->has('deposit'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('deposit') }}</strong>
                        </span>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" class="form-control" id="amount"
                            value="{{ old('amount') }}">
                        @if ($errors->has('amount'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('amount') }}</strong>
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

@push('scripts')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
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
                                '<option value="' + property.id + '">' +
                                property.name +
                                '</option>');
                        });
                    } else {
                        $('#property_id').empty();
                    }
                }
            });
        });

        $('#property_id').change(function() {
            var property = $('#property_id').val();
            var updateRoute = "{{ route('payment.rooms', ':id') }}";
            updateRoute = updateRoute.replace(':id', property);


            $.ajax({
                url: updateRoute,
                type: "GET",
                data: {
                    'id': property,
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

        $('#room_id').change(function() {
            let room = $('#room_id').val();

            var updateRoute = "{{ route('rent.deposit', ':id') }}";
            updateRoute = updateRoute.replace(':id', room);


            $.ajax({
                url: updateRoute,
                type: "post",
                data: {
                    'id': room,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
    
                    if (data['deposit']==false) {
                        $('#deposit').val('');
                        $('#amount').val('');

                    } else {
                        $('#deposit').val(data['deposit']) ;
                        $('#amount').val(data['amount']) ;
                    }
                }
            });
        });


    });
</script>
@endpush

@endsection