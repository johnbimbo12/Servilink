<?php

namespace App\Http\Controllers;

use App\Models\Messaging;
use App\Models\MsgMedia;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class MessagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 2) {
            $all = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->count();
            $resolved = Messaging::where('manager_user_id', $user->id)->where('status', 2)->where('parent_id', null)->count();
            $pending = Messaging::where('manager_user_id', $user->id)->where('status', 0)->where('parent_id', null)->count();
            $process = Messaging::where('manager_user_id', $user->id)->where('status', 1)->where('parent_id', null)->count();
            $read = Messaging::where('manager_user_id', $user->id)->where('isread', 1)->where('parent_id', null)->count();
            $unread = Messaging::where('manager_user_id', $user->id)->where('isread', 0)->where('parent_id', null)->count();
            $msgstat = ['all' => $all, 'resolved' => $resolved, 'pending' => $pending, 'process' => $process, 'unread' => $unread, 'read' => $read];

            return view('manager.message', compact('user', 'msgstat'));
        } else if ($user->role == 4) {

            $all = Messaging::where('user_id', $user->id)->where('parent_id', null)->count();
            $resolved = Messaging::where('user_id', $user->id)->where('status', 2)->where('parent_id', null)->count();
            $pending = Messaging::where('user_id', $user->id)->where('status', 0)->where('parent_id', null)->count();
            $process = Messaging::where('user_id', $user->id)->where('status', 1)->where('parent_id', null)->count();
            $read = Messaging::where('user_id', $user->id)->where('isread', 1)->where('parent_id', null)->count();
            $unread = Messaging::where('user_id', $user->id)->where('isread', 0)->where('parent_id', null)->count();
            $msgstat = ['all' => $all, 'resolved' => $resolved, 'pending' => $pending, 'process' => $process, 'unread' => $unread, 'read' => $read];

            return view('resident.message', compact('user', 'msgstat'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMessages(Request $request)
    {
        $filter = $request->filter; //0 all, 1 resolved, 2 pending, 3process, 4 read 5 unrread
        $user = Auth::user();
        if ($filter == 0) {
            $message = Messaging::where('user_id', $user->id)->where('parent_id', null)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 1) {
            $message = Messaging::where('user_id', $user->id)->where('parent_id', null)->where('parent_id', null)->where('status', 2)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 2) {
            $message = Messaging::where('user_id', $user->id)->where('parent_id', null)->where('status', 0)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 3) {
            $message = Messaging::where('user_id', $user->id)->where('parent_id', null)->where('status', 1)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 4) {
            $message = Messaging::where('user_id', $user->id)->where('parent_id', null)->where('isread', 1)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 5) {
            $message = Messaging::where('user_id', $user->id)->where('parent_id', null)->where('isread', 0)->orderBy('id', 'desc')->paginate(15);
        }
        foreach ($message as $key => $value) {
            # code...
            $childmsg = Messaging::where('parent_id', $value->id)->orderBy('id', 'desc')->first();
            $value->sender = User::where('id', $value->sender_id)->value('name');
            if ($childmsg) {
                $value->request = $childmsg->request;
                $value->created_at = $childmsg->created_at;
            }
        }

        if (count($message) > 0) {
            if ($request->ajax()) {
                $view = view('theme.msg_item', compact('message'))->render();
                return response()->json(['status' => 'ok', 'html' => $view, 'paginate' => $message]);
            }
        } else {
            return response()->json(['status' => 'info']);
        }

    }

    public function loadMessages(Request $request)
    {
        $filter = $request->filter; //0 all, 1 resolved, 2 pending, 3process, 4 read 5 unrread
        $user = Auth::user();
        if ($filter == 0) {
            $message = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 1) {
            $message = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->where('parent_id', null)->where('status', 2)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 2) {
            $message = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->where('status', 0)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 3) {
            $message = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->where('status', 1)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 4) {
            $message = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->where('isread', 1)->orderBy('id', 'desc')->paginate(15);
        } else if ($filter == 5) {
            $message = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->where('isread', 0)->orderBy('id', 'desc')->paginate(15);
        }
        foreach ($message as $key => $value) {
            # code...
            $childmsg = Messaging::where('parent_id', $value->id)->orderBy('id', 'desc')->first();

            $value->sender = User::where('id', $value->sender_id)->value('name');
            if ($childmsg) {
                $value->request = $childmsg->request;
                $value->created_at = $childmsg->created_at;
            }
        }

        if (count($message) > 0) {
            if ($request->ajax()) {
                $view = view('theme.msg_item', compact('message'))->render();
                return response()->json(['status' => 'ok', 'html' => $view, 'paginate' => $message]);
            }
        } else {
            return response()->json(['status' => 'info']);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $message = new Messaging();
        if ($request->type == "reply") {
            $message->parent_id = $request->parentid;
            $pmsg = Messaging::where('id', $request->parentid)->orWhere('parent_id', $request->parentid)->get();
            if ($user->role == 2) {
                foreach ($pmsg as $key => $value) {
                    $value->status = $request->status;
                    $value->update();
                }

            }
            $message->category = $pmsg[0]->category;
            $message->title = $pmsg[0]->title;
        } else {
            $message->category = $request->category;
            $message->title = $request->title;
        }
        $message->request = $request->message;
        $message->user_id = $user->id;
        $message->sender_id = $user->id;
        if ($user->role == 2) {
            $message->status = $request->status;
            $message->manager_user_id = $user->id;

        } else {
            $message->manager_user_id = $user->estateuser->manager_user_id;
        }
        $message->save();
        try {
            if ($request->hasfile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move( storage_path('app/public/')  . 'attachments/', $name);
                    $imgData[] = $name;
                }

                $attachment = new MsgMedia();
                $attachment->messaging_id = $message->id;
                $attachment->path = json_encode($imgData);
                $attachment->save();
            }
        } catch (\Throwable $th) {
            \Log::alert($th);
            return back()->with('error', 'Error occur file not attached!');
        }

        return back()->with('success', 'Request sent successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messaging  $messaging
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Messaging::where('id', $id)->orWhere('parent_id', $id)->orderBy('id', 'desc')->get();

        foreach ($message as $key => $value) {
            # code...
            $value->isread = 1;
            $value->update();
            $sender = User::where('id', $value->sender_id)->first();
            if ($sender->role == 2) {
                $sender_name = "Manager";
            } else {
                $sender_name = $sender->name;
            }
            $value->sender = $sender_name;
        }
        // dd(json_decode($message->attachment->path));
        $user = Auth::user();
        if ($user->role == 2) {

            $all = Messaging::where('manager_user_id', $user->id)->where('parent_id', null)->count();
            $resolved = Messaging::where('manager_user_id', $user->id)->where('status', 2)->where('parent_id', null)->count();
            $pending = Messaging::where('manager_user_id', $user->id)->where('status', 0)->where('parent_id', null)->count();
            $process = Messaging::where('manager_user_id', $user->id)->where('status', 1)->where('parent_id', null)->count();
            $read = Messaging::where('manager_user_id', $user->id)->where('isread', 1)->where('parent_id', null)->count();
            $unread = Messaging::where('manager_user_id', $user->id)->where('isread', 0)->where('parent_id', null)->count();
            $msgstat = ['all' => $all, 'resolved' => $resolved, 'pending' => $pending, 'process' => $process, 'unread' => $unread, 'read' => $read];
            return view('manager.message_details', compact('message', 'user', 'msgstat'));

        } else if ($user->role == 4) {

            $all = Messaging::where('user_id', $user->id)->where('parent_id', null)->count();
            $resolved = Messaging::where('user_id', $user->id)->where('status', 2)->where('parent_id', null)->count();
            $pending = Messaging::where('user_id', $user->id)->where('status', 0)->where('parent_id', null)->count();
            $process = Messaging::where('user_id', $user->id)->where('status', 1)->where('parent_id', null)->count();
            $read = Messaging::where('user_id', $user->id)->where('isread', 1)->where('parent_id', null)->count();
            $unread = Messaging::where('user_id', $user->id)->where('isread', 0)->where('parent_id', null)->count();
            $msgstat = ['all' => $all, 'resolved' => $resolved, 'pending' => $pending, 'process' => $process, 'unread' => $unread, 'read' => $read];
            return view('resident.message_details', compact('message', 'user', 'msgstat'));

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messaging  $messaging
     * @return \Illuminate\Http\Response
     */
    public function edit(Messaging $messaging)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Messaging  $messaging
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // try {
        //code...
        $ids = $request->ids;
        Messaging::whereIn('id', explode(",", $ids))->orWhereIn('parent_id', explode(",", $ids))->delete();
        return response()->json(['success' => "Selected Request Deleted successfully."]);
        // } catch (\Throwable $th) {
        //      return response()->json(['error' => "Error occur."]);
        //     //throw $th;
        // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messaging  $messaging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messaging $messaging)
    {
        //
    }
}