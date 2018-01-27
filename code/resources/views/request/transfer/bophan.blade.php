<form action="{{action('TicketThreadController@postChangeBP1')}}" method="post"  id="edit-bophan" name="edit-bophan"><!-- form -->
  <div id="it" class="inl"><!-- #it -->
    <button type="button" class="btn" data-toggle="modal" data-target="#myBP" @if(change($ticket -> team_id, Auth::user() -> level, Auth::user() -> team_id, $ticket -> status) == 0 ) disabled = "disabled" @endif ><span class="glyphicon glyphicon-record "></span>Thay đổi bộ phận IT</button>
  </div><!-- /#it -->
  <div id="myBP" class="modal fade" role="dialog"><!-- .myBP -->
    <div class="modal-dialog"><!-- .modal-dialog -->
      <!-- Modal content-->
      <div class="modal-content"><!-- .modal-content -->
        <div class="modal-header"><!-- .modal-header -->
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Thay đổi bộ phận IT</h4>
        </div><!-- /.modal-header -->
        <div class="modal-body"><!-- .modal-body -->
          <div class="form-group">
            <label for="BP">Chọn bộ phận IT</label>
            <select class="form-control" id="BP" name="BP"><!-- select -->
              <option value="1" @if($ticket -> team_id == 1) selected @endif >IT-Hà Nội</option>
              <option value="2" @if($ticket -> team_id == 2) selected @endif >IT Đà Nẵng</option>
            </select><!-- end of select -->
          </div><!-- /.modal-body -->
        </div>
        <div class="modal-footer"><!-- .modal-footer -->
          <button type="submit" id="ok1" class="btn btn-default pull-left" data-dismiss="modal" >OK</button>
          <button type="submit" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div>
  </div><!-- /.myBP -->
  </form><!-- /form -->
<script type="text/javascript">
  $(document).ready(function(){

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  $('#ok1').on("click",function(e){

      e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var url=$("form[name='edit-bophan']").attr('action');
        var post=$("form[name='edit-bophan']").attr('method');
        var ticket = <?php echo "$ticket";?>;
        var team_id = ticket.team_id;
        var choose=$('#BP').val();
        if (choose != team_id) {
          $.ajax({
            type:post,
            url:url,
            data:{"rid":rid,"choose":choose},
            
            success:function(kq){
              $('#AS').html(kq);
            }
          })
        }
    });
   $('#ok1').on("click",function(e){

      e.preventDefault();
        var choose=$('#BP').val();
        var ticket = <?php echo "$ticket";?>;
        var team_id = ticket.team_id;
        var subject = ticket.subject;
        if(choose == 1){
          var leader = <?php echo "$leader_hn"; ?>;
         
        }
        else if(choose == 2){
          var leader = <?php echo "$leader_dn"; ?>;
         
        }
        if (choose != team_id) {
          $.ajax({
            type:"POST",
            url:"http://localhost:8080/spec_it/changeBP2",
            data:{"choose":choose, "leader": leader, 'subject': subject, 'team_id': team_id},
            
            success:function(kq){
              $('#ttid').html(kq);
            }
          })
        }
    });
   $('#ok1').on("click",function(e){

        e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var choose=$('#BP').val();
        var ticket = <?php echo "$ticket";?>;
        var team_id = ticket.team_id;
        if (choose != team_id) {
          $.ajax({
            type:"POST",
            url:"http://localhost:8080/spec_it/changeBP3",
            data:{"rid":rid,"choose":choose},
            
            success:function(kq){
              $('#tas').html(kq);
            }
          })
        }
    });
    $('#ok1').on("click",function(e){
      e.preventDefault();
        var auth = <?php echo Auth::user(); ?>;
        var choose=$('#BP').val();
        var ticket = <?php echo "$ticket";?>;
        var team_id = ticket.team_id;
        if (choose != team_id) {
          if ((choose == 2 && auth.level == 0 && auth.team_id == 1) || (choose == 1 && auth.level == 1 && auth.team_id == 2)) {
            $.ajax({
              type:"POST",
              url:"http://localhost:8080/spec_it/changeBP4",
              success:function(kq){
                $('#it').html(kq);
              }
            })
          }
        }
    });
    $('#ok1').on("click",function(e){
      e.preventDefault();
        var auth = <?php echo Auth::user(); ?>;
        var choose=$('#BP').val();
        var ticket = <?php echo "$ticket";?>;
        var team_id = ticket.team_id;
        if (choose != team_id) {
          if ((choose == 2 && auth.level == 0 && auth.team_id == 1) || (choose == 1 && auth.level == 1 && auth.team_id == 2)) {
            $.ajax({
              type:"POST",
              url:"http://localhost:8080/spec_it/changeBP5",
              success:function(kq){
                $('#3button').html(kq);
              }
            })
          }
        }
    });
    $('#ok1').on("click",function(e){
      e.preventDefault();
        var auth = <?php echo Auth::user(); ?>;
        var choose=$('#BP').val();
        var ticket = <?php echo "$ticket"; ?>;
        var team_id = ticket.team_id;
        if (choose != team_id) {
          if ((choose == 2 && auth.level == 0 && auth.team_id == 1 && auth.id != ticket.create_by ) || (choose == 1 && auth.level == 1 && auth.team_id == 2 && auth.id != ticket.create_by)) {
            $.ajax({
              type:"POST",
              url:"http://localhost:8080/spec_it/changeBP6",
              success:function(kq){
                $('#nlq').html(kq);
              }
            })
          }
        }
    });
    $('#ok1').on("click",function(e){
      e.preventDefault();
        var auth = <?php echo Auth::user(); ?>;
        var choose=$('#BP').val();
        var ticket = <?php echo "$ticket"; ?>;
        var team_id = ticket.team_id;
        if (choose != team_id) {
          if(choose == 1){
            var leader = <?php echo "$leader_hn"; ?>;
           
          }
          else if(choose == 2){
            var leader = <?php echo "$leader_dn"; ?>;
           
          }
          if ((choose == 2 && auth.level == 0 && auth.team_id == 1 && auth.id != ticket.create_by && auth.id != leader.id ) || (choose == 1 && auth.level == 1 && auth.team_id == 2 && auth.id != ticket.create_by && auth.id != leader.id)) {
            $.ajax({
              type:"POST",
              url:"http://localhost:8080/spec_it/changeBP7",
              success:function(kq){
                $('#TTT').html(kq);
              }
            })
          }
        }
    });
    $('#ok1').on("click",function(e){

        e.preventDefault();
        var rid=<?php echo "$id" ;?>;
        var auth = <?php echo Auth::user(); ?>;
        var choose=$('#BP').val();
        var ticket = <?php echo "$ticket";?>;
        var team_id = ticket.team_id;
        if (choose != team_id) {
          if(choose == 1){
            var leader = <?php echo "$leader_hn"; ?>;
           
          }
          else if(choose == 2){
            var leader = <?php echo "$leader_dn"; ?>;
           
          }
          if ((choose == 2 && auth.level == 0 && auth.team_id == 1 && auth.id != ticket.create_by && auth.id != leader) || (choose == 1 && auth.level == 1 && auth.team_id == 2 && auth.id != ticket.create_by && auth.id != leader)) {
            $.ajax({
              type:"POST",
              url:"http://localhost:8080/spec_it/cmt2",
              data:{"rid":rid},
              
              success:function(kq){
                $('#cmt').html(kq);
              }
            })
          }
        }
    });
</script>