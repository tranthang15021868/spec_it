Nội dung: Thay đổi độ ưu tiên từ  @if($priority == 1) 
                Thấp
            @elseif($priority== 2)
               Bình thường
            @elseif($priority== 3)
                Cao
            @else 
                Khẩn cấp @endif 
            sang @if($choose == 1) 
                Thấp
            @elseif($choose== 2)
                Bình thường
            @elseif($choose== 3)
                Cao
            @else 
                Khẩn cấp @endif <br>
Tên công việc: {{$subject}}<br>
<?php $cmt = str_replace( '<p>', '', $cmt); ?>
<?php $cmt = str_replace( '</p>', '', $cmt); ?>
Lý do: {{$cmt}}
