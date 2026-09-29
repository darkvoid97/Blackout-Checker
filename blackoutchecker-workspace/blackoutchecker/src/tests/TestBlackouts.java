package tests;
import java.sql.*;

public class TestBlackouts
{
	public static void main(String args[])
	{
		try
		{
			Class.forName("com.mysql.cj.jdbc.Driver");
			Connection con=DriverManager.getConnection("jdbc:mysql://localhost:3306/blackout checker","root","");
			Statement stmt=con.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE, ResultSet.CONCUR_READ_ONLY);
			ResultSet rs=stmt.executeQuery("SELECT * from blackouts");
			System.out.println("Blackouts currently present in the Database:\n");
			int count = 0;
			while(rs.next())
				++count;
			final Object[][] tabella = new String[count+1][];
			count = 0;
			rs.beforeFirst();
			if (rs.isBeforeFirst())
			{
				while(rs.next())
				{
					count++;
					tabella[count] = new String[] {rs.getString(6), rs.getString(1), rs.getString(2), rs.getString(3), rs.getString(4), rs.getString(5)};
				}
				tabella[0] = new String[] {"ID Entry", "Codice", "Data e Ora", "Tempo", "Caso", "Tentativi"};
				System.out.println("------------------------------------------------------------------------------------------------------------------------------");
				for (final Object[] riga : tabella)
				{
					System.out.format("| %-8s | %-15s | %-20s | %-40s | %-15s | %-9s |\n", riga);
					System.out.println("------------------------------------------------------------------------------------------------------------------------------");
				}
			}
			con.close();
		}
		catch(Exception e)
		{System.out.println("Caught error while trying to test: "+e);}
	}
}
