@extends('layouts.app')
@section('content')
@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="admin-heading">All roomAssignments</h2>
            </div>
            <div class="offset-md-6 col-md-2">
                <a class="add-new" href="{{ route('roomAssignment.form') }}">Add New</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>#</th>
                        <th>User</th>
                        <th>House Name</th>
                        <th>Room Code</th>
                        <th>Cumulative Totals</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date Approved</th>
                        <th>Change Status</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>

                        @forelse ($roomAssignments as $roomAssignment)
                        <tr data-id="{{$roomAssignment['id']}}">
                            <td> {{ $roomAssignment['id'] }}</td>
                            <td> {{ $roomAssignment['email'] }}</td>
                            <td>{{ $roomAssignment['name'] }}</td>
                            <td>{{ $roomAssignment['room_code'] }}</td>
                            <td>Ksh. {{ $roomAssignment['amount']}}</td>
                            @if($roomAssignment['status']==1)
                            <td>Active</td>

                            @elseif($roomAssignment['status']==2)
                            <td>Pending</td>

                            @else

                            <td>Inactive</td>
                            @endif
                            <td>
                            {{$roomAssignment['payment_status']}}
                            </td>
                            <td>
                            @if($roomAssignment['status'] =='1')
                            {{$roomAssignment['updated_at']}}
                            @endif
                            </td>

                            <td>
                                @if($roomAssignment['status'] =='1')
                                <button class="btn btn-primary btn-sm" onclick="updateproperty()"
                                    value="12">Change Status</button>

                                @elseif($roomAssignment['status'] =='2')
                                <button class="btn btn-primary btn-sm" onclick="updateproperty()"
                                    value="12">Change Status</button>
                                @else
                                <button class="btn btn-primary btn-sm" onclick="updateproperty()"
                                    value="12">Change Status</button>
                                @endif
                            </td>
                            <td class="view">
                                <button data-rid='{{ $roomAssignment->id }}>'
                                    class="btn btn-primary view-btn" id='btnMe'>View</button>
                            </td>
                            <td class="edit">
                                <a href="{{route('roomAssignment.edit', $roomAssignment->id)}}" class="btn btn-success">Edit</a>
                            </td>
                            <td class="delete">
                                <button data-ra='{{$roomAssignment->id}}' class="btn btn-danger delete-roomAssignment">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No roomAssignments Listed</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>


                <div id="modal">
                    <div id="modal-form">
                        <table cellpadding="10px" width="100%">

                        </table>
                        <div id="close-btn">X</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript">
    // $('#btnMe').on('click', function() {
    //     alert('yes');
    // })

    $(".delete-roomAssignment").on("click", function() {
        if (confirm('Are you sure you want to delete this record?')) {

            var r_id = $(this).data("ra");
            var token = $('meta[name="csrf-token"]').attr('content');
            var DeleteRoute = "{{route('roomAssignment.destroy', ':id')}}"
            DeleteRoute = DeleteRoute.replace(':id', r_id);
            $.ajax({
                url: DeleteRoute,
                type: "POST",
                data: {
                    id: r_id,
                    _token:token
                },
                success: function(response) {

                    if (response.status == true) {
                        alert('deleted successfully');
                        setTimeout(
                            location.reload(), 1000
                        )

                    } else {
                        alert('Something went wrong');
                        setTimeout(
                            location.reload(), 1000
                        )
                    }
                    }
            });
        }

        });

    $(".delete-rent").on("click", function() {
        if (confirm('Are you sure you want to delete this record?')) {

            var r_id = $(this).data("rid");
            var token = $('meta[name="csrf-token"]').attr('content');
            var DeleteRoute = "{{route('rent.destroy', ':id')}}"
            DeleteRoute = DeleteRoute.replace(':id', r_id);
            $.ajax({
                url: DeleteRoute,
                type: "POST",
                data: {
                    id: r_id,
                    _token:token
                },
                success: function(response) {

                    if (response.status == true) {
                        alert('deleted successfully');
                        setTimeout(
                            location.reload(), 1000
                        )

                    } else {
                        alert('Something went wrong');
                        setTimeout(
                            location.reload(), 1000
                        )
                    }
                    }
            });
        }

        });

</script>

<script>


    function updateproperty(button) {
        // const row = button.closest('tr');
        // const name = row.cells[1].innerText;

        // Simple prompt to update values, you can use a more complex form if needed
        if (confirm('Are you sure you want to approve this request?')) {

            var updateRoute = "{{ route('roomAssignment.changeStatus') }}";
            var token = $('meta[name="csrf-token"]').attr('content');


            var itemId = '';

            $('tr').on('click', function() {
                itemId = $(this).data('id');
                $.ajax({
                    url: updateRoute,
                    method: 'post',
                    data: {
                        _token: token,
                        id: itemId
                    },
                    success: function(response) {

                        if (response.status == true) {
                            alert('approved');
                            setTimeout(
                                location.reload(), 1000
                            )

                        } else if (response.status == 'updated_status') {
                            alert('Updated Status');
                            setTimeout(
                                location.reload(), 1000
                            )
                        } else {
                            alert('Something went wrong');
                            setTimeout(
                                location.reload(), 1000
                            )
                        }
                    }
                });

            });

        }

    }


    function deleteproperty(button) {
        if (confirm('Are you sure you want to delete this record?')) {


            // const row = button.closest('tr');
            // row.remove();

            var deleteRoute = "{{ route('property.destroy') }}";
            var token = $('meta[name="csrf-token"]').attr('content');

            var itemId = '';

            $('tr').on('click', function() {
                itemId = $(this).data('id');

                $.ajax({
                    url: deleteRoute,
                    method: 'post',
                    data: {
                        _token: token,
                        id: itemId
                    },
                    success: function() {

                        setTimeout(
                            location.reload(), 100
                        )
                    }
                });

            });




        }
    }
</script>

@endsection