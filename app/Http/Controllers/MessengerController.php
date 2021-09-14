<?php

namespace App\Http\Controllers;

use App\Models\ChatConvo;
use App\Models\Group;
use App\Models\GroupParticipant;
use App\Models\User;
use App\Models\User\BlockedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class MessengerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        return view('messenger.home');
    }

    public function conversation($id, $name)
    {

        $conversation = User::where('id', $id)->first();
        return view('messenger.conversation', compact('id', 'name', 'conversation'));
    }

    public function send_message(Request $request, $id)
    {

        $count_conversation = ChatConvo::where('sender_id', Auth::user()->id)->where('reciever_id', $id)->orwhere('sender_id', $id)->orwhere('reciever_id', Auth::user()->id)->count();
        if ($count_conversation == 0) {
            if ($request->hasFile('files')) {

                $attechment  = $request->file('files');

                $img_2 =  rand(0, 8) . $attechment->getClientOriginalName();
                $attechment->move(public_path('message_media'), $img_2);

                $image_name = explode('.', $img_2);
                $extention = end($image_name);
                $extention = Str::lower($extention);

                if ($extention == "png") {

                    $type = 'image';
                } elseif ($extention == "jpg") {
                    $type = 'image';
                } elseif ($extention == "mp4") {
                    $type = 'video';
                } elseif ($extention == "jpeg") {
                    $type = 'image';
                } else {

                    $type = "document";
                }
            }
            $create_chat = new ChatConvo();
            $create_chat->sender_id = Auth::user()->id;
            $create_chat->reciever_id = $id;
            $create_chat->message = $request->message;
            $create_chat->file = $type ?? '';
            $create_chat->save();
            $contact = User::where('id', $id)->first();

            $this->send_message_to_user(['id' => $id, 'file_type' => $type ?? '', 'link' => '/Conversation/' . $id . '/' . $contact->name . ' ', 'message' => $request->message, 'files' => $img_2 ?? '']);
        } else {

            if ($request->hasFile('files')) {

                $attechment  = $request->file('files');

                $img_2 =  time() . $attechment->getClientOriginalName();
                $attechment->move(public_path('message_media'), $img_2);

                $image_name = explode('.', $img_2);
                $extention = end($image_name);
                $extention = Str::lower($extention);

                if ($extention == "png") {

                    $type = 'image';
                } elseif ($extention == "jpg") {
                    $type = 'image';
                } elseif ($extention == "mp4") {
                    $type = 'video';
                } elseif ($extention == "jpeg") {
                    $type = 'image';
                } else {

                    $type = "document";
                }
            }

            ChatConvo::where('sender_id', Auth::user()->id)->where('reciever_id', $id)->orwhere('sender_id', $id)->orwhere('reciever_id', Auth::user()->id)->update(array(
                'sender_id' => Auth::user()->id,
                'reciever_id' => $id,
                'file' => $type ?? '',
                'message' => $request->message,

            ));
            $contact = User::where('id', $id)->first();

            $this->send_message_to_user(['id' => $id, 'file_type' => $type ?? '', 'link' => '/Conversation/' . $id . '/' . $contact->name . ' ', 'message' => $request->message, 'files' => $img_2 ?? '']);
        }
    }

    public function block($id)
    {

        $block = new BlockedUser;
        $block->user_id = Auth::user()->id;
        $block->blocked_id = $id;
        $block->save();

        $contact = User::where('id', $id)->first();

        $this->block_user(['id' => $id, 'req_fro' => 'unblock']);
        return redirect()->back();
    }

    public function unblock($id)
    {


        BlockedUser::where('user_id', Auth::user()->id)->where('blocked_id', $id)->delete();

        $contact = User::where('id', $id)->first();

        $this->block_user(['id' => $id, 'req_fro' => 'unblock']);

        return redirect()->back();
    }


    public function create_group(Request $request)
    {

        $groups = new Group();

        if ($request->hasFile('files')) {
            $attechment  = $request->file('files');
            $img_2 =  rand(0, 8) . $attechment->getClientOriginalName();
            $attechment->move(public_path('group_thumb'), $img_2);
        }
        $groups->group_name = $request->group_name;
        $groups->group_thumb = $img_2;
        $groups->group_privacy = $request->group_privacy;
        $groups->group_host = Auth::user()->id;
        $groups->save();

        $group_members = new GroupParticipant();
        $group_members->group_id = $groups->id;
        $group_members->participant_id = Auth::user()->id;
        $group_members->save();
        return response()->json([$groups->id]);
    }

    public function add_member(Request $request, $id)
    {
        $group_members = new GroupParticipant;
        $group_members->group_id = $request->group_id;
        $group_members->participant_id = $id;
        $group_members->save();
    }

    public function group($id, $name)
    {

        $group_details = Group::where('id', $id)->first();
        $count_members = GroupParticipant::where('group_id', $id)->count();
        $member = GroupParticipant::where('group_id', $id)->get();
        return view('messenger.group', compact('id', 'name', 'group_details', 'count_members', 'member'));
    }

    public function leave_group()
    {

        GroupParticipant::where('participant_id', Auth::user()->id)->delete();
        return redirect('/Inbox');
    }

    public function make_host($member_id, $id)
    {
        Group::where('id', $id)->update(array(
            'group_host' => $member_id
        ));

        return redirect()->back();
    }

    public function kick_out($member_id, $id)
    {

        GroupParticipant::where('participant_id', $member_id)->where('group_id', $id)->delete();
        $this->block_user(['id' => $member_id, 'req_fro' => 'kick_out']);

        return redirect()->back();
    }


    public function send_message_to_group(Request $request, $id)
    {

        $group_details = Group::where('id', $id)->first();

        if ($request->hasFile('files')) {

            $attechment  = $request->file('files');

            $img_2 =  rand(0, 8) . $attechment->getClientOriginalName();
            $attechment->move(public_path('message_media'), $img_2);

            $image_name = explode('.', $img_2);
            $extention = end($image_name);
            $extention = Str::lower($extention);

            if ($extention == "png") {

                $type = 'image';
            } elseif ($extention == "jpg") {
                $type = 'image';
            } elseif ($extention == "mp4") {
                $type = 'video';
            } elseif ($extention == "jpeg") {
                $type = 'image';
            } else {

                $type = "document";
            }
        }
        Group::where('id', $id)->update(array(
            'group_last_message' => $request->message,
            'last_msg_nam' => $request->last_msg_from,
        ));
        $this->send_group_message(['group_id' => $id, 'group_name' => $group_details->group_name, 'message' => $request->message, 'file_type' => $type ?? '', 'link' => '/Group/' . $id . '/' . str_replace(" ", "-", $group_details->name) . ' ', 'files' => $img_2 ?? '']);
    }
}
