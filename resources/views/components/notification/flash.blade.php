@if (session()->has('success'))
    <div class="alert alert-primary alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            {{ session('message') }}
        </div>
    </div>
@elseif(session()->has('error'))
    <div class="alert alert-danger alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            {{ session('message') }}
        </div>
    </div>
@endif
