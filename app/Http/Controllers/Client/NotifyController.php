<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function showTimeNotify()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        return view('client.time-notify', compact('notifications'));
    }

    public function setNotify(Request $request)
    {
        $request->validate([
            'notify_time' => 'required|date_format:H:i',
        ]);

        $user = Auth::user();

        $exitTimeNotify = Notification::where('id_user', $user->id)
            ->where('notification_time', $request->input('notify_time'))
            ->first();

        if ($exitTimeNotify) {
            toastr()->error('Giờ nhận thông báo đã tồn tại!');

            return redirect()->back();
        } else {
            Notification::create([
                'id_user' => $user->id,
                'notification_time' => $request->input('notify_time'),
            ]);

            toastr()->success('Đặt giờ thông báo thành công!');

            return redirect()->back();
        }
    }

    public function deleteNotify($id)
    {
        $notify = Notification::find($id);
        $notify->delete();

        toastr()->success('Xóa giờ thông báo thành công!');

        return redirect()->back();
    }
}
