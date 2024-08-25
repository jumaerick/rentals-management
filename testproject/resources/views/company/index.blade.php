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
        <h2>Company Management</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Actions</th>
                    
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach ($companies as $company)
                <tr data-id="{{$company->id}}">
                    <td> {{$company->id}}</td>
                    <td>{{$company->name}}</td>
                    <td>
                        <div class="table-actions">
                            <form id="delete-company" action="{{ route('company.destroy') }}" method="POST" style="display: none;">
                                <input type="hidden" name="company-id" value="{{$company->id}}" id="company-id">
                                @csrf
                            </form>

                            <form id="update-company" action="{{ route('company.update') }}" method="POST" style="display: none;">
                                <input type="hidden" name="company-id" value="{{$company->id}}" id="company-id">
                                @csrf
                            </form>
                            <button class="btn btn-success btn-sm" onclick="location.href='{{ route('company.show', $company->id)}}'">Properties Listing</button>
                            <!-- <button class="btn btn-success btn-sm" onclick="location.href='{{ route('company.form') }}'"">Add</button> -->
                            <button class="btn btn-primary btn-sm" onclick="updateCompany()" value="12">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteCompany()" id='deleteBtn' value="12">Delete</button>
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
        function updateCompany(button) {
            // const row = button.closest('tr');
            // const name = row.cells[1].innerText;

            // Simple prompt to update values, you can use a more complex form if needed
            const newName = prompt('Update name:', name);


            if (newName !== '') {
                var updateRoute = "{{route('company.update')}}";
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


        function deleteCompany(button) {
            if (confirm('Are you sure you want to delete this record?')) {


                // const row = button.closest('tr');
                // row.remove();

                var deleteRoute = "{{route('company.destroy')}}";
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