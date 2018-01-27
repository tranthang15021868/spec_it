<form action="{{action('TicketThreadController@postChangeTT1')}}" method="post" name="edit-tt"><!-- form -->
  <?php $arr = changeTT($ticket -> team_id, Auth::user() -> id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> create_by, $assignedTo -> id, $ticket -> status);?>
<div id = "TTT"><!-- #TTT -->
  <button type="button" class="btn" data-toggle="modal" data-target="#myTT" @if(($arr[0] == 0 ) || noRe(Auth::user() -> id, $assignedTo -> id, $ticket -> status) == 0 || changeBPIT($ticket -> team_id, Auth::user() -> id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> create_by, $assignedTo -> id) == 0) disabled = "disabled" @endif ><span class="glyphicon glyphicon-transfer"></span>Thay đổi trạng thái</button>
</div><!-- /#TTT -->
<div id="myTT" class="modal fade" role="dialog"><!-- #myTT -->
	<div class="modal-dialog"><!-- .modal-dialog -->
		<!-- Modal content-->
		<div class="modal-content"><!-- .modal-content -->
			<div class="modal-header"><!-- .modal-header -->
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Thay đổi trạng thái</h4>
			</div><!-- /.modal-header -->
			<div class="modal-body"><!-- .modal-body -->
				<div class="form-group"><!-- .form-group -->
					<label for="TT">Chọn trạng thái</label>
					<select class="form-control" id="TT" name="TT"><!-- select -->
             <option value="" >Chọn trạng thái </option>
            @if($arr[0] == 2)
              <option value="2" @if($ticket->status == 2) selected @endif>Inprogress</option>
            @endif
            @if($arr[0]== 3)
             <option value="3" @if($ticket->status == 3) selected @endif>Resolve</option>
            @endif
            @if($arr[0] == 4)
             <option value="4" @if($ticket->status == 4) selected @endif>Feedback</option>
            @endif
						@if($arr[1] == 5)
             <option value="5" @if($ticket->status == 5) selected @endif>Closed</option>
            @endif
						@if($arr[2] == 6)
             <option value="6" @if($ticket->status == 6) selected @endif>Cancelled</option>
            @endif
					</select><!-- end of select -->
				</div><!-- /.form-group -->
        <div id = "FDG" class="form-group">
            
        </div>
			</div><!-- /.modal-body -->
			<div class="modal-footer">

				<button id="ok6" type="submit" class="btn btn-default pull-left" data-dismiss="modal">OK</button>
				<button type="submit" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /#myTT -->
</form><!-- end of form -->
<script type="text/javascript">
  $(document).ready(function(){

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  	$('#ok6').on("click",function(e){

      e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var url=$("form[name='edit-tt']").attr('action');
        var post=$("form[name='edit-tt']").attr('method');
        var choose=$('#TT').val();
        var ticket = <?php echo "$ticket";?>;
        var subject = ticket.subject;
        var status = ticket.status;
        var as = <?php echo "$assignedTo";?>;
        var email = as.email;
        if(choose != 4 && choose != 5 && choose!=""){
             $.ajax({
                type:post,
                url:url,
                data:{"rid":rid,"choose":choose, "subject":subject, "email":email, "status":status},
          
                success:function(kq){
                $('#ts').html(kq);
            }
          })
        }
        else if (choose == 4){
            choose = "Feedback ( Đang chờ bình luận )";
            $.ajax({
                type:post,
                url:"http://localhost:8080/spec_it/changeTT5",
                data:{"choose":choose},
          
                success:function(kq){
                  $('#ts').html(kq);
                }
            })
        }
        else if (choose == 5){
            var choose1 = $('#DG').val();
            if (choose1 != "") {
               choose = "Closed ( Đang chờ đánh giá )";
                $.ajax({
                    type:post,
                    url:"http://localhost:8080/spec_it/changeTT5",
                    data:{"choose":choose},
              
                    success:function(kq){
                      $('#ts').html(kq);
                    }
                })
            }
        }

       
    });
    $('#ok6').on("click",function(e){
      	e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var choose=$('#TT').val();
        if (choose == 3 || choose == 5 || choose ==6) {
          $.ajax({
            type:"POST",
            url:"http://localhost:8080/spec_it/changeTT2",
            success:function(kq){
              $('#5button').html(kq);
            }
          })
        }
    });
   
    $('#ok6').on("click",function(e){
        e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var ticket = <?php echo "$ticket"; ?>;
        var user = <?php echo Auth::user(); ?>;
        var choose=$('#TT').val();
        if (choose == 3 && ticket.assigned_to == user.id) {
          $.ajax({
            type:"POST",
            url:"http://localhost:8080/spec_it/changeTT3",
            
            success:function(kq){
              $('#TTT').html(kq);
            }
          })
        }
    });
    $('#ok6').on("click",function(e){
        e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var choose=$('#TT').val();
        var choose1 = $('#DG').val();
        if (choose1 == "") {
          alert("Bạn phải chọn mức đánh giá")
        }
        else {
          if (choose == 5 || choose == 6) {
            $.ajax({
              type:"POST",
              url:"http://localhost:8080/spec_it/changeTT4",
              
              success:function(kq){
                $('#TTT').html(kq);
              }
            })
          }
        }
    });

    $('#TT').on("change",function(e){
        e.preventDefault();
        var choose=$('#TT').val();
        if (choose == 5) {
          $.ajax({
            type:"POST",
            url:"http://localhost:8080/spec_it/changeTT6",
            
            success:function(kq){
              $('#FDG').html(kq);
            }
          })
        }
    });
</script>