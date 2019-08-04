function validateUser(user)
{
	user = user.trim();
	if (user !== '')
	{
		if (user.length < 8)
		{
			showError('userError', 'Username must contain at least 8 characters', 'user');
			return false;		
		}
		else
		{
			hideError('userError', 'user');
			var regex_test = /^[a-zA-Z0-9]+$/.test(user);
			if (!regex_test)
			{
				showError('userError', 'Only alphanumeric characters are allowed', 'user');
				return false;
			}
			else
			{
				hideError('userError', 'user');
				user = user.toLowerCase();
				var exists = registeredUser(user);
				if (exists)
				{
					showError('userError', 'Username is already taken', 'user');
					return false;		
				}
				else
				{
					hideError('userError', 'user');
					textboxBorder('user', '#2CA1CC');
					return true;
				}
			}
		}
	}
	else
	{
		hideError('userError', 'user');
		return false;
	}
}

function validateEmail(email)
{
	email = email.trim();
	if (email !== '')
	{
		var regex_test = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
		if (!regex_test)
		{
			showError('emailError', 'Invalid email address format', 'email');
			return false;
		}
		else
		{
			hideError('emailError', 'email');
			email = email.toLowerCase();
			var exists = registeredEmail(email);
			if (exists)
			{
				showError('emailError', 'This email is already registered', 'email');
				return false;
			}
			else
			{
				hideError('emailError', 'email');
				textboxBorder('email', '#2CA1CC');
				return true;
			}
		}
	}
	else
	{
		hideError('emailError', 'email');
		return false;
	}
}

function validatePassword(pass)
{
	if (pass !== '')
	{
		if (pass.length < 8)
		{
			showError('passwordError', 'Password must contain at least 8 characters', 'pass');
			return false;
		}
		else
		{
			hideError('passwordError', 'pass');
			var regex_test = /^[a-zA-Z0-9]+$/.test(pass);
			if (!regex_test)
			{
				showError('passwordError', 'Only alphanumeric characters are allowed', 'pass');
				return false;
			}
			else
			{
				hideError('passwordError', 'pass');
				textboxBorder('pass', '#2CA1CC');
				return true;
			}
		}
	}
	else
	{
		hideError('passwordError', 'pass');
		return false;
	}
}

function validatePasswords(pass, pass2)
{
	if (pass2 !== '')
	{
		if (pass !== pass2)
		{
			showError('passwordsError', 'Your password must match the confirmation password', 'pass2');
			return false;
		}
		else
		{
			hideError('passwordsError', 'pass2');
			textboxBorder('pass2', '#2CA1CC');
			return true;
		}
	}
	else
	{
		hideError('passwordsError', 'pass2');
		return false;
	}
}

function validateGDPR(gdpr)
{
	if (!gdpr)
	{
		showError('GDPRError', 'Acceptance of the GDPR agreement is required', 'GDPR');
		return false;
	}
	else
	{
		hideError('GDPRError', 'GDPR');
		return true;
	}
}

function showError(field, msg, text)
{
	var obj = document.getElementById(field);
	obj.innerHTML = msg;
	textboxBorder(text, 'yellowgreen');
    if (obj.style.visibility == 'hidden')
	{
    	obj.style.visibility = 'visible';
    }
}

function hideError(field, text)
{
	var obj = document.getElementById(field);
	obj.innerHTML = '';
	textboxBorder(text, 'white');
    if (obj.style.visibility == 'visible')
	{
    	obj.style.visibility = 'hidden';
    }
}

function textboxBorder(text, color)
{
	var obj = document.getElementById(text);
	obj.style.border = '1px solid ' + color;
}

function registeredUser(user)
{
	try
	{
		var status = null;
       	$.ajax
		({
			data: {user : user},
			url:   "scripts/validateUser.php",
			type:  "GET",
			async: false, 
           	success: function(ans)
			{
				status = ans;
           	}
       	});
		return status;
	}
	catch (e){}
}

function registeredEmail(email)
{
	try
	{
		var status = null;
       	$.ajax
		({
			data: {email : email},
			url:   "scripts/validateEmail.php",
			type:  "GET",
			async: false, 
           	success: function(ans)
			{
				status = ans;
           	}
       	});
		return status;
	}
	catch (e){}
}

function createUser(user, email, pass, pass2)
{
	try
	{
		var code = null;
       	$.ajax
		({
			data: {uName : user, uEmail : email, uPass : pass, uPass2 :  pass2},
			url:   "scripts/registration.php",
			type:  "POST",
			async: false, 
           	success: function(ans)
			{
				code = ans;
           	}
       	});
		return code;
	}
	catch (e){return 0;}
}

