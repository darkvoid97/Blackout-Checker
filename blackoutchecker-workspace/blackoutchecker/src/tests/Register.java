package tests;
import java.io.IOException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.io.PrintWriter;
//import jakarta.servlet.RequestDispatcher;
//import jakarta.servlet.ServletContext;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.xml.bind.DatatypeConverter;
//import jakarta.servlet.http.HttpSession;
import java.sql.*;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

/**
 * Servlet implementation class Register
 */
@WebServlet("/Register")
public class Register extends HttpServlet {
	private static final long serialVersionUID = 1L;

    /**
     * Default constructor.
     */
    public Register() {
        // TODO Auto-generated constructor stub
    }
	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */

    public int TryToRegister(Connection con, String nome, String cognome, String genere, String username, String password, String codice, boolean error, HttpServletRequest request, HttpServletResponse response) throws SQLException, ServletException, IOException, NoSuchAlgorithmException
    {
    	int valid = -2;
    	error = false;

    	//controllo se l'username inserito esiste gi�
		PreparedStatement checkUsername = con.prepareStatement("select username from users where username = ?");
		checkUsername.setString(1, username);
		ResultSet rs_user = checkUsername.executeQuery();

		if(rs_user.next())
		{
			error = true;
			valid = 4;
			//request.setAttribute("alert", 4);
			//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
		}

		//controllo se il codice inserito esiste gi�
		PreparedStatement checkCode = con.prepareStatement("select codice from users where codice = ?");
		checkCode.setString(1, codice);
		ResultSet rs_code = checkCode.executeQuery();

		if(rs_code.next())
		{
			error = true;
			valid = 6;
			//request.setAttribute("alert", 6);
			//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
		}

        if (codice.length() < 10)
    	{
        	error = true;
        	valid = -1;
    		//request.setAttribute("alert", -1);
    		//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
    	}

    	if (nome == "" || cognome == "" || genere == "" || username == "" || password == "" || codice == "")
    	{
    		error = true;
    		valid = 0;
    		//request.setAttribute("alert", 0);
    		//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
    	}

    	Pattern pattern = Pattern.compile("[a-zA-Z0-9]*");
    	Matcher matcher_nome = pattern.matcher(nome);
    	Matcher matcher_cognome = pattern.matcher(cognome);
    	Matcher matcher_username = pattern.matcher(username);
    	Matcher matcher_password = pattern.matcher(password);

    	if (!matcher_nome.matches() || !matcher_cognome.matches() || !matcher_username.matches() || !matcher_password.matches())
    	{
    		error = true;
    		valid = 1;
    		//request.setAttribute("alert", 1);
    		//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
    	}

    	if (password.length() < 8)
    	{
    		error = true;
    		valid = 2;
    		//request.setAttribute("alert", 2);
    		//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
    	}

    	if (username.length() < 3)
    	{
    		error = true;
    		valid = 3;
    		//request.setAttribute("alert", 3);
    		//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
    	}

    	if (genere.charAt(0) != 'F' && genere.charAt(0) != 'M' && genere.charAt(0) != 'N')
    	{
    		error = true;
    		valid = 5;
    		//request.setAttribute("alert", 5);
    		//request.setAttribute("url", 0);
        	//request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
    	}

    	else
    	{
    		error = false;
    		valid = 7;
    	}

    	return valid;
    }
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException
	{
		response.setContentType("application/json;charset=UTF-8");
		PrintWriter out = response.getWriter();

		String nome = request.getParameter("nome");
		String cognome = request.getParameter("cognome");
		String genere = request.getParameter("genere");
		String username = request.getParameter("username");
		String password = request.getParameter("password");
		String codice = request.getParameter("codice");
		out.println(nome+" "+cognome+" "+genere+" "+username+" "+password+" "+codice);
		try
		{
			boolean error = false;
			Class.forName("com.mysql.cj.jdbc.Driver");
			Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");

		    TryToRegister(con, nome, cognome, genere, username, password, codice, error, request, response);

        	if (error == false)
        	{
        		MessageDigest md = MessageDigest.getInstance("MD5");
        		md.update(password.getBytes());
        		byte[] digest = md.digest();
        		String passhash = DatatypeConverter.printHexBinary(digest);
        		PreparedStatement ps = con.prepareStatement("insert into users values(?,?,?,?,?,?)");
    			ps.setString(1, nome);
                ps.setString(2, cognome);
                ps.setString(3, username);
                ps.setString(4, passhash);
                ps.setString(5, codice);
                ps.setString(6, genere);
        		int i = ps.executeUpdate();
        		if(i > 0)
        		{
        			request.setAttribute("alert", 7);
        			request.setAttribute("url", 1);
                	request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
        		}
        	}
		}
		catch(Exception se)
		{
			se.printStackTrace();
			out.println("Unable to connect to the database!");
		}
	}

}
