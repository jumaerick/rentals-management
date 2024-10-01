@extends('layouts.app')
@section('content')

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="admin-heading">All Users</h2>
            </div>
            <div class="offset-md-6 col-md-2">
                <a class="add-new" href="{{ route('user.create') }}">Add User</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Property Code</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($properties as $property)
                        <tr>
                            <td> {{$property->id}}</td>
                            <td>{{$property->name}}</td>
                            <td>{{$property->property_code}}</td>
                            <td>{{$property->company->name}}</td>
                            <td>{{$property->location}}</td>
                            <td class="view">
                                <button data-uid='{{ $property->id }}>'
                                    class="btn btn-primary view-btn" id='btnMe'>View</button>
                            </td>
                            <td class="edit">
                                <a href="" class="btn btn-success">Edit</a>
                            </td>
                            <td class="delete">
                                <button data-uid='' class="btn btn-danger delete-student">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No User Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $properties->links('vendor/pagination/bootstrap-4') }}
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

    $(".view-btn").on("click", function() {
        var user_id = $(this).data("uid");
        var token = $('meta[name="csrf-token"]').attr('content');
        var ViewRoute = "{{route('user.show', ':id')}}"
        ViewRoute = ViewRoute.replace(':id', user_id);
        $.ajax({
            url: ViewRoute,
            data: {
                _token: token
            },
            type: "post",
            success: function(user) {
                console.log(user);
                form = "<tr><td>Username :</td><td><b>" + user['name'] + "</b></td></tr><tr><td>Email :</td><td><b>" + user['email'] + "</b></td></tr><tr><td>Location :</td><td><b>" + user['location'] + "</b></td></tr><tr><td>Phone :</td><td><b>" + user['phone_number'] + "</b></td></tr>";
                console.log(form);

                $("#modal-form table").html(form);
                $("#modal").show();
            }
        });
    });

    $('#close-btn').on("click", function() {
        $("#modal").hide();
    });

    $(".delete-student").on("click", function() {
        if (confirm('Are you sure you want to delete this record?')) {
            var u_id = $(this).data("uid");
            var token = $('meta[name="csrf-token"]').attr('content');
            var DeleteRoute = "{{route('user.destroy', ':id')}}"
            DeleteRoute = DeleteRoute.replace(':id', u_id);
            $.ajax({
                url: DeleteRoute,
                type: "POST",
                data: {
                    id: u_id,
                    _token: token
                },
                success: function(data) {
                    $(".message").html(data);
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                }
            });
        }

    });
</script>


@endsection