<?php

namespace App\Http\Controllers;

use App\Escalations;
use App\escallation;
use App\Notification;
use App\quotation_approval;
use App\role_permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class NotificationController extends Controller
{

    public function check_role_permission()
    {
        $get_role_id = auth()->user()->role_id;
        $noti_create_inquiry = role_permission::where('role_id', $get_role_id)->where('menu_id', 103)->first();
        $noti_create_quotation = role_permission::where('role_id', $get_role_id)->where('menu_id', 103)->first();
        if ($noti_create_inquiry) {
            $noti_array[] = 'self_inquiry';
        } elseif ($noti_create_quotation) {
            $noti_array[] = "create_quotation";
        } elseif ($noti_create_quotation) {
            $noti_array[] = "send_quotation_to_approval";
        } elseif ($noti_create_quotation) {
            $noti_array[] = "inquiry_remarks";
        } elseif ($noti_create_quotation) {
            $noti_array[] = "quotation_remarks";
        } else {
            $noti_array = [];
        }
        return  $noti_array;
    }
    // View All Notifications Start
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->user()->id)->get();
        return view('/notifications.index', compact('notifications'));
    }

    public function team_index()
    {
        $notifications = Notification::where('department_id', '!=', null)->get();
        //        dd($notifications);
        return view('/notifications.team_index', compact('notifications'));
    }
    public function escalation_index()
    {
        $esc = Notification::latest()->limit(500)->where('type', 'escalation')->get();
        //        dd($esc);

        return view('/notifications.escalation_index', compact('esc'));
    }
    public function issuance_index()
    {
        // $issuance = role_permission::latest()->where('is_read', 0)->get();
        $issuance = role_permission::where('role_id', auth()->user()->role_id)->get();

        //        dd($esc);

        return view('/notifications.issuance_index', compact('issuance'));
    }
    public function approval_index()
    {
        // $approvals = escallation::latest()->where('is_read', 0)->get();
        $approvals = Notification::latest()->where('user_id', auth()->user()->id)->where('type', "quotation_approval")->get();

        //        dd($esc);

        return view('/notifications.approvals_index', compact('approvals'));
    }
    // View All Notifications End
    public function get_notifications_my_jobs()
    {

        $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('user_id', auth()->user()->id)->where('type', "self_inquiry")->get();
        foreach ($noti as $not) {

            echo $not = '<a  href="' . url('/my_jobs') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
        }
    }
    public function get_noti_count_my_jobs($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "self_inquiry")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function notification_read_my_jobs($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Notification Read Successfully");
        return redirect()->back();
    }

    // General Notifications
    public function get_notifications_general()
    {

        $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('user_id', auth()->user()->id)->where('type', 'general')->get();
        foreach ($noti as $not) {

            echo $not = '<a  href="' . url('/followups') . '"><div class="media">
             <div class="az-img-user"><img  src="' . url('/img/notification_icon.png') . '" style="height:40px;width:40px;" alt=""></div>
             <div class="media-body">
                 <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                 <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
             </div>
         </div>';
        }
    }
    public function get_noti_count_general($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "general")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function notification_read_general($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Notification Read Successfully");
        return redirect()->back();
    }
    // Payment Notification
    public function get_notifications_payments()
    {


        $get_role_permission = role_permission::where('role_id', auth()->user()->role_id)->where('menu_id', 115)->first();
        if ($get_role_permission) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = null;
        }

        $noti = Notification::where('is_read', 0)->where('user_id', $user_id)->where('type', "Payments")->get();
        // dd($user_id);
        foreach ($noti as $not) {

            echo $not = '<a  href="' . url('/payment_invoice_list') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
        }
    }

    public function get_noti_count_payments($count = null)
    {
        $get_role_permission = role_permission::where('role_id', auth()->user()->role_id)->where('menu_id', 115)->first();
        if ($get_role_permission) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = null;
        }

        $noti = Notification::where('is_read', 0)->where('user_id', $user_id)->where('type', "Payments")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function notification_read_payments($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Notification Read Successfully");
        return redirect()->back();
    }

    //Team Notifications
    public function get_notifications_team()
    {
        $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('user_id', auth()->user()->id)->where('type', "team_inquiry")->get();
        foreach ($noti as $not) {

            echo $not = '<a  href="' . url('/my_jobs') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon_team.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_team' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
        }
    }
    public function get_noti_count_team($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "team_inquiry")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function notification_read_team($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success',"Notification Read Successfully");
        return redirect()->back();
    }

    //Escalations Notifications
    public function get_escalations()
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->limit(5)->where('type', "escalation")->get();

        foreach ($noti as $esc_not) {
            echo $not = '<a  href="' . url('/my_jobs') . '"><div class="media">
                <div class="az-img-user"><img  src="' . url('/img/notification_icon_team.png') . '" style="height:40px;width:40px;" alt=""></div>
                <div class="media-body">
                    <p><strong>'.$esc_not->message.'</strong></p></a>
                    <span>' . $esc_not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($esc_not->id)) . '">Mark as read</a></span>
                </div>
            </div>';
        }
    }
    public function get_escalations_count($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "escalation")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function escalations_read($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Escalation Read Successfully");
        return redirect()->back();
    }

    // get_approvals Notification
    public function get_approvals()
    {

        $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('user_id', auth()->user()->id)->where('type', "quotation_approval")->get();
        foreach ($noti as $not) {
            echo $not = '<a  href="' . url('/quotation_approvals') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
        }
    }
    public function get_approvals_count($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "quotation_approval")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }

    public function get_approvals_read($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->where('user_id', auth()->user()->id)->whereIn('type', "team_inquiry")->get()->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Escalation Read Successfully");
        return redirect()->back();
    }

    public function get_issuance()
    {

        $get_permission = role_permission::where('role_id', auth()->user()->role_id)->whereIn("menu_id", [109, 110, 111, 112])->first();
        if ($get_permission) {
            $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('type', "quotation_issuance")->where('user_id',auth()->user()->id)->get();
            foreach ($noti as $not) {
                echo $not = '<a  href="' . url('/quotation_approvals') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
            }
        }
    }
    public function get_issuance_count($count = null)
    {
        $get_permission = role_permission::where('role_id', auth()->user()->role_id)->whereIn("menu_id", [109, 110, 111, 112])->first();
        if ($get_permission) {
            $noti = Notification::latest()->where('is_read', 0)->where('type', "quotation_issuance")->where('user_id',auth()->user()->id)->get()->count();
            $active = 0;
            if ($noti > $count) {
                $active = 1;
            }
            return response()->json([
                'count' => $noti,
                'is_new' => $active,
            ]);
        }
    }

    public function get_issuance_read($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Escalation Read Successfully");
        return redirect()->back();
    }
}
