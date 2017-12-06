<header class="navbar navbar-expand-lg navbar-dark bg-purple">
    <a class="navbar-brand" href="#">
        <!--<img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="">-->
        {{ framework()->package }} v{{ framework()->version }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Detail</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">New Menu</a>
                    <a class="dropdown-item" href="#">New Page</a>
                    <a class="dropdown-item" href="#">New Redirect</a>
                    <a class="dropdown-item" href="#">New Account</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="profile-image"><img src="{{ account()->makeGravatarImage() }}" width="24" height="24" alt="profile image"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Sign out</a>
                </div>
            </li>
        </ul>
    </div>
</header>