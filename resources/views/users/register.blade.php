@include("layouts.app")

<form id="registrationForm" name="registrationForm" action="{{route('user.create')}}" method="post">
    @csrf

    <p>Kindly fill in your information below.</p>
    <div class="form-group">
        <label for="name">Full Names *</label>
        <input type="text" class="form-control" id="name" name='name' aria-describedby="name" placeholder="Full name" required>
    </div>

    <div class="form-group">
        <label for="email">Email address *</label>
        <input type="email" class="form-control" id="email" name='email' aria-describedby="emailHelp" placeholder="Enter email" required>
    </div>
    <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" class="form-control" id="password" name='password' placeholder="Password" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<style>
    #registrationForm {
        width: 30em;
        margin-right: auto;
        margin-left: auto;
    }
</style>