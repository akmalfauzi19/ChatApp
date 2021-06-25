<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Messages extends Component
{
    public $sender;
    public $message;
    public $allMessage;
    public $search = '';

    public function render()
    {
        $model = new User();
        if ($this->search != '') {
            $users = $model->where('name', 'like', "%" . $this->search  . "%")->get();
            $sender = $this->sender;
        } else {
            $users = $model->all();
            $sender = $this->sender;
        }
        // $this->allMessage = Message::all();
        // $this->allMessage;
        return view('livewire.messages', compact('users', 'sender'));
    }

    public function getUser($user_id)
    {
        $model = new User();
        $user = $model->find($user_id);
        $this->sender = $user;

        $this->mountData();
    }

    public function resetForm()
    {
        $this->message = '';
    }

    public function mountData()
    {
        $model = new Message;

        if (isset($this->sender->id)) {

            $this->allMessage = $model->where('user_id', Auth::user()->id)
                ->where('receiver_id', $this->sender->id)
                ->orWhere('user_id', $this->sender->id)
                ->where('receiver_id', Auth::user()->id)
                ->orderBy('id', 'desc')->get();
        }

        if (isset($this->sender->id)) {
            // for update unread messages
            $not_seen = $model->where('user_id', $this->sender->id)
                ->where('receiver_id', Auth::user()->id)->where('is_seen', false);

            $not_seen->update(['is_seen' => true]);
        }
    }

    public function SendMessage()
    {
        //
        $model = new Message();

        $model->message = $this->message;
        $model->user_id = Auth::user()->id;
        $model->receiver_id = $this->sender->id;
        $model->save();

        $this->resetForm();
    }
}
