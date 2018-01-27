<form action="{{action('TicketThreadController@postChangeNLQ')}}" method="post"  id="edit-NLQ" name="edit-NLQ"><!-- form -->
<div id ="nlq" class="inl"><!-- #nlq -->
  <button type="button" class="btn" data-toggle="modal" data-target="#myNLQ" @if(changeNLQ($ticket -> team_id, Auth::user() -> id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> create_by, $ticket -> status) == 0 ) disabled = "disabled" @endif><span class="glyphicon glyphicon-user"></span>Thay đổi người liên quan</button>
</div><!-- /#nlq -->
<div id="myNLQ" class="modal fade" role="dialog"><!-- #myNLQ -->
	<div class="modal-dialog"><!-- .modal-dialog -->
		<!-- Modal content-->
		<div class="modal-content"><!-- .modal-content -->
			<div class="modal-header"><!-- .modal-header -->
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Thay đổi người liên quan</h4>
			</div><!-- /.modal-header -->
			<div class="modal-body"><!-- .modal-body -->
				<div class="form-group"><!-- .form-group -->
					<label for="NLQ">Chọn người liên quan</label>
					<select id="multipleSelectExample" data-placeholder="Chọn người liên quan" multiple name="select[]">
            @foreach($user as $us)
            <option @foreach($relater as $rl) @if($us->id==$rl->id) selected @endif @endforeach value="{{$us->id}}">{{$us->username}}</option>
            @endforeach
					</select><!-- end of select -->
				</div><!-- /.form-group -->
			</div><!-- /.modal-body -->
			<div class="modal-footer">
				<button type="submit" id="ok4" class="btn btn-default pull-left" data-dismiss="modal">OK</button>
				<button type="submit" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /#myNLQ -->
</form><!-- end of form -->
<script type="text/javascript">
  $(document).ready(function(){

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  $('#ok4').on("click",function(e){

      e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var url=$("form[name='edit-NLQ']").attr('action');
        var post=$("form[name='edit-NLQ']").attr('method');
        var ticket = <?php echo "$ticket";?>;
        var subject = ticket.subject;
        var as = <?php echo "$assignedTo";?>;
        var email = as.email;
        var choose = new Array();
        choose=$("[name='select[]']").val();
        $.ajax({
          type:post,
          url:url,
          data:{"rid":rid,"choose":choose, "subject":subject, "email":email},
          
          success:function(kq){
            $('#trl').html(kq);
          },
          error:function(){
          	alert("lỗi");
          }
        })
    });

</script>

