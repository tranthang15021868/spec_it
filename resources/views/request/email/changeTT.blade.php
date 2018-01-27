Thay đổi trạng thái của công việc:<br>
Tên công việc: {{$subject}}<br>
Thay đổi trạng thái công việc từ @if($status == 1)
					                New
					            @elseif($status == 2)
					                Inprogress
					            @elseif($status == 3)
					                Resolve
					            @elseif($status == 4)
					                Feedback
					            @elseif($status == 5)
					                Closed
					            @elseif($status == 6)
					                Cancelled
					      
					            @endif
							sang @if($choose == 1)
					                New
					            @elseif($choose == 2)
					                Inprogress
					            @elseif($choose == 3)
					                Resolve
					            @elseif($choose == 4)
					                Feedback
					            @elseif($choose == 5)
					                Closed
					            @elseif($choose == 6) 
					                Cancelled
					           
					            @endif