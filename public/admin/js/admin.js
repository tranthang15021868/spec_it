$("div.alert").delay(5000).slideUp();
function xacNhanXoa(msg) {
	if(window.confirm(msg)) {
		return true;
	}
	return false;
};