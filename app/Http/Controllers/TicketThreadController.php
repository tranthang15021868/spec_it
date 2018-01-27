<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket_thread;
use Auth;
use App\User;
use App\Ticket;
use App\Ticket_relater;
use Mail;
class TicketThreadController extends Controller
{
    /*
    * get Info of request
    */
    public function getInfoEditRequest($id) {
        $ticketThread = Ticket_thread::all() -> where('ticket_id', $id);
        $ticket= Ticket::all() -> where('id', $id)->first();
        $relater = User::select('id','username')->join('ticket_relaters','ticket_relaters.employee_id','=','users.id')->where('ticket_relaters.ticket_id',$id)->get();
        $user=User::all();
        $createBy = User::findOrFail($ticket -> create_by);
        $assignedTo = User::findOrFail($ticket -> assigned_to);
        $leader_hn = User::select('id', 'email', 'username')->where([['level',0],['team_id',1]])->first();
        $leader_dn = User::select('id', 'email', 'username')->where([['level',0],['team_id',2]])->first();
        if(!empty($ticketThread)) {
            return view('request.info',compact('id', 'ticketThread','user', 'ticket', 'createBy', 'assignedTo', 'relater','leader_hn','leader_dn'));
        }
        else {
            return view('request.info',compact('id','user', 'ticket','relater', 'createBy', 'assignedTo','leader_hn','leader_dn'));
        }
    }
    /*
    * ajax post Comment
    */
    public function postCmt1(Request $request) {
        if ($request -> ajax()) {
            
            $cmt=$request->cmt;
            $rid=$request->rid;
            $choose = $request->choose;
            if (!empty($cmt) && $choose != 5) {
              echo "<div class='col-md-12'><div class='row'>
                        <div class='col-sm-12'>
                            <div class='panel panel-white post'>
                                <div class='post-heading'>
                                    <div class='pull-left image'>
                                        <img src='http://localhost:8080/spec_it/public/image/avatar.png' class='img-circle avatar' alt='user profile image'>
                                    </div>
                                    <div class='pull-left meta'>
                                        <div class='title h5'>
                                            <b>".Auth::user()->username."</b>
                                        </div>
                                        <h6 class='text-muted time'>A few seconds ago</h6>
                                    </div>
                                </div> 
                                <div class='post-description'> 
                                    <p>$cmt</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            // add new ticket thead
            $ticketThread = new Ticket_thread();
            $ticketThread->ticket_id = $rid;
            $ticketThread->employee_id = Auth::user() -> id;
            if ($choose != 5) {
                $ticketThread->content = $cmt;
            }
           
            if($choose == 4){
                $ticketThread->type=0;
                $ticket= Ticket::find($rid);
                $ticket->status=4;
                $ticket->save();

            }
            else if($choose == 5){
                $ticketThread->type=1;
                $choose1 = $request -> choose1;
                if ($choose1 == 0) {
                    $c = 'Không hài lòng';
                }
                else if ($choose1 == 1) {
                    $c = 'Hài lòng';
                }
                echo "<div class='col-md-12'><div class='row'>
                        <div class='col-sm-12'>
                            <div class='panel panel-white post'>
                                <div class='post-heading'>
                                    <div class='pull-left image'>
                                        <img src='http://localhost:8080/spec_it/public/image/avatar.png' class='img-circle avatar' alt='user profile image'>
                                    </div>
                                    <div class='pull-left meta'>
                                        <div class='title h5'>
                                            <b>".Auth::user()->username."</b>
                                        </div>
                                        <h6 class='text-muted time'>A few seconds ago</h6>
                                    </div>
                                </div> 
                                <div class='post-description'>
                                    <p>$c</p>
                                    <p>$cmt</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
                $ticketThread->content = '<p>'.$c.'</p><p>'.$cmt.'</p>';

                $ticket= Ticket::find($rid);
                if ($choose1 != "") {
                    $ticket -> rating = $choose1;
                }
                $ticket->status=5;
                $ticket->save();
            }
            else  $ticketThread->type=0;
            $ticketThread->note="a";
            $ticketThread->save();
        }
    }

    public function postCmt2(Request $request){
       if($request->ajax()){
            echo "";

        }
    }
    public function postCmt3(Request $request){
       if($request->ajax()){
            $choose = $request->choose;
            if($choose == 4) {
                echo "Feedback";
            }
            else if ($choose == 5){
                echo "Closed";
                $ticket = Ticket::findOrFail($request -> id);
                $ticket -> closed_at = date('Y-m-d').' 00:00:00';
                $ticket -> save();
            }
            $email = $request -> email;
            $subject = $request -> subject;
            $status = $request -> status;
            // gửi Mail cho người thực hiện khi thay đổi trạng thái
            // $data = ['subject' => $subject, 'choose' => $choose, 'status' => $status];
            // Mail::send('request.email.changeTT', $data, function($msg) use($email){
            //     $msg -> from('thangtr97@gmail.com', 'Thông báo của spec_it || Thay đổi trạng thái công việc');
            //     $msg -> to($email, 'hi') -> subject('Thông báo của spec_it || Thay đổi trạng thái công việc');
            // });
        }
    }
    public function postCmt4(Request $request){
       if($request->ajax()){
            $t_team_id = $request -> t_team_id; //2
            $u_team_id = $request -> u_team_id; //1
            $level = $request -> level;//0
            $cre = $request -> cre;
            $u_id = $request -> u_id;
            if(($level == 0 && $u_team_id == 2)  || ($level == 0 && $u_team_id == 1 && $t_team_id == 1) || ($level == 1 && $u_team_id == 2 && $t_team_id == 2)){
                echo '<button type="button" class="btn"><span class="glyphicon glyphicon-record "></span>Thay đổi bộ phận IT</button>  <button type="button" class="btn"><span class="glyphicon glyphicon-edit "></span>Thay đổi mức độ ưu tiên</button>  <button type="button" class="btn"><span class="glyphicon glyphicon-calendar"></span>Thay đổi deadline</button>  <button type="button" class="btn"><span class="glyphicon glyphicon-hand-right "></span>Asign</button>  <button type="button" class="btn"><span class="glyphicon glyphicon-user "></span>Thay đổi người liên quan</button>';
            }
            else if($u_id == $cre){
                echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-record "></span>Thay đổi bộ phận IT</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-edit "></span>Thay đổi mức độ ưu tiên</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-calendar"></span>Thay đổi deadline</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-hand-right "></span>Asign</button>  <button type="button" class="btn"><span class="glyphicon glyphicon-user "></span>Thay đổi người liên quan</button>';
            }
            else{
                echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-record "></span>Thay đổi bộ phận IT</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-edit "></span>Thay đổi mức độ ưu tiên</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-calendar"></span>Thay đổi deadline</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-hand-right "></span>Asign</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-user "></span>Thay đổi người liên quan</button>';
            }
        }
    }
    /*
    * ajax post change bộ phận IT -> assign
    */
    public function postChangeBP1(Request $request){
       if($request->ajax()){
            $rid=$request->rid;
            $choose = $request ->choose;
            $user=User::where('team_id',$choose)->get();
            foreach($user as $us){
                if ($choose == 1 && $us -> level != 1) {
                    echo "<option value='".$us->id."'>".$us->username."</option>";
                }
                else if ($choose == 2) {
                    echo "<option value='".$us->id."'>".$us->username."</option>";
                }
            }//end of the loop
            //update ticket
            $ticket= Ticket::find($rid);
            $ticket->team_id=$choose;
            $ticket->save();

        }
    }
    public function postChangeBP2(Request $request){
       if($request->ajax()){
          
            $choose = $request -> choose;
            $subject = $request -> subject;
            $team_id = $request -> team_id;
            $leader = $request -> leader;
                       
            $leader = User::select('id', 'username', 'email','team_id') -> where('id', $leader) -> first();
            $new_team_id  = $leader -> team_id;
            // gửi mail cho leader của bộ phận it
            // $data = ['subject' => $subject, 'new_team_id' => $new_team_id];
            // Mail::send('request.email.changeBPIT', $data, function($msg) use($leader){
            //     $msg -> from('thangtr97@gmail.com', 'Thông báo của spec_it || Thay đổi Bộ phận It của công việc');
            //     $msg -> to($leader -> email, $leader -> username) -> subject('Thông báo của spec_it || Thay đổi Bộ phận It của công việc');
            // });
            if($choose == 1) {
                echo "IT Hà Nội";
            }
            else if($choose == 2) {
                echo "IT Đà Nẵng";
            }
        }
    }
    public function postChangeBP3(Request $request){
       if($request->ajax()){
            $rid = $request->rid;
            $choose = $request ->choose;
            $user= User::select('id','username','team_id','level')-> where([['team_id', $choose],['level',0]])->first();
            echo $user->username;
            // update ticket
            $ticket= Ticket::find($rid);
            $ticket->assigned_to = $user->id;
            $ticket->save();

        }
    }
    public function postChangeBP4(Request $request){
       if($request->ajax()){
            echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-record "></span>Thay đổi bộ phận IT</button>';
        }
    }
    public function postChangeBP5(Request $request){
       if($request->ajax()){
            echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-edit "></span>Thay đổi mức độ ưu tiên</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-calendar"></span>Thay đổi deadline</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-hand-right "></span>Asign</button>';
        }
    }
    public function postChangeBP6(Request $request){
       if($request->ajax()){
            echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-user "></span>Thay đổi người liên quan</button>';
        }
    }
    public function postChangeBP7(Request $request){
       if($request->ajax()){
            echo '<button type="button" class="btn" disabled = "disabled"><span class="glyphicon glyphicon-transfer"></span>Thay đổi trạng thái</button>';
        }
    }
    /*
    * ajax post change độ ưu tiên
    */
     public function postChangeUT1(Request $request){
       if($request->ajax()){
            $rid = $request ->rid;
            $choose = $request ->choose;
            if($choose == 1) 
                echo'Thấp';
            else if($choose== 2)
                echo 'Bình thường';
            else if($choose== 3)
                echo 'Cao';
            else 
                echo'Khẩn cấp';
            //update ticket
            $ticket= Ticket::find($rid);
            $ticket->priority=$choose;
            $ticket->save();
            $subject = $request->subject;
            $priority = $request->priority;
            $ass = $request->ass;
            $assigned_to = User::findOrFail($ass);
            $cmt = $request->cmt;
            // $data = ['subject' => $subject, 'priority'=>$priority,'choose'=>$choose,'cmt'=>$cmt];
            // Mail::send('request.email.changePriority', $data, function($msg) use($subject, $assigned_to){
            //     $msg -> from('thangtr97@gmail.com', 'Thông báo của spec_it || Thay đổi độ ưu tiên của công việc');
            //     $msg -> to($assigned_to -> email, $assigned_to -> username) -> subject('Thông báo của spec_it');
            // });

        }
    }
    /*
    * ajax post change độ ưu tiên required comment
    */
    public function postChangeUT2(Request $request) {
        if ($request -> ajax()) {
            
            $cmt=$request->cmt;
            $rid=$request->rid;
            $old_choose = $request ->old_choose;

            $choose =$request->choose;
            if($choose == 1) 
                $choose = 'Thấp';
            else if($choose== 2)
                $choose = 'Bình thường';
            else if($choose== 3)
                $choose = 'Cao';
            else if($choose == 4)
                $choose ='Khẩn cấp';
            if($old_choose == 1) 
                $old_choose = 'Thấp';
            else if($old_choose== 2)
                $old_choose = 'Bình thường';
            else if($old_choose== 3)
                $old_choose = 'Cao';
            else if($old_choose == 4)
                $old_choose ='Khẩn cấp';
            if (!empty($cmt)) {
              echo "<div class='col-md-12'><div class='row'>
                        <div class='col-sm-12'>
                            <div class='panel panel-white post'>
                                <div class='post-heading'>
                                    <div class='pull-left image'>
                                        <img src='http://localhost:8080/spec_it/public/image/avatar.png' class='img-circle avatar' alt='user profile image'>
                                    </div>
                                    <div class='pull-left meta'>
                                        <div class='title h5'>
                                            <b>".Auth::user()->username."</b>
                                        </div>
                                        <h6 class='text-muted time'>A few seconds ago</h6>
                                    </div>
                                </div> 
                                <div class='post-description'> 
                                    <p>Thay đổi mức độ ưu tiên : $old_choose => $choose</p>
                                    <p>$cmt</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            // update ticket thread
            $ticketThread = new Ticket_thread();
            $ticketThread->ticket_id = $rid;
            $ticketThread->employee_id = Auth::user() -> id;
            $ticketThread->content = '<p>Thay đổi mức độ ưu tiên : '.$old_choose.' => '.$choose.'</p>
                                    <p>'.$cmt.'</p>';
            $ticketThread->type=2;
            $ticketThread->note="a";
            $ticketThread->save();

        }
    }
    /*
    * ajax post change người thực hiện and send mail
    */
     public function postChangeAS(Request $request){
        if($request->ajax()){
            $rid = $request ->rid;
            $choose = $request ->choose;

            $assigned_to = $request -> assigned_to;
            $assignedTo = User::findOrFail($assigned_to);

            $assignedToNew = User::findOrFail($choose);
            $subject = $request -> subject;

            echo $assignedToNew->username;
            // update ticket
            $ticket= Ticket::find($rid);
            $ticket->assigned_to=$choose;
            $ticket->save();
            //sendMail
            // $data = ['subject' => $subject, 'assignedToNew' => $assignedToNew -> username, 'assignedTo' => $assignedTo -> username];
            // Mail::send('request.email.changeAssign', $data, function($msg) use($subject, $assignedToNew){
            //     $msg -> from('thangtr97@gmail.com', 'Hi');
            //     $msg -> to($assignedToNew -> email, $assignedToNew -> username) -> subject('Thông báo của spec_it');
            // });
            // //Gửi mail cho người thực hiện cũ
            // $data1 = ['subject' => $subject, 'assignedToNew' => $assignedToNew -> username, 'assignedTo' => $assignedTo -> username];
            // Mail::send('request.email.changeAssign', $data1, function($msg) use($subject, $assignedTo){
            //     $msg -> from('thangtr97@gmail.com', 'Hi');
            //     $msg -> to($assignedTo -> email, $assignedTo -> username) -> subject('Thông báo của spec_it');
            // });
        }
    }
    /*
    * ajax post change status of request
    */
    public function postChangeTT1(Request $request){
       if($request->ajax()){
            $rid = $request ->rid;
            $choose = $request ->choose;
            if($choose == 1)
                echo 'New';
            else if($choose == 2)
                echo 'Inprogress';
            else if($choose == 3)
                echo 'Resolve';
            else if($choose == 4)
                echo 'Feedback';
            else if($choose == 5)
                echo 'Closed';
            else if($choose == 6) {
                echo 'Cancelled';
            }
            // update ticket
            $ticket= Ticket::find($rid);
            $ticket->status=$choose;
            if ($choose == 3) {
                $ticket -> resolved_at = date('Y-m-d').' 00:00:00';
            }
            $ticket->save();

            $email = $request -> email;
            $subject = $request -> subject;
            $status = $request -> status;
            // gửi Mail cho người thực hiện khi thay đổi trạng thái
            // $data = ['subject' => $subject, 'choose' => $choose, 'status' => $status];
            // Mail::send('request.email.changeTT', $data, function($msg) use($email){
            //     $msg -> from('thangtr97@gmail.com', 'Thông báo của spec_it || Thay đổi trạng thái công việc');
            //     $msg -> to($email, 'hi') -> subject('Thông báo của spec_it || Thay đổi trạng thái công việc');
            // });
        }
    }
    public function postChangeTT2(Request $request) {
        if($request->ajax()){
            echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-record "></span>Thay đổi bộ phận IT</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-edit "></span>Thay đổi mức độ ưu tiên</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-calendar"></span>Thay đổi deadline</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-hand-right "></span>Asign</button>  <button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-user "></span>Thay đổi người liên quan</button>';
        }
    }
    public function postChangeTT3(Request $request) {
        if($request->ajax()){
            echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-transfer "></span>Thay đổi trạng thái</button>';
        }
    }
    public function postChangeTT4(Request $request) {
        if($request->ajax()){
            echo '<button type="button" class="btn" disabled="disabled"><span class="glyphicon glyphicon-transfer"></span>Thay đổi trạng thái</button>';
        }
    }
     public function postChangeTT5(Request $request) {
        if($request->ajax()){
            $choose = $request->choose;
            echo '<b style="color:Tomato;">'.$choose.'</b>';
        }
    }
    /*
    * ajax đánh giá
    */
    public function postChangeTT6(Request $request) {
        if ($request -> ajax()) {
            echo '<label for="DG">Đánh giá</label>
                    <select class="form-control" id="DG" name="DG">
                        <option value="" >Chọc mức đánh giá</option>
                      <option value="0" >Không hài lòng </option>
                      <option value="1" >Hài lòng </option>
                    </select>';
        }
    }
    /*
    * ajax post change deadline of request
    */
    public function postChangeDL1(Request $request){
       if($request->ajax()){
            $rid = $request ->rid;
            $choose = $request ->choose;
            echo $choose;
            $ticket = Ticket::find($rid);
            $ticket->deadline=$choose;
            $ticket->save();

        }
    }
    /*
    * ajax post change độ ưu tiên required comment of request and send mail
    */
    public function postChangeDL2(Request $request) {
        if ($request -> ajax()) {
            
            $cmt=$request -> cmt;
            $rid=$request -> rid;
            $old_choose = $request -> old_choose;
            $date_old = strtotime($old_choose);
            $choose = $request -> choose;
            $date_new = strtotime($choose);
            $email = $request -> email;
            $subject = $request -> subject;
            if (!empty($cmt)) {
            echo "<div class='col-md-12'><div class='row'>
                        <div class='col-sm-12'>
                            <div class='panel panel-white post'>
                                <div class='post-heading'>
                                    <div class='pull-left image'>
                                        <img src='http://localhost:8080/spec_it/public/image/avatar.png' class='img-circle avatar' alt='user profile image'>
                                    </div>
                                    <div class='pull-left meta'>
                                        <div class='title h5'>
                                            <b>".Auth::user()->username."</b>
                                        </div>
                                        <h6 class='text-muted time'>A few seconds ago</h6>
                                    </div>
                                </div> 
                                <div class='post-description'> 
                                    <p>Thay đổi deadline : ".date('d-m-Y', $date_old)." => ".date('d-m-Y', $date_new)."</p>
                                    <p>$cmt</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            // gửi Mail cho người thực hiện khi thay đổi deadline
            // $data = ['subject' => $subject, 'choose' => $choose, 'old_choose' => $old_choose, 'cmt' => $cmt];
            // Mail::send('request.email.changeDeadline', $data, function($msg) use($email){
            //     $msg -> from('thangtr97@gmail.com', 'Thông báo của spec_it || Thay đổi deadline công việc');
            //     $msg -> to($email, 'hi') -> subject('Thông báo của spec_it || Thay đổi deadline công việc');
            // });

            //Tạo ticketThread lưu vào database
            $ticketThread = new Ticket_thread();
            $ticketThread->ticket_id = $rid;
            $ticketThread->employee_id = Auth::user() -> id;
            $ticketThread->content = '<p>Thay đổi deadline : '.date('d-m-Y', $date_old).' => '.date('d-m-Y', $date_new).'</p><p>'.$cmt.'</p>';
            $ticketThread->type=3;
            $ticketThread->note="a";
            $ticketThread->save();
        }
    }
    /*
    * ajax post change người liên quan of request and send mail
    */
    public function postChangeNLQ(Request $request){
       if($request->ajax()){

            $rid = $request ->rid;
            
            $choose = array();
            $choose = $request ->choose;
            $subject = $request -> subject;
            $email = $request -> email;
            $ticketRelater= Ticket_relater::select('ticket_id')-> where('ticket_id', $rid);
            $ticketRelater -> delete();
            $nlq1 = array();

            if(!empty($choose)){

                foreach ($choose as $id) {
                    $relater = new Ticket_relater();
                    $relater->ticket_id = $rid;
                    $relater->employee_id = $id;
                    $relater->save();
                    $nlq = User::findOrFail($id);
                    echo $nlq -> username."<br>";

                }
                for ($i = 0; $i < sizeof($choose); $i++) {
                    $nlq1[$i] = User::findOrFail($choose[$i]) -> username;
                }
            }
            // gửi mail đến người thực hiện
            // $data = ['subject' => $subject, 'nlq1' => $nlq1];
            // Mail::send('request.email.changeNLQ', $data, function($msg) use($email){
            //     $msg -> from('thangtr97@gmail.com', 'Thông báo của spec_it || Thay đổi người liên quan của công việc');
            //     $msg -> to($email, 'hi') -> subject('Thông báo của spec_it || Thay đổi người liên quan của công việc');
            // });
        }
    }
}
