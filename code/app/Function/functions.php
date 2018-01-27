<?php
/*
* Phân quyền bình luận
*/
function findTicket($team_id, $auth_id, $auth_level, $auth_team_id, $create, $assign) {
	if ($team_id == 1) {
		if($auth_id == $create || $auth_id == $assign || $auth_level == 0 ) {
			return 1;
		}
		return 0;
	}
	else {
		if ($auth_id == $create || $auth_id == $assign || ($auth_level = 0 && $auth_team_id == 2) || ($auth_level = 1 && $auth_team_id == 2)) {
			return 1;
		}
		return 0;
	}
	return 100;
}
// function changeBPIT($team_id, $auth_level, $auth_team_id) {
// 	if ($team_id == 1) {
// 		if ($auth_level == 0) {
// 			return 1;
// 		}
// 		return 0;
// 	}
// 	else {
// 		if (($auth_level == 1 && $auth_team_id == 2) || ($auth_level == 0 && $auth_team_id == 2)) {
// 			return 1;
// 		}
// 		return 0;
// 	}
// }
function change($team_id, $auth_level, $auth_team_id, $status) {
	if ($status == 3 || $status == 5 || $status == 6) {
		return 0;
	}
	else {
		if ($team_id == 1) {
			if ($auth_level == 0) {
				return 1;
			}
			return 0;
		}
		else {
			if (($auth_level == 1 && $auth_team_id == 2) || ($auth_level == 0 && $auth_team_id == 2)) {
				return 1;
			}
			return 0;
		}
	}
	return 100;
}
function changeNLQ($team_id, $auth_id, $auth_level, $auth_team_id, $create_by, $status) {
	if ($status == 3 || $status == 5 || $status == 6) {
		return 0;
	}
	else if ($auth_id == $create_by) {
		return 1;
	}
	else {
		if ($team_id == 1 ) {
			if ($auth_level == 0) {
				return 1;
			}
			return 0;
		}
		else {
			if (($auth_level == 1 && $auth_team_id == 2) || ($auth_level == 0 && $auth_team_id == 2)) {
				return 1;
			}
			return 0;
		}
	}
	return 100;
}
/*
*Phân quyền thay đổi trạng thái
*/
function changeTT($team_id, $auth_id, $auth_level, $auth_team_id, $create_by, $assign_to, $status) {
	$a = 100;
	$b = 200;
	$c = 300;
	if ($status == 5 || $status == 6) {
		$a = 0;
		
	}
	else if (($auth_id == $assign_to && $status ==1) || ($auth_id == $assign_to && $status ==1) || ($auth_level == 0 && $status == 1) || ($auth_level == 0 && $status == 4) || ($auth_level == 1 && $status == 1) || ($auth_level == 1 && $status == 4)) {
		$a = 2;
		
	}
	else if ($status == 2 && ($auth_id == $assign_to || $auth_level == 0 || ($auth_level == 1 && $auth_team_id == 2))) {
		$a = 3;
		
	}
	else if ($status == 3 && ($auth_id == $create_by || $auth_level == 0 || ($auth_level == 1 && $auth_team_id == 2))) {
		$a = 4;
		
	}
	if (($auth_id == $create_by && $status < 5) || ($auth_level == 0 && $auth_team_id == 2 && $status < 5)) {
		$c = 6;
	}
	if(($auth_id == $create_by && $status == 4) || ($auth_level == 0 && $auth_team_id == 2 && $status == 3) || ($auth_level == 0 && $auth_team_id == 2 && $status == 4)) {
		$b = 5;
	}
	return array($a,$b, $c);
}
/*
*Disable button thay đổi trạng thái khi stastus = resolved và người đăng nhập là người thực hiên
*/
function noRe($auth_id, $assign_to, $status) {
	if($auth_id == $assign_to && $status == 3) {
		return 0;
	}
	return 100;
}
/*
*Disable button thay đổi trạng thái khi không phải người tạo, người thực hiện công việc, người có quyền team và người có quyền công ty
*/
function changeBPIT($team_id, $auth_id, $auth_level, $auth_team_id, $create_by, $assign_to) {
	if (!(($auth_id == $create_by) || ($auth_id == $assign_to) ||  ($auth_level == 0 && $auth_team_id == 1 && $team_id == 1) || ($auth_level == 0 && $auth_team_id == 2) || ($auth_level == 1 && $auth_team_id == 2 && $team_id ==2 ))) {
		return 0;
	}
	return 100;
}
?>