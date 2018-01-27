<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket_read;
use App\Ticket;
use Auth;
use DB;
class TicketReadController extends Controller
{
    public function postMarkread(Request $request){
    	 if($request->ajax()){
            $rid=$request->rid;
            $ticket_read = Ticket_read::where([['ticket_id',$rid],['reader_id',Auth::user()->id]])->first();
            $ticket_read->status = 1;
            $ticket_read->save();
        }
    }
    /*
    *đánh dấu đã đọc khi click vào checkbox
    */
    public function postMrCheckbox(Request $request){
    	 if($request->ajax()){
            $rid=$request->rid;
            $ticket_read = Ticket_read::where([['ticket_id',$rid],['reader_id',Auth::user()->id]])->first();
            $ticket_read->status = 1;
            $ticket_read->save(); 
        }
    }
}
