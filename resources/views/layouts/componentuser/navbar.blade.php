<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/user" class="nav-link">Home</a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{-- <form action="/logout" method="post">
            @csrf
            @method('POST') --}}
        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modal-logout">
            LogOut
        </button>
        {{-- </form> --}}
    </ul>
</nav>

@include('pages.auth.logout-confirmasi')
