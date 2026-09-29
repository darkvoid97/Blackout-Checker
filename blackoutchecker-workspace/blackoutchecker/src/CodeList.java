import java.io.IOException;
//import java.io.PrintWriter;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import java.sql.*;

/**
 * Servlet implementation class CodeList
 */
@WebServlet("/CodeList")
public class CodeList extends HttpServlet
{
	private static final long serialVersionUID = 1L;

    /**
     * Default constructor.
     */
    public CodeList()
    {
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException
	{
		String code = request.getParameter("code");
		if (code == "")
			code = "all";
		else
		{
			try
			{
				Class.forName("com.mysql.cj.jdbc.Driver");
				Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");
				PreparedStatement checkCode = con.prepareStatement("select codice from blackouts where codice = ?");
				checkCode.setString(1, code);
				ResultSet rs_code = checkCode.executeQuery();
				if(!(rs_code.next()))
					code = "all";
			}
			catch (Exception se)
			{
				code = "all";
			}
		}
		request.setAttribute("filter", 1);
		request.setAttribute("code", code);
		request.getRequestDispatcher("filter.jsp").forward(request, response);
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException
	{
		String id = request.getParameter("identry");
		String time = request.getParameter("time");
		String caso = request.getParameter("case");
		String tries = request.getParameter("tries");
		String date = request.getParameter("date");
		String code = request.getParameter("code");
		int alert, url = 2;

		//If IDEntry is empty, then a new Blackout is being added
		if (id == "")
		{
			//Error if one of the fields is empty
			if (time == "" || caso == "" || tries == "" || code == "")
			{
				alert = 0;
			}
			else
			{
				try
				{
					Class.forName("com.mysql.cj.jdbc.Driver");
					Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");
					PreparedStatement checkCode = con.prepareStatement("select codice from users where codice = ?");
					checkCode.setString(1, code);
					ResultSet rs_code = checkCode.executeQuery();
					if (!(rs_code.next()))
					{
						alert = 1;
					}
					else
					{
						PreparedStatement createBlackout = con.prepareStatement("insert into blackouts values (?, ?, ?, ?, ?, NULL)");
						createBlackout.setString(1, code);
						createBlackout.setString(2, date);
						createBlackout.setString(3, time);
						createBlackout.setString(4, caso);
						createBlackout.setString(5, tries);
						createBlackout.executeUpdate();
						createBlackout.close();
						alert = 3;
					}
				}
				catch(Exception e)
				{
					alert = 4;
					System.out.println("Caught error while trying to insert a new Blackout.");
				}
			}
		}
		//If IDEntry isn't empty, an existant Blackout is being modified or deleted
		else
		{
			try
			{
				Class.forName("com.mysql.cj.jdbc.Driver");
				Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");
				PreparedStatement checkId = con.prepareStatement("select id_entry from blackouts where id_entry = ?");
				checkId.setString(1, id);
				ResultSet rs_id = checkId.executeQuery();
				if (!(rs_id.next()))
				{
					alert = 5;
				}
				else
				{
					//If every field is empty, the specified Blackout is being deleted
					if (time == "" && caso == "" && tries == "" && code == "")
					{
						PreparedStatement deleteBlackout = con.prepareStatement("delete from blackouts where id_entry = ?");
						deleteBlackout.setString(1, id);
						deleteBlackout.executeUpdate();
						deleteBlackout.close();
						alert = 6;
					}
					else
					{
						String query = buildQuery(time, caso, tries, code);
						PreparedStatement updateBlackout = con.prepareStatement("update blackouts set " + query + " where id_entry = ?");
						updateBlackout.setString(1, id);
						updateBlackout.executeUpdate();
						updateBlackout.close();
						alert = 7;
					}
				}
			}
			catch(Exception e)
			{
				alert = 8;
				System.out.println("Caught error while trying to modify/delete a Blackout.");
			}
		}
		request.setAttribute("alert", alert);
		request.setAttribute("url", url);
    	request.getRequestDispatcher("generateAlert.jsp").forward(request, response);
	}

	protected String buildQuery(String time, String caso, String tries, String code)
	{
		String tm, cs, tr, cd, query="";
		tm = "tempo = " + "\"" + time + "\"";
		cs = "caso = " + "\"" + caso + "\"";
		tr = "tentativi = " + tries;
		cd = "codice = " + "\"" + code + "\"";
		if (code != "")
		{
			if (time != "")
				query = query + tm + ", ";
			if (caso != "")
				query = query + cs + ", ";
			if (tries != "")
				query = query + tr + ", ";
			query = query + cd;
		}
		else if (tries != "")
		{
			if (time != "")
				query = query + tm + ", ";
			if (caso != "")
				query = query + cs + ", ";
			query = query + tr;
		}
		else if (caso != "")
		{
			if (time != "")
				query = query + tm + ", ";
			query = query + cs;
		}
		else if (time != "")
			query = query + tm;
		return query;
	}
}
