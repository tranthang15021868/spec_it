<form action="{{action('TicketThreadController@postChangeAS')}}" method="post" name="edit-AS"><!-- form -->
<div id = "as" class="inl"><!-- .as -->
	<button type="button" class="btn" data-toggle="modal" data-target="#myAS" @if(change($ticket -> team_id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> status) == 0 ) disabled = "disabled" @endif ><span class="glyphicon glyphicon-hand-right"></span>Asign</button>
</div><!-- /.as -->
<div id="myAS" class="modal fade" role="dialog"><!-- .myAS -->
	<div class="modal-dialog"><!-- .modal-dialog -->
		<!-- Modal content-->
		<div class="modal-content"><!-- .modal-content -->
			<div class="modal-header"><!-- .modal-header -->
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Thay đổi người thực hiện</h4>
			</div><!-- /.modal-header -->
			<div class="modal-body"><!-- .modal-body -->
				<div class="form-group"><!-- .form-group -->
					<label for="AS">Chọn người thực hiện</label>
					<select class="form-control" id="AS" name="AS">
						@foreach($user as $us)
							@if($ticket->team_id == 1 && $us -> team_id == 1 && $us -> level != 1)
								<option value="{{$us->id}}" @if($ticket->assigned_to == $us->id) selected @endif>{{$us->username}}</option>
							@elseif($ticket->team_id == 2 && $us -> team_id == 2)
								<option value="{{$us->id}}" @if($ticket->assigned_to == $us->id) selected @endif>{{$us->username}}</option>\
							@endif
						@endforeach
					</select><!-- end of select -->
				</div><!-- /.form-group -->
			</div><!-- /.modal-body -->
			<div class="modal-footer"><!-- .modal-footer -->
				<button id="ok5" type="submit" class="btn btn-default pull-left" data-dismiss="modal">OK</button>
				<button type="submit" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div><!-- /.modal-footer -->
		</div><!-- /.modal-content -->
	</div>modal-dialog
</div><!-- /.myAS -->
</form><!-- end of form -->
<script type="text/javascript">
  $(document).ready(function(){

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  $('#ok5').on("click",function(e){

      e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var url=$("form[name='edit-AS']").attr('action');
        var post=$("form[name='edit-AS']").attr('method');
        var ticket = <?php echo "$ticket";?>;
        var subject = ticket.subject;
        var assigned_to = ticket.assigned_to;
        var choose=$('#AS').val();
        if (choose != assigned_to) {
        	$.ajax({
	          type:post,
	          url:url,
	          data:{"rid":rid,"choose":choose, "subject":subject, "assigned_to":assigned_to},
	          
	          success:function(kq){
	            $('#tas').html(kq);
	          }
	        })
        }
    });

</script>