<!DOCTYPE html>
<html>
<head>
	<title>Info request || {{$ticket -> subject}}</title>
	<meta charset="utf8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{ url('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<script src="{{ url('public/admin/bower_components/jquery/3.2.1/jquery.min.js') }}"></script>
	<script src="{!! url('public/editor/ckeditor/ckeditor.js') !!}"></script>
	<link href="{!! url('public/css/style.css') !!}" rel="stylesheet">
</head>
<body>
	<div class="container-fluid"><!-- .container-fluid -->
		<div class="row header1"><!-- .row .header -->
			<div class="col-md-5" id ="tk_subject"><!-- .col-md-5 -->
				<div class="glyphicon glyphicon-globe"></div><h2 class="inl" title="Trở về">{{ $ticket -> subject }}</h2>	
			</div><!-- /.col-md-5 -->
			<div class="col-md-6 col-md-push-1"><!-- .col-md-6 -->
				<div class="row">
					<div id = "5button">
						<div id ="bpit" class="inl">
							@include('request.transfer.bophan')
						</div><!-- #bpit -->
						<div id = "3button" class="inl">						
							@include('request.transfer.uutien')
							@include('request.transfer.deadline')
							@include('request.transfer.asign')	
						</div><!-- #3button -->
						<div id = "trt" class="inl">
							@include('request.transfer.nglienquan')
						</div><!-- #trt -->
					</div><!-- #5button -->
					<br><br>
					@include('request.transfer.status')
				</div>
			</div><!-- /.col-md-6 .col-md-push-1 -->
		</div><!-- /.row .header -->
		<hr>
		<div class="row"><!-- .row -->
			<div class="col-md-4"><!-- .col-md-4 -->
				<label class="HangMoi">Ngày tạo:</label>
				<span>{{date('d-m-Y', strtotime($ticket -> created_at))}}</span><br><br>
				<label class="HangMoi">Người yêu cầu:</label>
				<span>{{$createBy -> username}}</span><br><br>
				<label class="HangMoi">Mức độ ưu tiên:</label>
				<span id="tp"><!-- #tp -->
					@if(($ticket->priority) == 1)
						Thấp
					@elseif(($ticket->priority) == 2)
						Bình thường
					@elseif(($ticket->priority) == 3)
						Cao
					@elseif(($ticket->priority) == 4)
						Khẩn cấp
					@endif
				</span><!-- /.tp -->
			</div><!-- /.col-md-4 -->
			<div class="col-md-4"><!-- .col-md-4 -->
				<label class="HangMoi">Ngày hết hạn:</label>
				<span id="tdl"><!-- #tdl -->
					<?php
						$date = strtotime($ticket ->deadline);
					?>
					{{date('d-m-Y', $date)}}
				</span><br><br>
				<label class="HangMoi">Người thực hiên:</label>
				<span id="tas">{{$assignedTo -> username}}</span><br><br>
				<label class="HangMoi">Trạng thái:</label>
				<span id="ts"><!-- #ts -->
					@if(($ticket->status) == 1)
						New
					@elseif(($ticket->status) == 2)
						Inprogress
					@elseif(($ticket->status) == 3)
						Resolve
					@elseif(($ticket->status) == 4)
						Feedback
					@elseif(($ticket->status) == 5)
						Closed
					@elseif(($ticket->status) == 6)
						Cancelled
					@endif
				</span><!-- /#ts -->
			</div><!-- /.col-md-4 -->
			<div class="col-md-4"><!-- .col-md-4 -->
				<span></span><br><br>
				<label class="HangMoi">Bộ phận IT:</label>
				<span id="ttid"><!-- #ttid -->
					@if(($ticket -> team_id) == 1)
						IT Hà Nội
					@elseif(($ticket -> team_id) == 2)
						IT Đà Nẵng
					@endif
				</span><!-- /#ttid --><br><br>
				<label class="HangMoi">Người liên quan:</label>
				<span id="trl">
					@foreach($relater as $item)
						{{$item->username}}<br>
					@endforeach
				</span>
			</div><!-- /.col-md-4 -->
		</div><!-- /.row -->
		<hr>
		<div id="" class="row content"><!-- .row -->
			<div class="col-md-12"><!-- .col-md-12 -->
				<span class="glyphicon glyphicon-user"></span><h3 class="inl">Nội dung</h3><hr>
				<div class="col-md-12"><!-- .col-md-12 -->
					<div class="row"><!-- .row -->
						<div class="col-sm-12"><!-- .col-sm-12 -->
							<div class=".panel panel-white post bd"><!-- .panel -->
								<div class="post-heading"><!-- .post-heading -->
									<div class="pull-left image">
										<img src="{{ url('public/image/create.jpg') }}" class="img-circle avatar" alt="user profile image">
									</div>
									<div class="pull-left meta"><!-- .pull-left .meta -->
										<div class="title h5">
											<a href="#"><b>{{ $createBy -> username }}</b></a>
										</div><!-- /.title /.h5 -->
										<h6 class="text-muted time">{!! \Carbon\Carbon::createFromTimeStamp(strtotime($ticket["created_at"])) -> diffForHumans() !!}</h6>
									</div><!-- .pull-left .meta -->
								</div><!-- /.post-heading -->
								<div class="post-description"> 
									<p><?php
									$str = str_replace( '<p>', '', $ticket['content'] );
									echo $str;
									?></p>
								</div><!-- /.post-description -->
							</div><!-- /.panel .panel-white .post bd -->
						</div><!-- /.col-sm-12 -->
					</div><!-- /.row -->
				</div><!-- /.col-md-12 -->
				<hr><hr>
				@foreach($ticketThread as $cmt)
				<?php
					$user = DB::table('users') -> select('id', 'username') -> where('id', $cmt["employee_id"]) -> first();
				?>
				<div class="col-md-12"><!-- .col-md-12 -->
					<div class="row"><!-- .row -->
						<div class="col-sm-12"><!-- .col-sm-12 -->
							<div class="panel panel-white post"><!-- .panel -->
								<div class="post-heading"><!-- .post-heading -->
									<div class="pull-left image">
										<img src="{{ url('public/image/avatar.png') }}" class="img-circle avatar" alt="user profile image">
									</div><!-- .pull-left image -->
									<div class="pull-left meta">
										<div class="title h5">
											<a href="#"><b>{{ $user -> username }}</b></a>
										</div><!-- .title .h5 -->
										<h6 class="text-muted time">{!! \Carbon\Carbon::createFromTimeStamp(strtotime($cmt["created_at"])) -> diffForHumans() !!}</h6>
									</div><!-- /.pull-left .meta -->
								</div><!-- /.post-heading -->
								<div class="post-description"> 
									<p><?php
									$str = str_replace( '<p>', '', $cmt['content'] );
									echo $str;
									?></p>
								</div><!-- /.post-description -->
							</div><!-- /.panel .panel-white .post -->
						</div><!-- /.col-sm-12 -->
					</div><!-- /.row -->
				</div><!-- /.col-md-12 -->
				@endforeach
				<!-- mở form bình luận -->
				@if(findTicket($ticket -> team_id, Auth::user() -> id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> create_by, $ticket -> assigned_to))
					<form action="{{action('TicketThreadController@postCmt1')}}" method="POST" name="form-edit" id="edit"><!-- form -->
						<div id="comment"></div>
						<div id='cmt'><!-- .cmt -->
							<span><h3>Bình luận</h3></span>
							<textarea class="form-control" name="txtContent" ></textarea>
							<script type="text/javascript">CKEDITOR.replace( 'txtContent' ) </script>
							<br>
							<button  id="btn" type="submit" class="btn btn-info">Gửi bình luận</button>
							<button  id="back" type="submit" class="btn btn-info pull-right">Trở về</button>
							<br><br>
						</div><!-- /#cmt -->	
					</form> <!-- end of the form -->
				@endif
				<!-- kết thúc form bình luận -->
			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
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
		$('#back').on("click",function(){
			location.href = document.referrer; 
		})
		$('#tk_subject').on("click",function(){
			location.href = document.referrer; 
		})
		// Bắt sự kiện khi thay đổi trang thái sang feedback hoặc closed
		$('#edit').on("submit",function(e){

			e.preventDefault();
			var post = $(this).attr('method');
			var choose=$('#TT').val();
			var cmt=CKEDITOR.instances.txtContent.getData();
			var ticket = <?php echo "$ticket";?>;
	        var subject = ticket.subject;
	        var status = ticket.status;
	        var id = ticket.id;
	        var as = <?php echo "$assignedTo";?>;
	        var email = as.email;
			if((choose == 4 && cmt!= "") ||( choose == 5 && cmt!= "" )){
				$.ajax({
					type:post,
					url:"http://localhost:8080/spec_it/cmt3",
					data:{"choose":choose, "subject":subject, "email":email, "status":status, "id":id},
					
					success:function(kq){
						$('#ts').html(kq);
					}
				})
			}
		});
		$('#edit').on("submit",function(e){

			e.preventDefault();
			var post = $(this).attr('method');
			var choose=$('#TT').val();
			var ticket = <?php echo "$ticket";?>;
			var t_team_id = ticket.team_id;
			var cre = ticket.create_by;
			var user = <?php echo Auth::user(); ?>;
			var u_team_id = user.team_id;
			var level = user.level;
			var u_id = user.id;
  			var cmt=CKEDITOR.instances.txtContent.getData();
			if((choose == 4 && cmt!= "")){
				$.ajax({
					type:post,
					url:"http://localhost:8080/spec_it/cmt4",
					data:{"t_team_id":t_team_id,"cre":cre,"u_team_id":u_team_id,"level":level,"u_id":u_id},
					success:function(kq){
						$('#5button').html(kq);
					}
				})
			}
			
		});
		// Ajax comment
		$('#edit').on("submit",function(e){

			e.preventDefault();
			var rid=<?php echo "$id" ;?>;
			var cmt=CKEDITOR.instances.txtContent.getData();
			var url = $(this).attr('action');
			var post = $(this).attr('method');
			var choose=$('#TT').val();
			var choose1 = $('#DG').val();
			if(cmt != ""){
				$.ajax({
				type:post,
				url:url,
				data:{"rid":rid,"cmt":cmt,"choose":choose, "choose1":choose1},
				
				success:function(kq){
					$('#comment').append(kq);
				}
			})
			CKEDITOR.instances.txtContent.setData();
			}
			
		});
		
		function xacNhanXoa(msg) {
            if(window.confirm(msg)) {
                return true;
            }
            return false;
        };
	</script>
	<script src="{{ url('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script> -->
	<script src="{{ url('public/admin/bower_components/datatables/media/js/popper.min.js') }}"></script>
	<script src="{{ url('public/js/select.js') }}"></script>
</body>
</html>