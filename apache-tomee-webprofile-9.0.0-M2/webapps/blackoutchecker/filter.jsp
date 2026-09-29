<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
<title>generateAlert</title>
</head>
<body><script>
	
	var f = '<%= request.getAttribute("filter") %>';
	var n = '<%= request.getAttribute("nrighe") %>';
	var c = '<%= request.getAttribute("code") %>';

    var redirect = function (url, filter)
    {
		var form = document.createElement("form");
		document.body.appendChild(form);
		form.setAttribute("method", "get");
		form.setAttribute("action", url);
		
		if (filter == 0)
		{
			var input = document.createElement("input");
			input.setAttribute("type", "text");
			input.setAttribute("name", "nrighe");
			input.setAttribute("value", n);
		}
		if (filter == 1)
		{
			var input = document.createElement("input");
			input.setAttribute("type", "text");
			input.setAttribute("name", "code");
			input.setAttribute("value", c);
		}
		
		form.appendChild(input).style.display="none"; //lascialo invisibile
		form.submit();
     }
     
     redirect("http://localhost/homepage.php", f);
     
</script>
</body>
</html>