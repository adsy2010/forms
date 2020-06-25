<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 17/04/2019
 * Time: 4:23 PM
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Sends a message to a user
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        if(!$request->isMethod('post'))
            return redirect()->back()->withErrors('An attempt to access the create session method was made incorrectly.');

        $validation = Validator::make($request->all(), [
            'userID' => 'required|exists:users,id',
            'subject' => 'required|max:128',
            'message' => 'required'
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput($request->all())
                ->send();
        }

        $message = new Message();
        $message->fill($request->all());
        $message->read = 0;
        $message->save();
        return redirect()->back()->with('success', 'Message sent');
    }

    /**
     * Display paginated messages for current user
     *
     */
    public function messageList()
    {
        $messages = Auth::user()->messages()->paginate(15);
        if (Route::current()->getName() == 'api.messages.list')
        {
            return response()->json(["status" => "OK", "data" => ["messages" => $messages]], 200);
        }
        return view('user.messages', ['messages' => $messages]);
    }

    /**
     * Open a message and set read state to read
     *
     * @param Request $request
     * @param Message $id
     * @return Factory|JsonResponse|View
     */
    public function messageDetails(Request $request, Message $id)
    {
        $id->read = 1;
        $id->save();
        if (Route::current()->getName() == 'api.messages.details')
        {
            return response()->json(["status" => "OK", "data" => ["message" => $id]], 200);
        }
        return view('user.messageDetails', ['message' => $id]);
    }
}