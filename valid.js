function checkform ( form )
{
	if (form.client_firstname.value == '')		{ alert( "חובה להזין שם פרטי." );			form.client_firstname.focus(); return false ; }
	if (form.client_lastname.value == '')		{ alert( "חובה להזין שם משפחה." );			form.client_lastname.focus(); return false ; }
	
	if (form.client_password.value == '')
 	{ 
		alert( "חובה להזין סיסמא באורך 4 תווים לפחות.." );
		form.client_password.focus(); 
		return false;
	}
	if (form.client_password.value.length < 4)
	{
		alert( "הסיסמא חייבת להכיל לפחות 4 תווים." );
		form.client_password.focus(); 
		return false;
	}
	if (form.client_password2.value != form.client_password.value)
	{
		 alert( "אין תיאום בין הסיסמאות." );
		 form.client_password2.focus(); 
		 return false;
	}
	if (form.client_email.value == '')
	{ 
		alert( "חובה להזין כתובת אימייל." );
		form.client_email.focus();
		return false;
	}	
	var x=form.client_email.value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		  {
		  alert("כתובת האימייל שהזנת אינה חוקית.");
		  return false;
		  }
	if (form.client_city.value == '')
	{ 
		alert( "חובה להזין עיר." );
		form.client_city.focus();
		return false;
	}
	if (form.client_address.value == '')
	{ 
		alert( "חובה להזין מספר רחוב." );
		form.client_address.focus();
		return false;
	}
	if (form.client_bait.value == '')
	{ 
		alert( "חובה להזין מספר בית." );
		form.client_bait.focus();
		return false;
	}
	if (form.client_dira.value == '')
	{ 
		alert( "חובה להזין מספר דירה." );
		form.client_dira.focus();
		return false;
	}
	if ((form.client_phone.value == '') && (form.client_cellphone.value == ''))
	{
		alert( "חובה להזין טלפון או פלאפון" );
		form.client_phone.focus(); 
		return false;
	}
  return true;
}
