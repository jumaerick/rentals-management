<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Table with Actions</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap (optional) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-actions {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>Rooms</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>House Name</th>
                    <th>Room Code</th>
                    <th>Cumulative Totals</th>
                    <th>Status</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody id="table-body">
                @foreach ($roomAssignments as $roomAssignment)


                <tr data-id="{{ $roomAssignment['id'] }}">
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
                        <div class="table-actions">
                            <form id="delete-property" action="{{ route('roomAssignment.destroy') }}" method="POST"
                                style="display: none;">
                                <input type="hidden" name="property-id" value="{{  $roomAssignment['id'] }}"
                                    id="property-id">
                                @csrf
                            </form>

                            <form id="update-property" action="{{ route('roomAssignment.update') }}" method="POST"
                                style="display: none;">
                                <input type="hidden" name="property-id" value="{{  $roomAssignment['id'] }}"
                                    id="property-id">
                                @csrf
                            </form>
                            <!-- <button class="btn btn-success btn-sm" onclick="location.href='{{ route('room.form') }}'"">Add</button> -->

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
                            <button class="btn btn-danger btn-sm" onclick="deleteproperty()" id='deleteBtn'
                                value="12">Delete</button>
                        </div>
                    </td>
                    @endforeach
                </tr>

                <!-- More rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->


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

                            }

                            else if (response.status=='updated_status'){
                                alert('Updated Status');
                            setTimeout(
                                location.reload(), 1000
                            )
                            }
                            
                            else {
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

</body>

</html>