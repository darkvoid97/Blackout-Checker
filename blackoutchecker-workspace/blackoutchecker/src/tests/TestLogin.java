package tests;

import jakarta.servlet.*;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import static org.junit.Assert.assertTrue;

import java.io.*;
import java.security.NoSuchAlgorithmException;
import java.util.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import org.junit.*;

public class TestLogin
{
	int valid = -1;
	String username;
	String password;
	String passhash = null;
	boolean error = false;
	HttpServletRequest request;
	HttpServletResponse response;

	Connection con;

	Scanner scan = new Scanner(System.in);
	Login loginServlet = new Login();

    @Before
    public void setUp() throws SQLException, ClassNotFoundException {
    	System.out.println("The following verifies the correct assesment");
    	System.out.println("(and the sending to the user) of the several login errors.");
    	System.out.println("Input the username: ");
    	username = scan.nextLine();
    	System.out.println("Input the password: ");
    	password = scan.nextLine();

    	Class.forName("com.mysql.cj.jdbc.Driver");
		con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");
    }

    @Test
    public void correctLogin() throws ServletException, IOException, NoSuchAlgorithmException, SQLException {

        valid = loginServlet.TryToLog(con, username, password, passhash, error, request, response);

        switch(valid) {
   		case 0: System.out.println("AlertMessage: 0; ERROR! You must fill every field to proceed!");
   			break;
   		case 1: System.out.println("AlertMessage: 1; ERROR! Input password must be at least 8 characters long");
				break;
   		case 2: System.out.println("AlertMessage: 2; SUCCESSFULLY LOGGED IN.");
				break;
   		case 3: System.out.println("AlertMessage: 3; ERROR! Input password is incorrect!");
				break;
   		case 4: System.out.println("AlertMessage: 4; ERROR! Input username doesn't exist!");
				break;
   		case 6: System.out.println("AlertMessage: 6; ERROR! You can not use special characters!");
			break;
        }

        assertTrue(valid == 2);
   }
}
