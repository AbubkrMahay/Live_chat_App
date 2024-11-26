<!DOCTYPE html>
<html>

<head>
    
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <div class="main" id="head">
            <nav class="navbar navbar-expand px-4 py-3">
                <form action="#" class="d-none d-sm-inline-block">

                </form>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0 dropdown-toggle">
                                <img src="/account.png" class="avatar img-fluid" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded">
                                <div class="user-info">
                                    Name: {{$user->name}}</br><hr>
                                    <a href="{{route('logout')}}">
                                        <button>Logout</button>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
    </div>
</body>

</html>