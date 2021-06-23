<div>
    <div class="row justify-content-center">

        {{-- START USER FORM --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Users
                </div>
                <div class="card-body chatbox p-0">
                    <ul class="list-group list-group-flush">
                        @foreach ($users as $user)
                            <a wire:click="getUser({{ $user->id }})" href="" class="text-dark link">
                                <li class="list-group-item">
                                    <img src="https://img.icons8.com/bubbles/2x/user-male.png" class="img-fluid avatar"
                                        alt="">
                                    <i class="fas fa-circle text-success online-icon"></i>
                                    {{ $user->name }}
                                    <div class="badge badge-success rounded">30</div>
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- START USER FORM --}}

        {{-- START MESSAGE FORM --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Hafizh
                </div>
                {{-- <div class="card-body message-box" wire:poll="mountdata"> --}}
                <div class="card-body message-box">
                    <div class="single-message">
                        <p class="font-weight-bolder my-0">Name</p>
                        Message
                        <br>
                        <small class="text-muted w-100">Sent <em>41-1-2021</em></small>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" wire:model="message" class="form-control
                                input shadow-none w-100 d-inline-block" placeholder="Type a Message" required>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- END MESSAGE FORM --}}
    </div>
</div>
