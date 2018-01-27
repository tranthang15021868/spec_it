<form action="{{action('TicketThreadController@postChangeUT1')}}" method="post" name="edit-uutien"><!-- form -->
	<div id = "ut" class="inl"><!-- #ut -->
		<button type="button" class="btn" data-toggle="modal" data-target="#myUT" @if(change($ticket -> team_id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> status) == 0 ) disabled = "disabled" @endif><span class="glyphicon glyphicon-edit" ></span>Thay đổi mức độ ưu tiên</button>
	</div><!-- /#ut -->
	<div id="myUT" class="modal fade" role="dialog"><!-- #myUT -->
		<div class="modal-dialog"><!-- .modal-dialog -->
			<!-- Modal content-->
			<div class="modal-content"><!-- .modal-content -->
				<div class="modal-header"><!-- .modal-header -->
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thay đổi độ ưu tiên</h4>
				</div><!-- /.modal-header -->
				<div class="modal-body"><!-- .modal-body -->
					<div class="form-group"><!-- .form-group -->
						<label for="UT">Chọn độ ưu tiên</label>
						<select class="form-control" id="UT" name="UT"><!-- select -->
							<option value="1" @if($ticket->priority == 1) selected @endif>Thấp</option>
							<option value="2" @if($ticket->priority == 2) selected @endif>Bình thường</option>
							<option value="3" @if($ticket->priority == 3) selected @endif>Cao</option>
							<option value="4" @if($ticket->priority == 4) selected @endif>Khẩn cấp</option>
						</select><!-- end of select -->
						<span><h3>Bình luận</h3></span>
						<textarea class="form-control" name="txtContent1" ></textarea>
						<script type="text/javascript">CKEDITOR.replace( 'txtContent1' ) </script>
					</div><!-- /.form-group -->
				</div><!-- /.modal-body -->
				<div class="modal-footer"><!-- .modal-footer -->
					<button type="submit" id="ok2" class="btn btn-default pull-left" data-dismiss="modal">OK</button>
					<button type="submit" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
				</div><!-- /.modal-footer -->
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /#myUT -->
</form><!-- end of form -->
<script type="text/javascript">
  $(document).ready(function(){

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  $('#ok2').on("click",function(e){

      e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var url=$("form[name='edit-uutien']").attr('action');
        var post=$("form[name='edit-uutien']").attr('method');
        var ticket = <?php echo "$ticket";?>;
        var subject = ticket.subject;
        var priority = ticket.priority;
        var ass = ticket.assigned_to;
		var choose=$('#UT').val();
		var cmt=CKEDITOR.instances.txtContent1.getData();
		if (priority != choose && cmt != "") {
			$.ajax({
	          	  type:post,
		          url:url,
		          data:{"rid":rid,"choose":choose,"priority":priority,"subject":subject,"ass":ass,"cmt":cmt},
		          
		          success:function(kq){
		            $('#tp').html(kq);
		          }
	        })
		}
		
    });
  	$('#ok2').on("click",function(e){

			e.preventDefault();
			var rid=<?php echo "$id" ;?>;
			var ticket = <?php echo "$ticket";?>;
			var choose=$('#UT').val();
			if (ticket.priority != choose) {
				var cmt=CKEDITOR.instances.txtContent1.getData();
				if (cmt == "") {
					alert("Bạn cần nhập lý do thay đổi mức độ ưu tiên");
				}
				else {
					var url = "http://localhost:8080/spec_it/changeUT2";
					var post = "POST";
					$.ajax({
						type:post,
						url:url,
						data:{"rid":rid,"cmt":cmt,"old_choose":ticket.priority,"choose":choose},
						
						success:function(kq){
							$('#comment').append(kq);
						}
					})
					CKEDITOR.instances.txtContent1.setData();
				}
			}
		});
</script>