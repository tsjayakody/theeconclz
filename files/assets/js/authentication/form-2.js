var togglePassword = document.getElementById("toggle-password");
// var togglePassword1 = document.getElementById("toggle-password1");
var formContent = document.getElementsByClassName('form-content')[0]; 
var getFormContentHeight = formContent.clientHeight;

var formImage = document.getElementsByClassName('form-image')[0];
if (formImage) {
	var setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
}
if (togglePassword) {
	togglePassword.addEventListener('click', function() {
	  var x = document.getElementById("password");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	});
}

// if (togglePassword1) {
// 	togglePassword1.addEventListener('click', function() {
// 	  var x = document.getElementById("password_retype");
// 	  if (x.type === "password") {
// 	    x.type = "text";
// 	  } else {
// 	    x.type = "password";
// 	  }
// 	});
// }