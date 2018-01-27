<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ url('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <script src="{!! url('public/editor/ckeditor/ckeditor.js') !!}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('public/admin/bower_components/datatables/media/css/jquery.dataTables.min.css') }}">
    <link href="{{ url('public/admin/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{!! url('public/css/style.css') !!}" rel="stylesheet">
    <link href="{!! url('public/css/table.css') !!}" rel="stylesheet">
</head>
<body>
<div class="container-fluid"><!-- .container-fluid -->
    <header id="header"><!-- #header -->
        <nav class="navbar"><!-- .navbar -->
            <div class="container-fluid"><!-- .container-fluid -->
                <div class="navbar-header"><!-- .navbar-header -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"><!-- .navbar-toggle -->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button><!-- end of button -->
                    <a class="navbar-brand" href="{{route('create.getRequest')}}">Request IT</a>
                </div><!-- .navbar-header -->
                <div class="collapse navbar-collapse" id="myNavbar"><!-- #myNavbar -->
                    <ul class="nav navbar-nav"><!-- ul -->
                        <li class="active"><a href="{{route('create.getRequest')}}">IT</a></li>
                    </ul><!-- end of ul -->
                    <ul class="nav navbar-nav"><!-- ul -->
                        <li class="active"><a href="@yield('link')">@yield('submn')</a></li>
                    </ul><!-- end of ul -->
                    <ul class="nav navbar-top-links navbar-right"><!-- .nav .navbar-top-links .navbar-right -->
                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><!-- .dropdown-toggle -->
                                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a><!-- /.dropdown-toggle -->
                            <ul class="dropdown-menu dropdown-user"><!-- .dropdown-menu .dropdown-user -->
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> {!! Auth::user() -> username !!} - {!! Auth::user() -> id !!}</a>
                                </li>
                                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out fa-fw"></i>
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul><!-- .dropdown-menu .dropdown-user -->
                        </li><!-- /.dropdown-user -->
                    </ul> <!-- /.dropdown -->
                </div><!-- /#myNavbar -->
            </div><!-- /.container-fluid -->
        </nav><!-- /.navbar -->
    </header><!-- /header -->
    <content><!-- content -->
        <div class="row"><!-- .row -->
            <div class="col-md-3 col-xs-4"><!-- .col-md-3 .col-xs-4 -->
                <div class="addRq"><!-- .addRq -->
                    <a class="btn btn-danger" href="{!! route('create.getRequest') !!}" title="">Thêm yêu cầu</a>
                </div><!-- /.addRq -->
                </br>
                <div class="panel panel-default"><!-- .panel -->
                    <div class="panel-heading"><!-- .panel-heading -->
                        <h4 class="panel-title"><!-- .panel-title -->
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
                            </span>Việc tôi yêu cầu<span class="pull-right"></span></a>
                        </h4><!-- /.panel-title -->
                    </div><!-- /.panel-heading -->
                    <div id="collapseOne" class="panel-collapse collapse in"><!-- #collapseOne -->
                        <div class="panel-body"><!-- .panel-body -->
                            <table class="table menu"><!-- table -->
                                <tr>
                                    <td class="tbl-td">
                                        <?php
                                            $all_1 = DB::table('tickets')->select('id','create_by')->where('create_by',Auth::user() -> id)->count();
                                            $all_mr_1 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.create_by',Auth::user() -> id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id]])->count();
                                        ?>
                                        <span data-big ="create_by" data-small="all" class="glyphicon glyphicon-inbox text-primary"></span>All<span @if($all_mr_1>0)class="pull-right mark_read" @endif></span><span class="label label-default pull-right">@if($all_1!=0){{$all_1}}@endif</span>
                                    </td>
                                </tr>
                                <tr >
                                    <td class="tbl-td">
                                        <?php
                                            $new_1 = DB::table('tickets')->select('id','create_by')->where([['create_by',Auth::user() -> id],['status',1]])->count();
                                        ?>
                                        <span data-big ="create_by" data-small="new" class="glyphicon glyphicon-envelope text-success"></span>New<span class="label label-info pull-right">@if($new_1!=0){{$new_1}}@endif</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tbl-td">
                                        <?php
                                            $inprogress_1 = DB::table('tickets')->select('id','create_by')->where([['create_by',Auth::user() -> id],['status',2]])->count();
                                            $inprogress_mr_1 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.create_by',Auth::user() -> id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',2]])->count();
                                        ?>
                                        <span data-big ="create_by" data-small="inprogress" class="glyphicon glyphicon-import text-info"></span>Inprogress<span @if($inprogress_mr_1>0)class="pull-right mark_read" @endif></span><span class="label label-primary pull-right">@if($inprogress_1!=0){{$inprogress_1}}@endif</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tbl-td">
                                        <?php
                                            $resolved_1 = DB::table('tickets')->select('id','create_by')->where([['create_by',Auth::user() -> id],['status',3]])->count();
                                            $resolved_mr_1 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.create_by',Auth::user() -> id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',3]])->count();
                                        ?>
                                        <span data-big ="create_by" data-small="resolved" class="glyphicon glyphicon-registration-mark text-success"></span>Resolved<span @if($resolved_mr_1>0)class="pull-right mark_read" @endif></span>
                                        <span class="label label-success pull-right">@if($resolved_1!=0){{$resolved_1}}@endif</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tbl-td">
                                        <?php
                                            $outofdate_1 = DB::table('tickets')->select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> where([['deadline','<',date('Y-m-d').' 00:00:00'],['create_by', Auth::user() -> id],['status','<>',5]]) -> count();
                                        ?>
                                        <span data-big ="create_by" data-small="outofdate" class="glyphicon glyphicon-calendar text-success"></span>Out Of Date<span></span>
                                        <span class="label label-danger pull-right">@if($outofdate_1!=0){{$outofdate_1}}@endif</span>
                                    </td>
                                </tr>
                            </table><!-- /table -->
                        </div><!-- /.panel-body -->
                    </div><!-- /#collapseOne -->
                </div><!-- /.panel -->
                <div class="panel panel-default"><!-- .panel -->
                    <div class="panel-heading"><!-- .panel-heading -->
                        <h4 class="panel-title"><!-- .panel-title -->
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1"><span class="glyphicon glyphicon-folder-close">
                            </span>Công việc liên quan</a>
                        </h4><!-- /.panel-title -->
                    </div><!-- /.panel-heading -->
                    <div id="collapseOne1" class="panel-collapse collapse in"><!-- #collapseOne1 -->
                        <div class="panel-body"><!-- .panel-body -->
                            <table class="table menu"><!-- .table .menu -->
                                <tr>
                                    <td class="tbl-td">
                                        <?php
                                            $all_2 = DB::table('ticket_relaters')->select('employee_id')->join('tickets','tickets.id','=','ticket_relaters.ticket_id')->where('ticket_relaters.employee_id',Auth::id())->count();
                                            $all_mr_2 = DB::table('tickets')->join('ticket_relaters','tickets.id','=','ticket_relaters.ticket_id')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['ticket_relaters.employee_id',Auth::user()->id],['ticket_reads.reader_id',Auth::user()->id],['ticket_reads.status',0]])->count();
                                        ?>
                                        <span data-big ="relater" data-small="all" class="glyphicon glyphicon-inbox text-primary"></span>All<span @if($all_mr_2>0)class="pull-right mark_read" @endif></span><span class="label label-default pull-right">@if($all_2!=0){{$all_2}}@endif</span>
                                    </td><!-- .tbl-td -->
                                </tr>
                                <tr>
                                    <td class="tbl-td"><!-- .tbl-td -->
                                        <?php
                                            $new_2 = DB::table('ticket_relaters')->select('employee_id')->join('tickets','tickets.id','=','ticket_relaters.ticket_id')->where([['tickets.status',1],['ticket_relaters.employee_id',Auth::id()]])->count();
                                            $new_mr_2 = DB::table('tickets')->join('ticket_relaters','tickets.id','=','ticket_relaters.ticket_id')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['ticket_relaters.employee_id',Auth::user()->id],['ticket_reads.reader_id',Auth::user()->id],['ticket_reads.status',0],['tickets.status',1]])->count();
                                        ?>
                                        <span  data-big ="relater" data-small="new" class="glyphicon glyphicon-envelope text-success all"></span>New<span @if($new_mr_2>0)class="pull-right mark_read" @endif></span><span class="label label-info pull-right">@if($new_2!=0){{$new_2}}@endif</span>
                                    </td><!-- /.tbl-td -->
                                </tr>
                                <tr>
                                    <td class="tbl-td"><!-- .tbl-td -->
                                        <?php
                                            $inprogress_2 = DB::table('ticket_relaters')->select('employee_id')->join('tickets','tickets.id','=','ticket_relaters.ticket_id')->where([['tickets.status',2],['ticket_relaters.employee_id',Auth::id()]])->count();
                                            $inprogress_mr_2 = DB::table('tickets')->join('ticket_relaters','tickets.id','=','ticket_relaters.ticket_id')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['ticket_relaters.employee_id',Auth::user()->id],['ticket_reads.reader_id',Auth::user()->id],['ticket_reads.status',0],['tickets.status',2]])->count();
                                        ?>
                                        <span data-big ="relater"  data-small="inprogress" class="glyphicon glyphicon-import text-info"></span>Inprogress<span @if($inprogress_mr_2>0)class="pull-right mark_read" @endif></span><span class="label label-primary pull-right">@if($inprogress_2!=0){{$inprogress_2}}@endif</span>
                                    </td><!-- /.tbl-td -->
                                </tr>
                                <tr>
                                    <td class="tbl-td"><!-- .tbl-td -->
                                        <?php
                                            $resolved_2 = DB::table('ticket_relaters')->select('employee_id')->join('tickets','tickets.id','=','ticket_relaters.ticket_id')->where([['tickets.status',3],['ticket_relaters.employee_id',Auth::id()]])->count();
                                            $resolved_mr_2 = DB::table('tickets')->join('ticket_relaters','tickets.id','=','ticket_relaters.ticket_id')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['ticket_relaters.employee_id',Auth::user()->id],['ticket_reads.reader_id',Auth::user()->id],['ticket_reads.status',0],['tickets.status',3]])->count();
                                        ?>
                                        <span data-big ="relater" data-small="resolved" class="glyphicon glyphicon-registration-mark text-success"></span>Resolved<span @if($resolved_mr_2>0)class="pull-right mark_read" @endif></span>
                                        <span class="label label-success pull-right">@if($resolved_2!=0){{$resolved_2}}@endif</span>
                                    </td><!-- /.tbl-td -->
                                </tr>
                                <tr>
                                    <td class="tbl-td"><!-- .tbl-td -->
                                        <?php
                                            $outofdate_2 = DB::table('tickets')->select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> join('ticket_relaters','tickets.id','ticket_relaters.ticket_id')->where([['deadline','<',date('Y-m-d').' 00:00:00'],['ticket_relaters.employee_id', Auth::user() -> id],['status','<>',5]]) -> count();
                                        ?>
                                        <span data-big ="relater" data-small="outofdate" class="glyphicon glyphicon-calendar text-success"></span>Out Of Date<span class="label label-danger pull-right">@if($outofdate_2!=0){{$outofdate_2}}@endif</span>
                                    </td><!-- /.tbl-td -->
                                </tr>
                            </table><!-- end of table -->
                        </div><!-- /.panel-body -->
                    </div><!-- /#collapseOne1 -->
                </div><!-- /.panel -->
                @if (!((Auth::user() -> level == 1 && Auth::user() -> team_id == 1) || (Auth::user() -> level == 2 && Auth::user() -> team_id != 1 && Auth::user() ->team_id != 2)))
                    <div class="panel panel-default"><!-- .panel .panel-default -->
                        <div class="panel-heading"><!-- .panel-heading -->
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne2"><span class="glyphicon glyphicon-folder-close">
                                </span>Việc tôi được giao</a>
                            </h4><!-- /.panel-title -->
                        </div><!-- /.panel-heading -->
                        <div id="collapseOne2" class="panel-collapse collapse in"><!-- #collapseOne2 -->
                            <div class="panel-body"><!-- .panel-body -->
                                <table class="table menu"><!-- table -->
                                    <tr>
                                        <?php
                                            $all_3 = DB::table('tickets')->select('id','assigned_to')->where('assigned_to',Auth::user() -> id)->count();
                                            $all_mr_3 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.assigned_to',Auth::user() -> id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id]])->count();
                                        ?>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <span data-big ="assigned_to" data-small="all" class="glyphicon glyphicon-inbox text-primary"></span>All<span @if($all_mr_3>0)class="pull-right mark_read" @endif></span><span class="label label-default pull-right">@if($all_3!=0){{$all_3}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $new_3 = DB::table('tickets')->select('id','assigned_to')->where([['assigned_to',Auth::user() -> id],['status',1]])->count();
                                                $new_mr_3 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.assigned_to',Auth::user() -> id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',1]])->count();
                                            ?>
                                            <span data-big ="assigned_to" data-small="new" class="glyphicon glyphicon-envelope text-success"></span>New<span @if($new_mr_3>0)class="pull-right mark_read" @endif></span><span class="label label-info pull-right">@if($new_3!=0){{$new_3}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $inprogress_3 = DB::table('tickets')->select('id','assigned_to')->where([['assigned_to',Auth::user() -> id],['status',2]])->count();
                                                $inprogress_mr_3 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.assigned_to',Auth::user() -> id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',2]])->count();
                                            ?>
                                            <span data-big ="assigned_to" data-small="inprogress" class="glyphicon glyphicon-import text-info"></span>Inprogress<span @if($inprogress_mr_3>0)class="pull-right mark_read" @endif></span><span class="label label-primary pull-right">@if($inprogress_3!=0){{$inprogress_3}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php 
                                                $resolved_3 = DB::table('tickets')->select('id','assigned_to')->where([['assigned_to',Auth::user() -> id],['status',3]])->count();
                                                $resolved_mr_3 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.assigned_to',Auth::user() -> id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',3]])->count();
                                            ?>
                                            <span data-big ="assigned_to" data-small="resolved" class="glyphicon glyphicon-registration-mark text-success"></span>Resolved<span @if($resolved_mr_3>0)class="pull-right mark_read" @endif></span>
                                            <span class="label label-success pull-right">@if($resolved_3!=0){{$resolved_3}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $outofdate_3 = DB::table('tickets')->select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> where([['deadline','<',date('Y-m-d').' 00:00:00'],['assigned_to', Auth::user() -> id],['status','<>',5]]) -> count();
                                            ?>
                                            <span data-big ="assigned_to" data-small="outofdate" class="glyphicon glyphicon-calendar text-success"></span>Out Of Date
                                            <span class="label label-danger pull-right">@if($outofdate_3!=0){{$outofdate_3}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                </table><!-- /table -->
                            </div><!-- /.panel-body -->
                        </div><!-- /#collapseOne2 -->
                    </div><!-- /.panel /.panel-default -->
                @endif
                @if (Auth::user() -> level != 2)
                    <div class="panel panel-default"><!-- .panel .panel-default -->
                        <div class="panel-heading"><!-- .panel-heading -->
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne3"><span class="glyphicon glyphicon-folder-close">
                                </span>Công việc của bộ phận IT</a>
                            </h4>
                        </div><!-- /.panel-heading -->
                        <div id="collapseOne3" class="panel-collapse collapse in"><!-- #collapseOne3 -->
                            <div class="panel-body"><!-- .panel-body -->
                                <table class="table menu"><!-- .table .menu -->
                                    <tr>
                                        <?php
                                            $all_4 = DB::table('tickets')->select('id','team_id')->where('team_id',Auth::user() -> team_id)->count();
                                            $all_mr_4 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.team_id',Auth::user()-> team_id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id]])->count();
                                        ?>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <span data-big ="team_id" data-small="all" class="glyphicon glyphicon-inbox text-primary"></span>All<span @if($all_mr_4>0)class="pull-right mark_read" @endif></span><span class="label label-default pull-right">@if($all_4!=0){{$all_4}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $new_4 = DB::table('tickets')->select('id','team_id')->where([['team_id',Auth::user() -> team_id],['status',1]])->count();
                                                $new_mr_4 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.team_id',Auth::user()-> team_id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',1]])->count();
                                            ?>
                                            <span data-big ="team_id" data-small="new" class="glyphicon glyphicon-envelope text-success"></span>New<span @if($new_mr_4>0)class="pull-right mark_read" @endif></span><span class="label label-info pull-right">@if($new_4!=0){{$new_4}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $inprogress_4 = DB::table('tickets')->select('id','team_id')->where([['team_id',Auth::user() -> team_id],['status',2]])->count();
                                                $inprogress_mr_4 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.team_id',Auth::user()-> team_id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',2]])->count();
                                            ?>
                                            <span data-big ="team_id" data-small="inprogress" class="glyphicon glyphicon-import text-info"></span>Inprogress<span @if($inprogress_mr_4>0)class="pull-right mark_read" @endif></span><span class="label label-primary pull-right">@if($inprogress_4!=0){{$inprogress_4}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php 
                                                $resolved_4 = DB::table('tickets')->select('id','team_id')->where([['team_id',Auth::user() -> team_id],['status',3]])->count();
                                                $resolved_mr_4 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.team_id',Auth::user()-> team_id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',3]])->count();
                                            ?>
                                            <span data-big ="team_id" data-small="resolved" class="glyphicon glyphicon-registration-mark text-success"></span>Resolved<span @if($resolved_mr_4>0)class="pull-right mark_read" @endif></span>
                                            <span class="label label-success pull-right">@if($resolved_4!=0){{$resolved_4}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $feedback = DB::table('tickets')->select('id','team_id')->where([['team_id',Auth::user() -> team_id],['status',4]])->count();
                                                $feedback_mr_4 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.team_id',Auth::user()-> team_id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',4]])->count();
                                            ?>
                                            <span data-big ="team_id" data-small="feedback" class="glyphicon glyphicon-import text-info"></span>FeedBack<span @if($feedback_mr_4>0)class="pull-right mark_read" @endif></span><span class="label label-warning pull-right">@if($feedback!=0){{$feedback}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $outofdate_4 = DB::table('tickets')->select('id','subject','priority','create_by','assigned_to','deadline','status', 'team_id') -> where([['deadline','<',date('Y-m-d').' 00:00:00'],['team_id', Auth::user() -> team_id],['status','<>',5]]) -> count();
                                            ?>
                                            <span data-big ="team_id" data-small="outofdate" class="glyphicon glyphicon-calendar text-success"></span>Out Of Date<span class="label label-danger pull-right">@if($outofdate_4!=0){{$outofdate_4}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                    <tr>
                                        <td class="tbl-td"><!-- .tbl-td -->
                                            <?php
                                                $closed = DB::table('tickets')->select('id','team_id')->where([['team_id',Auth::user() -> team_id],['status',5]])->count();
                                                $closed_mr_4 = DB::table('tickets')->join('ticket_reads','tickets.id','=','ticket_reads.ticket_id')->where([['tickets.team_id',Auth::user()-> team_id],['ticket_reads.status',0],['ticket_reads.reader_id',Auth::user()->id],['tickets.status',5]])->count();
                                            ?>
                                            <span data-big ="team_id" data-small="closed" class="glyphicon glyphicon-import text-info"></span>Closed<span @if($closed_mr_4>0)class="pull-right mark_read" @endif></span><span class="label label-default pull-right">@if($closed!=0){{$closed}}@endif</span>
                                        </td><!-- /.tbl-td -->
                                    </tr>
                                </table><!-- /.table /.menu -->
                            </div><!-- /.panel-body -->
                        </div><!-- /#collapseOne3 -->
                    </div><!-- /.panel /.panel-default -->
                @endif
            </div><!-- /col-md-3 -->
            @yield('content')
        </div><!-- /.row -->
    </content><!-- /content -->
    <script src="{{ url('public/admin/bower_components/jquery/3.2.1/jquery.min.js') }}"></script>
    <script src="{{ url('public/admin/bower_components/jquery/dist/chosen.jquery.min.js') }}"></script>
    <script src="{{ url('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('public/admin/bower_components/jquery/1.10.2/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('public/admin/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('public/js/select.js') }}"></script>
    <script src="{{ url('public/js/table.js') }}"></script>
    <script src="{{ url('public/admin/js/admin.js') }}"></script>
    <script>
        $(document).ready(
            function () {
                $("#multipleSelectExample").select2();
            }
        );
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        var $table = $('#table');
        var trBoldBlue = $("table");
        // Ghi vào database những công việc đã đọc
        $(trBoldBlue).on("click", "td", function (){
                var rid=$(this).attr('id');
                if(rid!=undefined){
                    var url = "http://localhost:8080/spec_it/info-edit-request/";
                    var ajax_url = $("form[name='mr-edit']").attr('action');
                    var post = "POST";
                    $.ajax({
                        type:post,
                        url:ajax_url,
                        data:{"rid":rid},
                        success:function(kq){
                        }
                    })
                    
                    $(location).attr("href",url + rid);
                }
        });
         $('.menu').on("click", "td", function (){
               $(this).toggleClass("bold-blue");
               
        });
         // Chuyển trang menu
        $(trBoldBlue).on("click",".tbl-td", function (){
            var  url = "http://localhost:8080/spec_it/list-request/";
            var  big = $(this).find("span").attr('data-big');
            var  small = $(this).find("span").attr('data-small');
            $(location).attr("href",url + big+'/'+small);
        });
        // Đánh dấu công việc đã đọc
        $('#table').on('click', 'input[type="radio"]', function(){  
            var  rid = $(this).parent().parent().next().attr('id');
            $.ajax({
                type:"POST",
                url: "http://localhost:8080/spec_it/checkbox",
                data:{"rid":rid},
                success:function(kq){
                }
            })
            $(this).slideUp(1000).delay(300);
        });
    </script>
    @yield('script')
</div>
</body>
</html>