@extends('admin.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Add</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="{!! route('admin.user.getAdd') !!}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="txtUser" placeholder="Please Enter Username" value="{!! old('txtUser') !!}" />
                        @if($errors -> first('txtUser') != null)
                        <div class="alert alert-danger">
                            {!! $errors -> first('txtUser') !!}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="txtPass" placeholder="Please Enter Password" />
                        @if($errors -> first('txtPass') != null)
                        <div class="alert alert-danger">
                            {!! $errors -> first('txtPass') !!}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>RePassword</label>
                        <input type="password" class="form-control" name="txtRePass" placeholder="Please Enter RePassword" />
                        @if($errors -> first('txtRePass') != null)
                        <div class="alert alert-danger">
                            {!! $errors -> first('txtRePass') !!}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="txtEmail" placeholder="Please Enter Email" {!! old('txtEmail') !!}/>
                        @if($errors -> first('txtEmail') != null)
                        <div class="alert alert-danger">
                            {!! $errors -> first('txtEmail') !!}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>User Level</label>
                        <label class="radio-inline">
                            <input name="rdoLevel" value="0" checked="" type="radio">Leader
                        </label>
                        <label class="radio-inline">
                            <input name="rdoLevel" value="1" checked="" type="radio">Sub_leader
                        </label>
                        <label class="radio-inline">
                            <input name="rdoLevel" value="2" checked="checked" type="radio">Member
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Team</label>
                        <select class="form-control" name="team" value= "{!! old('team') !!}">
                            <option value="">Chọn team</option>
                            <option value="1">IT-Hà Nội</option>
                            <option value="2" class="active">IT-Đà Nẵng</option>
                            <option value="3">Team khác</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">User Add</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection()