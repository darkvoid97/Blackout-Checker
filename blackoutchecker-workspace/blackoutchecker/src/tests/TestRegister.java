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

public class TestRegister
{
	int valid = -2;
	String nome;
	String cognome;
	String genere;
	String username;
	String password;
	String codice;
	boolean error = false;
	HttpServletRequest request;
	HttpServletResponse response;

	Connection con;

	Scanner scan = new Scanner(System.in);
	Register registerServlet = new Register();

    @Before
    public void setUp() throws SQLException, ClassNotFoundException {
    	System.out.println("The following verifies the correct assesment");
    	System.out.println("(and the sending to the user) of the several sign up errors.");
    	System.out.println("Input your first name: ");
    	nome = scan.nextLine();
    	System.out.println("Input your last name: ");
    	cognome = scan.nextLine();
    	System.out.println("Input your gender: ");
    	genere = scan.nextLine();
    	System.out.println("Input username: ");
    	username = scan.nextLine();
    	System.out.println("Input password: ");
    	password = scan.nextLine();
    	System.out.println("Input the device unique ID: ");
    	codice = scan.nextLine();

    	Class.forName("com.mysql.cj.jdbc.Driver");
		con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");
    }

    @Test
    public void correctRegistration() throws ServletException, IOException, NoSuchAlgorithmException, SQLException {

        valid = registerServlet.TryToRegister(con, nome, cognome, genere, username, password, codice, error, request, response);

        switch(valid) {
        case -1: System.out.println("AlertMessage: -1; ERROR! La lunghezza del codice deve essere di 10 caratteri!");
			break;
   		case 0: System.out.println("AlertMessage: 0; ERROR! You must fill every field to proceed!");
   			break;
   		case 1: System.out.println("AlertMessage: 1; ERROR! You can not use special characters!");
				break;
   		case 2: System.out.println("AlertMessage: 2; ERROR! Input password must be at least 8 characters long!");
				break;
   		case 3: System.out.println("AlertMessage: 3; ERROR! Input username must be at least 3 characters long!");
				break;
   		case 4: System.out.println("AlertMessage: 4; ERROR! Input username is already used!");
				break;
   		case 5: System.out.println("AlertMessage: 5; ERROR! Input gender is not valid! (valid input: M/F/N)");
   				break;
   		case 6: System.out.println("AlertMessage: 6; ERROR! Input unqiue ID is already used!");
			break;
   		case 7: System.out.println("AlertMessage: 7; SUCCESSFULLY SIGNED UP.");
   			break;
        }

        assertTrue(valid == 7);
   }
}
