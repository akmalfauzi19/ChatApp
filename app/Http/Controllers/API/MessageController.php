<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function allMessages(Request $request)
    {
        //
        $model = new User();

        $user_id = $request->input('id');
        $receiver_id = $request->input('receiver_id');

        //get Message use filter id

        if ($user_id && $receiver_id) {
            $data = $model->join('messages', function ($query) use ($user_id, $receiver_id) {
                $query->on('users.id', '=', 'messages.user_id')
                    ->where('messages.user_id', $user_id)
                    ->Where('messages.receiver_id', $receiver_id)
                    ->orWhere('messages.user_id', $receiver_id)
                    ->Where('messages.receiver_id', $user_id);
            })->get();
            if ($data) {
                return ResponseFormatter::success($data, 'successfully get message data');
            } else {
                return ResponseFormatter::error(null, 'Message data not found', 404);
            }
        } else {
            $data = $model->with('messages')->get();
            if ($data) {
                return ResponseFormatter::success($data, 'successfully get message data');
            } else {
                return ResponseFormatter::error(null, 'Message data not found', 404);
            }
        }
    }

    public function sendMessage(Request $request)
    {

        $model = new Message();

        $rules = array(
            'user_id' => 'required',
            'message' => 'required',
            'receiver_id' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Send Message Failed', 404);
        }

        $message = $model->create([
            'user_id' => $request->user_id,
            // 'user_id' => auth('api')->user()->id,
            'message' => $request->message,
            'receiver_id' => $request->receiver_id
        ]);

        if ($message) {
            return ResponseFormatter::success($message, 'Successfully sent message');
        } else {
            return ResponseFormatter::error(null, 'Send Message Failed', 404);
        }
    }
}
