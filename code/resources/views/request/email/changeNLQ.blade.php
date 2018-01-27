Thay đổi người liên quan của công việc: <br>
Tên công viêc: {{$subject}}<br>
@if(!empty($nlq1))
Thay đổi danh sách người liên quan sang:
	@foreach($nlq1 as $nlq)
		{{$nlq}}
		<?php echo "      " ?>
	@endforeach
@else
	Công việc không có người liên quan<br>
@endif