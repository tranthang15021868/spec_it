Có công việc mới:<br>
Tên công việc: {{$subject}}<br>
<?php $content = str_replace( '<p>', '', $content); ?>
<?php $content = str_replace( '</p>', '', $content); ?>
Nội dụng: {{$content}}<br>
Người tạo: {{$create_by}}<br>
Người thực hiện: {{$ass}}<br>
Deadline: 24h ngày {{$deadline}}<br>
Độ ưu tiên: @if ($priority == 1)
				Thấp
			@elseif ($priority == 2) 
				Bình thường
			@elseif ($priority == 3) 
				Cao
			@elseif ($priority == 4) 
				Khẩn cấp
			@endif
<br>
Người liên quan:<?php for ($i = 0; $i < sizeof($nlq1); $i++) {
						echo $nlq1[$i];
						echo '   ';
					}
				?>
<br>
Bộ phận IT: @if($team_id == 1)
				IT-Hà Nội 
			@elseif($team_id == 2)
				IT-Đà Nẵng
			@endif
<br>