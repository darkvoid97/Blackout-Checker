<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
<title>generateAlert</title>
</head>
<body><script>

	var urlAtt = '<%= request.getAttribute("url") %>';
	var alertAtt = '<%= request.getAttribute("alert") %>';
	var codice = '<%= request.getAttribute("codice") %>';
	var username = '<%= request.getAttribute("username") %>';
	var password = '<%= request.getAttribute("password") %>';
	var nome = '<%= request.getAttribute("nome") %>';
	var genere = '<%= request.getAttribute("genere") %>';
	var blackouts = '<%= request.getAttribute("blackouts") %>';

    var redirect = function (url)
    {
		var form = document.createElement("form");
		document.body.appendChild(form);
		form.setAttribute("method", "post");
		form.setAttribute("action", url);

		var input = document.createElement("input");
		input.setAttribute("type", "text");
		input.setAttribute("name", "alert_msg");
		input.setAttribute("value", alertAtt);

		form.appendChild(input).style.display="none";

		if (urlAtt == 1 && alertAtt == 2)
		{
		input1 = document.createElement("input");
		input1.setAttribute("type", "text");
		input1.setAttribute("name", "username");
		input1.setAttribute("value", username);

		form.appendChild(input1).style.display="none";

		input2 = document.createElement("input");
		input2.setAttribute("type", "text");
		input2.setAttribute("name", "nome");
		input2.setAttribute("value", nome);

		form.appendChild(input2).style.display="none";

		input3 = document.createElement("input");
		input3.setAttribute("type", "text");
		input3.setAttribute("name", "genere");
		input3.setAttribute("value", genere);

		form.appendChild(input3).style.display="none";

		input4 = document.createElement("input");
		input4.setAttribute("type", "text");
		input4.setAttribute("name", "blackouts");
		input4.setAttribute("value", blackouts);

		form.appendChild(input4).style.display="none";

		input5 = document.createElement("input");
		input5.setAttribute("type", "text");
		input5.setAttribute("name", "codice");
		input5.setAttribute("value", codice);

		form.appendChild(input5).style.display="none";

		input6 = document.createElement("input");
		input6.setAttribute("type", "text");
		input6.setAttribute("name", "password");
		input6.setAttribute("value", password);

		form.appendChild(input6).style.display="none";
		}

		form.submit();
     }

     if (urlAtt == 0)
     	{redirect("http://localhost/registrati.php");}
     else if (urlAtt == 1)
    	 {
    	 	if (alertAtt == 2)
    	 	{redirect("http://localhost/homepage.php");}
    	 	else
    	 	{redirect("http://localhost/accedi.php");}
    	 }
     else if (urlAtt == 2)
    	 {redirect("http://localhost/homepage.php");}

</script>
</body>
</html>
