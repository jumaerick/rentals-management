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
        <h2>{{$company}}  Properties</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Property Code</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Actions</th>
                    
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach ($properties as $property)
                <tr data-id="{{$property->id}}">
                    <td> {{$property->id}}</td>
                    <td>{{$property->name}}</td>
                    <td>{{$property->property_code}}</td>
                    <td>{{$property->company->name}}</td>
                    <td>{{$property->location}}</td>
                    <td>
                        <div class="table-actions">
                            <form id="delete-property" action="{{ route('property.destroy') }}" method="POST" style="display: none;">
                                <input type="hidden" name="property-id" value="{{$property->id}}" id="property-id">
                                @csrf
                            </form>

                            <form id="update-property" action="{{ route('property.update') }}" method="POST" style="display: none;">
                                <input type="hidden" name="property-id" value="{{$property->id}}" id="property-id">
                                @csrf
                            </form>
                            <!-- <button class="btn btn-success btn-sm" onclick="location.href='{{ route('property.form') }}'"">Add</button> -->
                            <button class="btn btn-success btn-sm" onclick="">Rooms Listing</button>
                            <button class="btn btn-primary btn-sm" onclick="updateproperty()" value="12">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteproperty()" id='deleteBtn' value="12">Delete</button>
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
            const newName = prompt('Update name:', name);


            if (newName !== '') {
                var updateRoute = "{{route('property.update')}}";
                var token = $('meta[name="csrf-token"]').attr('content');


                var itemId = '';

                $('tr').on('click', function() {
                    itemId = $(this).data('id');
                    $.ajax({
                        url: updateRoute,
                        method: 'post',
                        data: {
                            _token: token,
                            id: itemId,
                            newName: newName
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


        function deleteproperty(button) {
            if (confirm('Are you sure you want to delete this record?')) {


                // const row = button.closest('tr');
                // row.remove();

                var deleteRoute = "{{route('property.destroy')}}";
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