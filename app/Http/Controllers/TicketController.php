<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TicketCreateRequest;
use App\Ticket;
use Hash;
use File;
use App\Image;
use App\Ticket_image;
use App\Ticket_relater;
use Auth;
use App\User;
use App\Ticket_read;
use Mail;
use DB;
use Carbon\Carbon;

class TicketController extends Controller
{
    /*
    * Get view create request
    */
    public function getCreate(){
        $users = DB::table('users') -> select('id', 'username') -> get();
        return view('request.create', ['users' => $users]);
    }
    /*
    *Post create Request
    */
    public function postCreate(TicketCreateRequest $request) {
        $ticket = new Ticket();
        $ticket -> subject = htmlspecialchars($request -> input('txtName'));
        $ticket -> content = $request -> input('txtContent');
        $ticket -> create_by = Auth::user() -> id;
        $ticket -> status = 1;
        $ticket -> priority = $request -> input('doUuTien');
        $ticket -> deadline = $request -> input('txtDate');
        $ticket -> rating = null;
        $team_select = $request -> input('boPhanIT');
        $ticket -> team_id = $team_select;
        $leader = User::select('id', 'username', 'email')->where([['level',0],['team_id',$team_select]])->first();
        $ticket -> assigned_to = $leader->id;
        $ticket -> resolved_at = null;
        $ticket -> closed_at = null;
        $ticket -> deleted_at = null;
        $ticket -> save();
        if ($request -> hasFile('image')) {
            $img = $request -> file('image');
            $img_name = $img -> getClientOriginalName();
            $ticket_image = new Ticket_image();
            $ticket_image -> ticket_id = $ticket -> id;
            $ticket_image -> url_image = asset('resources/upload/'.$img_name);
            $des = "resources/upload/";
            $img -> move($des, $img_name);
            $ticket_image -> save();
        }
        if($request -> has('select')) {
            $userselect=$request->get('select');
            for($i = 0; $i < sizeof($userselect); $i++) {
                $ticket_relater = new Ticket_relater();
                $ticket_relater -> ticket_id = $ticket -> id;
                $ticket_relater -> employee_id = $userselect[$i];
                $ticket_relater -> save();
            }
        }

        $users = DB::table('users') -> select('id') -> get()->toArray();
        for($i = 0; $i < sizeof($users); $i++){
            $ticket_read = new Ticket_read();
            $ticket_read->ticket_id = $ticket->id;
            $ticket_read->reader_id = $users[$i]->id;
            $ticket_read->status = 0;
            $ticket_read->save();
        }
        $nlq = $request->get('select');
        $nlq1 = array();
        for($i = 0; $i < sizeof($nlq); $i++) {
                $name = User::select('id', 'username')->where('id', $nlq[$i])->first();
                $nlq1[$i] = $name -> username;
        }
        $data = ['subject' => $request -> input('txtName'), 'content' => $request -> input('txtContent'), 'create_by' => Auth::user() -> username, 'deadline' => $request -> input('txtDate'), 'priority' => $request -> input('doUuTien'), 'team_id' => $request -> input('boPhanIT'), 'ass' => $leader -> username, 'nlq1' => $nlq1];
        Mail::send('request.email.sendCreateTicket', $data, function($msg) use($leader){
            $msg -> from('thangtr97@gmail.com', 'Thông báo của spec_it');
            $msg -> to($leader -> email, $leader -> username) -> subject('Thông báo của spec_it');
        });
        return redirect() -> route('create.getRequest')->with('message','Bạn đã tạo yêu cầu thành công');
    }
    /*
    *Get view List request
    */
    public function getListRequest($big, $small) {
        global $sm;
        if ($big == 'relater') {
            if ($small == 'all') {
                $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status')->join('ticket_relaters','tickets.id','=','ticket_relaters.ticket_id')->where('ticket_relaters.employee_id',Auth::id())->orderBy('id', 'DESC')->get();
            }
            else {
                if($small == 'new') {
                    $sm=1;
                }
                else if($small == 'inprogress') {
                    $sm=2;
                }
                else if($small == 'resolved') {
                    $sm=3;
                }
                else if($small == 'outofdate') {
                    $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> join('ticket_relaters','tickets.id','ticket_relaters.ticket_id')->where([['deadline','<',date('Y-m-d').' 00:00:00'],['ticket_relaters.employee_id', Auth::user() -> id],['status','<>',5]]) -> get() -> toArray();
                }
                if ($small != 'outofdate') {
                    $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status')->join('ticket_relaters','tickets.id','=','ticket_relaters.ticket_id')->where([['ticket_relaters.employee_id',Auth::id()],['status',$sm]])->orderBy('id', 'DESC')->get();
                }
            }
        }
        else if ($big == 'team_id') {
            if ($small == 'all') {
                $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> where($big, Auth::user() -> team_id) -> orderBy('id', 'DESC')-> get() -> toArray();
            }
            else {
                if ($small == 'new'){
                    $sm = 1;
                }
                else if ($small == 'inprogress'){
                    $sm = 2;
                }
                else if ($small == 'resolved'){
                    $sm = 3;
                }
                else if ($small == 'feedback'){
                    $sm = 4; 
                }
                else if($small == 'closed') {
                    $sm=5;
                }
                else if ($small = 'outofdate') {
                    $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> where([['deadline','<',date('Y-m-d').' 00:00:00'],[$big, Auth::user() -> team_id],['status','<>',5]]) -> get() -> toArray();
                }
                if ($small != 'outofdate') {
                    $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> where([[$big, Auth::user() -> team_id], ['status',$sm]])  -> orderBy('id', 'DESC') -> get() -> toArray();
                }
            }
        }
        else {
             if ($small == 'all') {
                $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status') -> where($big, Auth::user() -> id) -> orderBy('id', 'DESC')-> get() -> toArray();
            }
            else {
                if($small == 'new'){
                    $sm = 1;
                }
                else if($small == 'inprogress'){
                    $sm = 2;
                }
                else if($small == 'resolved'){
                    $sm = 3;
                }
                else if($small == 'outofdate'){
                    $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> where([['deadline','<',date('Y-m-d').' 00:00:00'],[$big, Auth::user() -> id],['status','<>',5]]) -> get() -> toArray();
                }
                if ($small != 'outofdate') {
                    $ticket = Ticket::select('id','subject','priority','create_by','assigned_to','deadline','status') -> where([[$big, Auth::user() -> id], ['status',$sm]])  -> orderBy('id', 'DESC') -> get() -> toArray();
                }
            }
        }
        return view('request.list_request',compact('ticket','big','small'));
    }
   
}
