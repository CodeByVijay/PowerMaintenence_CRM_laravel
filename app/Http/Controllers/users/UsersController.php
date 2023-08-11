<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        return view('content.users.create-user');
    }
    public function createUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'password' => 'required',
            'user_type' => 'required',
            'user_status' => 'required',
        ]);
        try {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->access_type = $request->user_type;
            $user->password = Hash::make($request->password);
            $user->status = $request->user_status;
            $user->save();
            return redirect()->route('user-users-list')->with('success', 'User Successfully Created.');
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
    public function users()
    {
        return view('content.users.user-list');
    }

    public function userList(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('access_type', function ($row) {
                    $access_typeBtn = $row->access_type == 1 ? 'Admin' : 'Staff';
                    return $access_typeBtn;
                })
                ->addColumn('status', function ($row) {
                    $statusBtn = '<div class="form-check form-switch" style="padding-left: 4.5em !important;">';
                    $statusBtn .= '<input class="form-check-input" onclick="statusChange(' . $row->id . ')" type="checkbox" id="statusBtn" data-id="' . $row->id . '"';
                    $statusBtn .= $row->status == 1 ? ' checked' : '';
                    $statusBtn .= $row->id == auth()->user()->id && auth()->user()->access_type == 1 ? ' disabled' : '';
                    $statusBtn .= '>';
                    $statusBtn .= '</div>';
                    return $statusBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route("user-edit", ['id' => $row->id]) . '" class="edit btn btn-success btn-sm" title="Edit"><i class="bx bx-edit"></i></a>&nbsp;&nbsp;';
                    $actionBtn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm';
                    $actionBtn .= $row->id == auth()->user()->id && auth()->user()->access_type == 1 ? ' disabled"' : '"';
                    $actionBtn .= ' onclick="userDelete(' . $row->id . ')" title="Delete"><i class="bx bx-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['access_type', 'status', 'action'])
                ->make(true);
        }
    }

    public function userStatusChange(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $user->status = $user->status == 1 ? 0 : 1;
            $user->update();
            return response()->json(['status' => 'success', 'msg' => 'User Status Changed.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()]);
        }
    }
    public function editForm($id)
    {
        $user = User::where('id', $id)->first();
        return view('content.users.edit-user', ['user' => $user]);
    }

    public function updateUser(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $request->user_id,
        ]);
        try {
            $user = User::find($request->user_id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->access_type = isset($request->user_type) && !empty($request->user_type) ? $request->user_type : $user->access_type;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->status = isset($request->user_status) && !empty($request->user_status) ? $request->user_status : $user->status;
            $user->update();
            if (!empty($request->password)) {
                Auth::logoutCurrentDevice();
                return redirect()->route('login')->with('success', 'Your password successfully change. Please login your account using new password.');
            }
            return redirect()->route('user-users-list')->with('success', 'User Successfully Update.');
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
    public function userDelete(Request $request)
    {
        try {
            User::find($request->user_id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'User Successfully Deleted.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()]);
        }
    }

    public function ReadAllNotification(Request $request)
    {
        $encodedNotificationIds = $request->input('n_ids');
        
        $notificationIds = json_decode($encodedNotificationIds, true);
        if(!empty($notificationIds)){
          Notification::whereIn('id', $notificationIds)->update([
              'read' => 1,
          ]);
        }
        return redirect()->back();
    }

}
