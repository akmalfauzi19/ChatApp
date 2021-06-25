    <div class="container">
        <div class="row justify-content-center">
            @php
                $model = new App\Models\Message();
            @endphp
            {{-- START USER FORM --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Users
                    </div>
                    <form method="get">
                        <input class="border-solid border border-gray-300 p-2 w-full col-md-12" type="text"
                            placeholder="Search Users" wire:model="search" />
                    </form>
                    @if ($search == '')
                        <div class="card-body chatbox p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($users as $user)
                                    @if ($user->id != Auth::user()->id)
                                        @php
                                            
                                            $not_seen =
                                                $model
                                                    ->where('user_id', $user->id)
                                                    ->where('receiver_id', Auth::user()->id)
                                                    ->where('is_seen', false)
                                                    ->get() ?? null;
                                            $last_message = $model
                                                ->where('user_id', $user->id)
                                                ->where('receiver_id', Auth::user()->id)
                                                ->orderBy('created_at', 'desc')
                                                ->first();
                                        @endphp
                                        <a wire:click="getUser({{ $user->id }})" class="text-dark link active">
                                            <li class="list-group-item">
                                                <img src="https://img.icons8.com/bubbles/2x/user-male.png"
                                                    class="img-fluid avatar" alt="image-user">
                                                @if ($user->is_online == true)
                                                    <i class="fas fa-circle text-success online-icon"></i>
                                                @endif
                                                <strong>{{ $user->name }}</strong>
                                                @if (filled($not_seen))
                                                    <div class="badge badge-success rounded">
                                                        {{ $not_seen->count() }}
                                                    </div>
                                                @endif
                                                <br>
                                                @if (filled($last_message))
                                                    <small class="last-message">{{ $last_message->message }}</small>
                                                @else
                                                    <br>
                                                @endif
                                            </li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @else
                        @if ($users->isEmpty())
                            <div class="card-body chatbox p-0">
                                <p style="text-align: center;">No matching result was found.</p>
                            </div>
                        @else
                            <div class="card-body chatbox p-0">
                                <ul class="list-group list-group-flush">
                                    @foreach ($users as $user)
                                        @if ($user->id != Auth::user()->id)
                                            @php
                                                $not_seen =
                                                    $model
                                                        ->where('user_id', $user->id)
                                                        ->where('receiver_id', Auth::user()->id)
                                                        ->where('is_seen', false)
                                                        ->get() ?? null;
                                                $last_message = $model
                                                    ->where('user_id', $user->id)
                                                    ->where('receiver_id', Auth::user()->id)
                                                    ->orderBy('created_at', 'desc')
                                                    ->first();
                                                // dd($last_message->message);
                                            @endphp
                                            <a wire:click="getUser({{ $user->id }})" class="text-dark link active">
                                                <li class="list-group-item">
                                                    <img src="https://img.icons8.com/bubbles/2x/user-male.png"
                                                        class="img-fluid avatar" alt="image-user">
                                                    @if ($user->is_online == true)
                                                        <i class="fas fa-circle text-success online-icon"></i>
                                                    @endif
                                                    <strong>{{ $user->name }}</strong>
                                                    @if (filled($not_seen))
                                                        <div class="badge badge-success rounded">
                                                            {{ $not_seen->count() }}
                                                        </div>
                                                    @endif
                                                    <br>
                                                    @if (filled($last_message))
                                                        <small
                                                            class="last-message">{{ $last_message->message }}</small>
                                                    @endif
                                                </li>
                                            </a>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    @endif


                </div>
            </div>
            {{-- START USER FORM --}}

            {{-- START MESSAGE FORM --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if (isset($sender))
                            {{ $sender->name }}
                        @endif
                    </div>
                    <div class="card-body message-box" wire:poll="mountData">
                        {{-- <div class="card-body message-box"> --}}
                        {{-- @if ($allMessage) --}}
                        @if (filled($allMessage))
                            @foreach ($allMessage as $mgs)
                                <div class="single-message
                                    {{ $mgs->user_id == Auth::user()->id ? 'sent' : 'received' }}">
                                    <p class="font-weight-bolder my-0">{{ $mgs->user->name }}</p>
                                    {{ $mgs->message }}
                                    <br>
                                    <i class="{{ $mgs->is_seen == 1 ? 'fas fa-check-double' : 'fas fa-check' }}"></i>
                                    <small
                                        class="text-muted w-100">{{ $mgs->user_id == Auth::user()->id ? 'Sent' : 'Received' }}
                                        <em>{{ $mgs->created_at }}</em></small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card-footer">
                        <form wire:submit.prevent="SendMessage">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" wire:model="message" class="form-control
                                input shadow-none w-100 d-inline-block" placeholder="Type a Message" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">
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
