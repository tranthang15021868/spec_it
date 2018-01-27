@extends('request.master')
@section('title', 'List Request')
@section('submn', 'List Request')
@section('content')
<?php
    if($big=='create_by')            $big   = "Việc tôi yêu cầu";
    else if ($big=='relater')        $big   = "Công việc liên quan";
    else if ($big=='assigned_to')    $big   = "Việc tôi được giao";
    else                             $big   = "Công việc của team";
    if ($small == 'all')             $small = "Tất cả công việc";
    else if ($small == 'new')        $small = "Công việc mới";
    else if ($small == 'inprogress') $small = "Công việc đang tiến hành";
    else if ($small == 'resolved')   $small = "Công việc đã hoàn thành";
    else if ($small == 'outofdate')  $small = "Công việc đã quá hạn";
    else if ($small == 'feedback')   $small = "Công việc được đánh giá";
    else                             $small = "Công việc đã đóng";
?>
<div class="col-md-9 col-xs-8">
    <div class="row">
        <div class="col-md-8"><!-- .col-md-8 -->
            <h1><b>{{$big}}</b></h1><h5><i><u><b>{{$small}}</b></u></i></h5>
            <br><br>
        </div><!-- /.col-md-8 -->
        <div class="col-md-4">
            
        </div>
    </div>
    <form action="{{action('TicketReadController@postMarkread')}}" method="POST" name="mr-edit" id="mr-edit">
        <!-- data-filter-position="top" -->
             <table  class="table table-bordered table-hover border-thick" data-checkbox = "true" id="table" ><!-- table -->
                <thead>
                    <tr>
                        <th><h4><b>STT</b></h4></th>
                        <th class="filter_input"><h4><b>Tên công việc</b></h4></th>
                        <th class="filter_select"><h4><b>Mức độ ưu tiên</b></h4></th>
                        <th class="filter_input"><h4><b>Người yêu cầu</b></h4></th>
                        <th class="filter_input"><h4><b>Người thực hiện</b></h4></th>
                        <th class="filter_input"><h4><b>Ngày hết hạn</b></h4></th>
                        <th class="filter_select"><h4><b>Trạng thái</b></h4></th>
                    </tr>
                </thead><!-- /thead -->
            <tbody>
                <?php $stt = 0; ?>
                @foreach($ticket as $all)

                <?php
                    $cre = DB::table('users') -> where('id', $all["create_by"]) -> first();
                    $ass = DB::table('users') -> where('id', $all["assigned_to"]) -> first();
                    $unread =  DB::table('ticket_reads')->where([['reader_id',Auth::user()->id],['ticket_id',$all["id"]]])->first();
                    $deadline = str_replace( ' 00:00:00', '', $all['deadline'] );
                    $date = strtotime($deadline);
                ?>
                <tr @if(!empty($unread) && $unread->status ==0) class="unread" @endif>
                    <td>{!! $stt = $stt + 1 !!}</td>
                    <td id="{!! $all['id'] !!}" >{!!$all["subject"]!!}</td>
                    <td id="{!! $all['id'] !!}" >
                        @if($all["priority"] == 1)
                            Thấp
                        @elseif($all["priority"] == 2)
                            Bình thường 
                        @elseif($all["priority"] == 3)
                            Cao
                        @elseif($all["priority"] == 4)
                            Khẩn cấp
                        @endif
                    </td>
                    <td id="{!! $all['id'] !!}">
                        @if(!empty($cre -> username)) 
                            {!! $cre -> username !!}
                        @endif
                    </td>
                    <td id="{!! $all['id'] !!}">
                        @if(!empty($ass -> username)) 
                            {!! $ass -> username !!}
                        @endif
                    </td>
                    <td id="{!! $all['id'] !!}" class="tbl-td-2">{{date('d-m-Y', $date)}}</td>
                    <td id="{!! $all['id'] !!}">
                        @if($all["status"] == 1)
                            New
                        @elseif($all["status"] == 2)
                            Inprogress
                        @elseif($all["status"] == 3)
                            Resolved
                        @elseif($all["status"] == 4)
                            Feedback
                        @elseif($all["status"] == 5)
                            Closed
                        @elseif($all["status"] == 6)
                            Cancelled
                        @endif
                    </td>
                </tr>
                @endforeach <!-- end of the loop. -->
            </tbody><!-- /tbody -->
        </table><!-- /.table .table-bordered .table-hover .border-thick -->
    </form>
    <div class="row">
        <div class="col-md-11">
          
        </div><!-- /.col-md-11 -->
        <div class="col-md-11">
            <input class="btn btn-primary" id="reset_filter" type="button" value="Reset form">
        </div><!-- /.col-md-11 -->
    </div><!-- /.row -->
</div>
@endsection