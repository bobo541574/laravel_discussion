<div class="card shadow-lg border-0 mb-2">
    <div class="form-group m-3">
        <input type="search" class="form-control" name="" id="" placeholder="search">
    </div>
    <div class="card-body">
        <h4 class="card-title font-weight-bold" data-toggle="tooltip" title="Profile"><i class="fa fa-id-card"
                style="font-size: 22px"></i> Profile</h4>
        <ul class="list-group">
            <li class="list-group-item text-center">
                @auth
                <a href="{{ route('users.profile', auth()->user()->id) }}" class="card-link">
                    <img src="{{ asset(auth()->user()->photo) }}" class="" width="60%" height="" alt="user_img">
                    <p><b class="heading">{{ auth()->user()->name}}</b></p>
                </a>
                <a href="{{ route('users.profile-edit', auth()->user()->id) }}" class="card-link text-primary"
                    data-toggle="tooltip" title="Edit"><i class="fa fa-user-edit" style="font-size: 22px"></i></a>
                @else
                <a href="" class="card-link">
                    <img src="{{ asset('/users/user.png') }}" class="" width="60%" alt="user_img">
                    <p><b class="heading">{{"User Name" }}</b></p>
                </a>
                <a href="" class="card-link text-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-user-edit"
                        style="font-size: 22px"></i>
                </a>
                @endauth
                {{-- <a href="" class="card-link text-warning" data-toggle="tooltip" title="Logout"><i class="fa fa-sign-in-alt" style="font-size: 22px"></i></a> --}}
            </li>
        </ul>
    </div>
</div>