function validateForm(user, email, pass, pass2, gdpr)
{
	hideError('GDPRError', 'GDPR');
	if (user !== '')
	{
		var user_valid = validateUser(user);
		if (user_valid)
		{
			if (email !== '')
			{
				var email_valid = validateEmail(email);
				if (email_valid)
				{
					if (pass !== '')
					{
						var pass_valid = validatePassword(pass);
						if (pass_valid)
						{
							if (pass2 !== '')
							{
								var pass2_valid = validatePasswords(pass, pass2);
								if (pass2_valid)
								{
									var gdpr_valid = validateGDPR(gdpr);
									if (gdpr_valid)
									{
										return true;
									}
									else
									{
										return false;	
									}
								}
								else
								{
									return false;
								}
							}
							else
							{
								showError('passwordsError', 'The password confirmation is required', 'pass2');
								return false;
							}
						}
						else
						{
							return false;
						}
					}
					else
					{
						showError('passwordError', 'The password is required', 'pass');
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				showError('emailError', 'The email address is required', 'email');
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		showError('userError', 'The username is required', 'user');
		return false;
	}
}

function register()
{
	var user = document.getElementById('user').value;
	var email = document.getElementById('email').value;
	var pass = document.getElementById('pass').value;
	var pass2 = document.getElementById('pass2').value;
	var gdpr = document.getElementById("GDPR").checked;
	var form_valid = validateForm(user, email, pass, pass2, gdpr);
	if (form_valid)
	{
		var code = createUser(user, email, pass, pass2);
		window.location.href = "main.html?code="+code;
	}
}

function showMessage()
{
	var code = getCode();
	var msg = getMessage(code);
	document.getElementById('code-msg').innerHTML = msg;
}
	
function getCode()
{
	var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++)
	{
        var pair = vars[i].split("=");
    	if(pair[0] == "code"){return pair[1];}
    }
	return(false);
}
	
function getMessage(code)
{
	var msg = "";
	switch (code)
	{
		case "1":
			msg = "<b>Error:</b> username is too short";
			break;
		case "2":
			msg = "<b>Error:</b> password is too short";
			break;
		case "3":
			msg = "<b>Error:</b> password and verification are different";
			break;
		case "4":
			msg = "<b>Error:</b> username is already taken";
			break;
		case "5":
			msg = "<b>Error:</b> invalid email address format";
			break;
		case "6":
			msg = "<b>Error:</b> email address already registered";
			break;
		case "7":
			msg = "<b>Success:</b> activation email has been sent";
			break;
		case "0":
			msg = "<b>Error:</b> Unknown error";
			break;
		default:
			msg = "• • • • • • •";
			break;
	}
	if (code.length > 2)
	{
		msg = code;
	}
	return msg;
}

function login()
{
	var user = document.getElementById('user').value;
	var pass = document.getElementById('pass').value;
	user = user.toLowerCase();
	user = user.trim();
	var form_valid = validateLogin(user, pass);
	if (form_valid)
	{
		try
		{
			var status = null;
			$.ajax
			({
				data: {user : user, pass : pass},
				url:   "scripts/validateCred.php",
				type:  "GET",
				async: false, 
				success: function(ans)
				{
					status = ans;
				}
			});
			if (status)
			{
				window.location.href = "index.php";
			}
			else
			{
				showError('userError', 'Invalid credentials for user ' + user, 'user');
				
			}
		}
		catch (e){}
		}
}

function validateLogin(user, pass)
{
	hideError('userError', 'user');
	hideError('passwordError', 'pass');
	if (user === '')
	{
		showError('userError', 'The username is required', 'user');
		return false;
	}
	else
	{
		if (pass === '')
		{
			showError('passwordError', 'The password is required', 'pass');
			return false;
		}
		else
		{
			return true;
		}
	}
}

function logout()
{
	try
	{
		var status = null;
		$.ajax
		({
			url:   "scripts/logout.php",
			type:  "GET",
			async: false, 
			success: function(ans)
			{
				status = ans;
			}
		});
		if (status)
		{
			window.location.href = "main.html";
		}
		else
		{
			alert("An unexpected error has occurred. Please try again and if the problem persists close the browser to destroy the current sesion.");	
		}
	}
	catch (e){}
}

function deleteAccount()
{
	var txt;
	var status = null;
	var email = prompt("WARNING: This action cannot be undone. To continue, please enter the email address you used during registration or press cancel to abort the operation:", "");
	if ((email == null) || (email == ""))
	{
		txt = "The deletion of the account has been canceled";
	}
	else
	{
		email = email.replace(/\s+/g, '');
		email = email.toLowerCase();
		var regex_test = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
		if (!regex_test)
		{
			txt = "The provided email does not meet the expected format";
		}
		else
		{
			var status = null;
			try
			{
				$.ajax
				({
					url:   "scripts/getEmail.php",
					type:  "GET",
					async: false, 
					success: function(ans)
					{
						status = ans;
					}
				});
			} catch (e) {}
			if ((status == "403") || (status == null) || (status == ""))
			{
				txt = "Error during the email validation. Please, contact the system admin. "+status;
			}
			else
			{
				if (email != status)
				{
					txt = "Incorrect email address provided";
				}
				else
				{
					try
					{
						$.ajax
						({
							url:   "scripts/deleteAccount.php",
							type:  "GET",
							async: false, 
							success: function(ans)
							{
								status = ans;
							}
						});
					} catch (e) {}
					if (status == "true")
					{
						window.location.replace("main.html");
					}
					else
					{
						txt = "Unknown error. Please, contact the system admin";
					}
				}
			}
		}
	}
	document.getElementById("status").innerHTML = txt;
}

function loginAid(e)
{
	if (e.keyCode == 13)
	{	
		var user = document.getElementById('user').value;
		var pass = document.getElementById('pass').value;
		user = user.toLowerCase();
		user = user.trim();
		var form_valid = validateLogin(user, pass);
		if (form_valid)
		{
			try
			{
				var status = null;
				$.ajax
				({
					data: {user : user, pass : pass},
					url:   "scripts/validateCred.php",
					type:  "GET",
					async: false, 
					success: function(ans)
					{
						status = ans;
					}
				});
				if (status)
				{
					window.location.href = "index.php";
				}
				else
				{
					showError('userError', 'Invalid credentials for user ' + user, 'user');
				}
			}
			catch (e){}
		}	
	}
}