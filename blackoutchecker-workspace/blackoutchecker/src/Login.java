import java.awt.Window;
import java.io.*;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import com.google.gson.Gson;
//import java.lang.*;
import jakarta.json.Json;
import jakarta.json.JsonArray;
import jakarta.json.JsonArrayBuilder;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.Cookie;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.xml.bind.DatatypeConverter;
import java.sql.*;
import java.security.MessageDigest;

/**
 * Servlet implementation class Login
 */
@SuppressWarnings("unused")
@WebServlet("/Login")
public class Login extends HttpServlet {
	private static final long serialVersionUID = 1L;

	String codiceAdmin = "Arrq37X0s1";

    /**
     * Default constructor.
     */
    public Login() {
        // TODO Auto-generated constructor stub
    }
	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException
	{
    	String numero_righe = request.getParameter("nrighe");
    	int n;

    	if (numero_righe.matches("[0-9]+"))
    	{
    		n = Integer.parseInt(numero_righe);
    	}

    	else
    	{
    		n = 0;
    	}
    		request.setAttribute("filter", 0);
    		request.setAttribute("nrighe", n);
    		request.getRequestDispatcher("filter.jsp").forward(request, response);
    }

	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException
	{
		@SuppressWarnings("unused")
		List <Blackout> result = new ArrayList<Blackout>();

		String nome = null;
		String genere = null;
		String codice = null;

		response.setContentType("application/json;charset=UTF-8");
		PrintWriter out = response.getWriter();

		String username = request.getParameter("username");
		String password = request.getParameter("password");

		try
		{
			boolean error = false;
			Cookie ck = new Cookie("cookie", username);
			ck.setMaxAge(0);

			Class.forName("com.mysql.cj.jdbc.Driver");
			Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");

			PreparedStatement checkUsername = con.prepareStatement("select username from users where username = ?");
			checkUsername.setString(1, username);
			ResultSet rs_user = checkUsername.executeQuery();

			if(!(rs_user.next()))
			{
				error = true;
				request.setAttribute("alert", 4);
				request.setAttribute("url", 1);
            	request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
			}
			else
			{
				PreparedStatement checkPass = con.prepareStatement("select password from users where username = ?");
				checkPass.setString(1, username);
				ResultSet rs_pass = checkPass.executeQuery();
				if (rs_pass.next())
				{
					String userPass = rs_pass.getString(1);
					MessageDigest md = MessageDigest.getInstance("MD5");
					md.update(password.getBytes());
					byte[] digest = md.digest();
					String passhash = DatatypeConverter.printHexBinary(digest).toUpperCase();
					if (!(userPass.equals(passhash)))
					{
						error = true;
						request.setAttribute("alert", 3);
						request.setAttribute("url", 1);
						request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
						return;
					}
				}
			}

        	if (username == "" || password == "")
        	{
        		error = true;
        		request.setAttribute("alert", 0);
        		request.setAttribute("url", 1);
            	request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
        	}

        	Pattern pattern = Pattern.compile("[a-zA-Z0-9]*");
        	Matcher matcher_username = pattern.matcher(username);
        	Matcher matcher_password = pattern.matcher(password);

        	if (!matcher_username.matches() || !matcher_password.matches())
        	{
        		error = true;
        		request.setAttribute("alert", 6);
        		request.setAttribute("url", 1);
            	request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
        	}

        	if (password.length() < 8)
        	{
        		error = true;
        		request.setAttribute("alert", 1);
        		request.setAttribute("url", 1);
            	request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
        	}

        	if (error == false)
        	{
        		PreparedStatement checkUser = con.prepareStatement("select * from users where username = ?");
        		checkUser.setString(1, username);
    			ResultSet rs_code = checkUser.executeQuery();

    			if(rs_code.next())
    			{
    				result = new ArrayList<Blackout>();
    				PreparedStatement ps_blackouts;

    				nome = rs_code.getString(1);
    				codice = rs_code.getString(5);
    				genere = rs_code.getString(6);

    				if(codice.equals(codiceAdmin))
    				{
    					ps_blackouts = con.prepareStatement("select * from blackouts order by data desc");
    				}

    				else
    				{
    					ps_blackouts = con.prepareStatement("select * from blackouts where codice = ? order by data desc");
        				ps_blackouts.setString(1, codice);
    				}

    				ResultSet rs_blackouts = ps_blackouts.executeQuery();

       				while (rs_blackouts.next())
    				{
    					String code = rs_blackouts.getString(1);
    					Timestamp data = rs_blackouts.getTimestamp(2);
    					String tempo = rs_blackouts.getString(3);
    					String caso = rs_blackouts.getString(4);
    					int tentativi = rs_blackouts.getInt(5);
    					int id_entry = rs_blackouts.getInt(6);

    					Blackout blackout = new Blackout();

    					blackout.setCodice(code);
    					blackout.setDate(data);
    					blackout.setTime(tempo);
    					blackout.setCase(caso);
    					blackout.setTries(tentativi);
    					blackout.setIdEntry(id_entry);

    					result.add(blackout);
    				}

    			}

    			String json = new Gson().toJson(result);

        		ck.setMaxAge(3600);
        		response.addCookie(ck);

        		request.setAttribute("url", 1);
        		request.setAttribute("alert", 2);
        		request.setAttribute("codice", codice);
        		request.setAttribute("username", username);
        		request.setAttribute("password", password);
        		request.setAttribute("nome", nome);
        		request.setAttribute("genere", genere);
        		request.setAttribute("blackouts", json);
                request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
        	}
		}
		catch(Exception se)
		{
			se.printStackTrace();
			out.println("Unable to connect to the database!");
		}
	}

}
