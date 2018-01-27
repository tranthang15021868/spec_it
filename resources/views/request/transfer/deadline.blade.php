<!-- form change Deadline -->
<form action="{{action('TicketThreadController@postChangeDL1')}}" method="post"  id="edit-deadline" name="edit-deadline">
<div id="dl" class="inl">
	<button type="button" class="btn" data-toggle="modal" data-target="#myDL" @if(change($ticket -> team_id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> status) == 0 ) disabled = "disabled" @endif ><span class="glyphicon glyphicon-calendar"></span>Thay đổi deadline</button>
</div><!-- #dl -->
<div id="myDL" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Thay đổi deadline</h4>
			</div><!-- .modal-header -->
			<div class="modal-body">
				<div class="form-group">
					<label for="DL">Chọn deadline</label>
					<?php
						//change string to deadline
						$date = strtotime($ticket ->deadline);
					?>
					<input type="date" class="form-control" placeholder=""  name="txtDate" value="{{date('Y-m-d', $date)}}" min="{{date('Y-m-d')}}">
				</div>
				<!-- content Bình luận -->
				<span><h3>Bình luận</h3></span>
				<textarea class="form-control" name="txtContent2" ></textarea>
				<script type="text/javascript">CKEDITOR.replace( 'txtContent2' ) </script>
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button  id="ok3" type="submit" class="btn btn-default pull-left" data-dismiss="modal">OK</button>
				<button type="submit" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div><!-- .modal-footer -->
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- #myDL -->
</form><!-- end of the form -->
<script type="text/javascript">
  $(document).ready(function(){

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  /*
	* function format date
  */
  	function formatDate(date) {
		content = date.split('-');
		result = content[2]+'-'+content[1]+'-'+content[0];
		return result;
	}
	// Thay đổi deadline
  	$('#ok3').on("click",function(e){

      	e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var url=$("form[name='edit-deadline']").attr('action');
        var post=$("form[name='edit-deadline']").attr('method');
        var ticket = <?php echo "$ticket";?>;
        var choose = $("input[name='txtDate']").val();
		var deadline = ticket.deadline;
		var old_choose = deadline.replace(" 00:00:00","");
		var cmt=CKEDITOR.instances.txtContent2.getData();
        if (old_choose != choose && cmt != "") {
        	$.ajax({
	          	type:post,
	          	url:url,
	          	data:{"rid":rid,"choose":choose},
	          
	          	success:function(kq){
				result = formatDate(kq);
	            $('#tdl').html(result);
	          }
	        })
        }
    });
    // required comment
  	$('#ok3').on("click",function(e){

		e.preventDefault();
		var rid=<?php echo "$id" ;?>;
		var ticket = <?php echo "$ticket";?>;
		var deadline = ticket.deadline;
		var choose=$("input[name='txtDate']").val();
		var old_choose = deadline.replace(" 00:00:00","");
		var subject = ticket.subject;
		var as = <?php echo "$assignedTo";?>;
		var email = as.email;
		if (old_choose != choose) {

			var cmt=CKEDITOR.instances.txtContent2.getData();
			if (cmt == "") {
				alert("Bạn cần nhập lý do thay đổi deadline");
			}
			else {
				var url = "http://localhost:8080/spec_it/changeDL2";
				var post = "POST";
				$.ajax({
					type:post,
					url:url,
					data:{"rid":rid,"cmt":cmt,"old_choose":old_choose,"choose":choose, "subject":subject, "email":email},
					
					success:function(kq){
						$('#comment').append(kq);
					}
				})
				CKEDITOR.instances.txtContent2.setData();
			}
		}
	});
</script>