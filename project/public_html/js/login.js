$(document).ready(function(){
$("#login").click(function(){
var email = $("#email").val();
var password = $("#password").val();
// Checking for blank fields.
if( email =='' || password ==''){
$('input[type="text"],input[type="password"]').css("border","2px solid red");
$('input[type="text"],input[type="password"]').css("box-shadow","0 0 3px red");
alert("Please fill all fields...!!!!!!");
}else {
$.post("../../dataLogin.php",{ inputEmail: email, inputPassword:password},
function(data) {
if(data=='false'){
alert(data);
} else{
alert(data);
}
});
}
});
});