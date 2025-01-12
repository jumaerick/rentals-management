@extends('layouts.app')
@section('content')

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="admin-heading">All Companies</h2>
            </div>
            <div class="offset-md-6 col-md-2">
                <a class="add-new" href="{{ route('company.store') }}">Add Company</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($companies as $company)
                        <tr>
                            <td> {{$company->id}}</td>
                            <td>{{$company->name}}</td>
                            <td class="view">
                                <a href="{{route('company.show', $company->id)}}" class="btn btn-primary">View Properties</a>      

                            </td>
                            <td class="edit">
                                <a href="{{route('company.edit', $company->id)}}" class="btn btn-success">Edit</a>
                            </td>
                            <td class="delete">
                                <button data-pid='{{$company->id}}' class="btn btn-danger delete-property">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No User Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $companies->links('vendor/pagination/bootstrap-4') }}
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

    $(".delete-property").on("click", function() {
        if (confirm('Are you sure you want to delete this record?')) {
            var p_id = $(this).data("pid");
            var token = $('meta[name="csrf-token"]').attr('content');
            var DeleteRoute = "{{route('property.destroy', ':id')}}"
            DeleteRoute = DeleteRoute.replace(':id', p_id);
            $.ajax({
                url: DeleteRoute,
                type: "POST",
                data: {
                    id: p_id,
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