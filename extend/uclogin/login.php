<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Test remote Login using JS</title>
<script type="text/javascript">
function prepareLoginForm() {
    $("lt").value = loginTicket;
    $("execution").value = execution;
}
 
function checkForLoginTicket() {
    var loginTicketProvided = false;
    var query   = '',
        casLoginURL = 'http://uc.juke123.my/login',
        thisPageURL = 'http://www.testlogin1.my/login.php',
        serviceURL = 'http://www.testlogin1.my/';
 
    query   = window.location.search;
    query   = query.substr (1);
 
 
    var param   = new Array();
    //var value = new Array();
    var temp    = new Array();
    param   = query.split ('&');
 
    i = 0;
    while (param[i]) {
        temp        = param[i].split ('=');
        if (temp[0] == 'lt') {
            loginTicket = temp[1];
            loginTicketProvided = true;
        }
        if(temp[0] == 'execution'){
        	execution =  temp[1];
        }
        if (temp[0] == 'error_message') {
                error = temp[1];
            }
        i++;
    }
    if (!loginTicketProvided) {
    	location.href = casLoginURL + '?service=' + encodeURIComponent (serviceURL) + '&login-at=' + encodeURIComponent (thisPageURL) + '&get-lt=true';
    }
}
 
function $(id) {
    return document.getElementById(id);
}
var loginTicket;
var execution;
var error;
var casLoginURL;
var thisPageURL;
 
checkForLoginTicket();
onload = prepareLoginForm;
</script>
</head>
<body>
<h2>Test remote Login using JS</h2>
<form id="myLoginForm" action="http://uc.juke123.my/login" method="post">
<input type="hidden" value="submit" name="_eventId"/>
<table>
<tr>
    <td id="txt_error" colspan="2">
 
    <script type="text/javascript" language="javascript">
    <!--
    if ( error ) {
        error = decodeURIComponent (error);
        document.write (error);
    }
    //-->
    </script>
 
    </td>
</tr>
<tr>
    <td>Username:</td>
    <td><input type="text" value="admin" name="username" ></td>
</tr>
<tr>
    <td>Password:</td>
    <td><input type="text" value="123456" name="password" ></td>
</tr>
<tr>
    <td>Login Ticket:</td>
    <td><input type="text" name="lt" id="lt" value=""></td>
    
</tr>

<tr>
    <td>Execution:</td>
    <td><input type="text" name="execution" id="execution" value=""></td>
</tr>

<tr>
    <td align="right" colspan="2"><input name="_eventId" type="submit" value="Login" /></td>
</tr>
</table>
</form>
</body>
</html>