/**
 * Created by zhangruoqiu on 2017/4/30.
 */
function check(form) {
    if (document.forms.loginForm.email.value == "") {
        alert("Please input username");
        document.forms.loginForm.email.focus();
        return false;
    } else if (document.forms.loginForm.inputPassword.value == "") {
        alert("Please input passwprd");
        document.forms.loginForm.pwd.focus();
        return false;
    }
}
function checkr(form) {
    if (document.forms.loginForm.email.value == "") {
        alert("Please input email");
        document.forms.loginForm.email.focus();
        return false;
    } else if (document.forms.loginForm.inputPassword.value == "") {
        alert("Please input passwprd");
        document.forms.loginForm.pwd.focus();
        return false;
    } else if (document.forms.loginForm.rinputPassword.value != document.forms.loginForm.inputPassword.value){
        alert("Please confirm passwprd");
        document.forms.loginForm.pwd.focus();
        return false;
    } else if (document.forms.loginForm.name.value == "") {
        alert("Please input username");
        document.forms.loginForm.inputName.focus();
        return false;
    }