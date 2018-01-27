@extends('request.master')
@section('title', 'Create Request')
@section('submn', 'Create Request')
@section('link', 'http://localhost:8080/spec_it/create-request')
@section('content')
<div class="col-md-9 col-xs-8"><!-- .col-md-9 -->
    <h3>Thêm yêu cầu</h3><hr>
    <form class="form-nhap" method="post" action="{!! route('create.getRequest') !!}" enctype="multipart/form-data"><!-- form -->
        @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="form-group row"><!-- .form-group -->
            <div class="col-xs-12"><!-- .col-xs-12 -->
                <label>Tên công việc<span style="color: red""> *</span></label>
                <input type="text" class="form-control" placeholder="Nhập tên công việc" name="txtName" value="{!! old('txtName') !!}">
                @if(count($errors) > 0 && $errors -> first('txtName') != null)
                    <div class="alert alert-danger">
                        {!! $errors -> first('txtName') !!}
                    </div>
                @endif
            </div><!-- /.col-xs-12 -->
        </div><!-- /.form-group -->
        <div class="form-group row"><!-- .form-group -->
            <div class="col-xs-6"><!-- .col-xs-6 -->
                <label>Mức độ ưu tiên</label>
                <select class="form-control" name="doUuTien" value= "{!! old('doUuTien') !!}">
                    <option value="">Chọn độ ưu tiên</option>
                    <option value="1">Thấp</option>
                    <option value="2" class="active">Bình thường</option>
                    <option value="3">Cao</option>
                    <option value="4">Khẩn cấp</option>
                </select>
                @if(count($errors) > 0 && $errors -> first('doUuTien') != null)
                <div class="alert alert-danger">
                    {!! $errors -> first('doUuTien') !!}
                </div>
                @endif
            </div><!-- /.col-xs-6 -->
            <div class="col-xs-6"><!-- .col-xs-6 -->
                <label>Ngày hết hạn<span style="color: red""> *</span></label>
                <input type="date" class="form-control" placeholder="" name="txtDate" value="{!! old('txtDate') !!}" min="{{date('Y-m-d')}}">
                @if(count($errors) > 0 && $errors -> first('txtDate') != null)
                <div class="alert alert-danger">
                    {!! $errors -> first('txtDate') !!}
                </div>
                @endif
            </div><!-- /.col-xs-6 -->
        </div><!-- /.form-group -->
        <div class="form-group row"><!-- .form-group -->
            <div class="col-xs-6"><!-- .col-xs-6 -->
                <label>Bộ phận IT<span style="color: red""> *</span></label>
                <select class="form-control" name="boPhanIT">
                    <option value="">Chọn Bộ phận IT</option>
                    <option value="1">IT-Hà Nội</option>
                    <option value="2" class="active">IT-Đà Nẵng</option>
                </select><!-- end of select -->
                @if(count($errors) > 0 && $errors -> first('boPhanIT') != null)
                    <div class="alert alert-danger">
                        {!! $errors -> first('boPhanIT') !!}
                    </div>
                @endif
            </div><!-- /.col-xs-6 -->
            <div class="col-xs-6"><!-- .col-xs-6 -->
                <label>Người liên quan</label>
                <div class="selectRow"><!-- .selectRow -->
                    <select id="multipleSelectExample" data-placeholder="Chọn người liên quan" multiple name="select[]">
                        @foreach($users as $user)
                            <option value="{{$user -> id}}">{{$user -> username}}</option>}
                        @endforeach
                    </select><!-- end of select -->
                </div><!-- /.selectRow -->
            </div><!-- /.col-xs-6 -->
        </div><!-- /.form-group -->
        <div class="form-group row"><!-- .form-group -->
            <div class="col-xs-12"><!-- .col-xs-12 -->
                <label>Nội dung<span style="color: red""> *</span></label>
                <textarea class="form-control" name="txtContent">{!! old('txtContent') !!}</textarea>
                <script type="text/javascript">CKEDITOR.replace( 'txtContent' ) </script>
                @if(count($errors) > 0 && $errors -> first('txtContent') != null)
                    <div class=".alert alert-danger"><!-- .alert -->
                        {!! $errors -> first('txtContent') !!}
                    </div><!-- /.alert -->
                @endif
            </div><!-- /.col-xs-12 -->
        </div><!-- /.form-group -->
        <div class="form-group row file"><!-- .form-group -->
            <div style="width:82.45%;" class="col-md-9"><!-- .col-md-9 -->
                <input id="uploadFile" placeholder="  Choose File To Upload" disabled="disabled" />
                @if(count($errors) > 0 && $errors -> first('image') != null)
                <div class="alert alert-danger">
                    {!! $errors -> first('image') !!}
                </div>
                @endif
            </div><!-- /.col-md-9 -->
            <div class="fileUpload btn btn-primary col-md-2"><!-- .fileUpload -->
                <span>Choose</span>
                <input id="uploadBtn" type="file" class="upload" name="image" value="{!! old('image') !!}" />
            </div><!-- /.fileUpload -->
        </div><!-- /.form-group -->
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span>Thêm yêu cầu</button>
        <button type="reset" class="btn btn-primary"><span class="glyphicon glyphicon-ban-circle"></span>Reset</button>
    </form><!-- /form -->
</div><!-- /col-md-9 -->
<script>
    document.getElementById("uploadBtn").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };
</script>
@endsection