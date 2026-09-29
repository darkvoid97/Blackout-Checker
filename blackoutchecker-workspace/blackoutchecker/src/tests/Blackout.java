package tests;
import java.sql.Timestamp;

public class Blackout {
	Timestamp data;
	String tempo;
	String caso;
	int tentativi;
	String codice;
	int id_entry;
	
	public void setDate(Timestamp _data)
	{
		data = _data;
	}
	
	public void setTime(String _tempo)
	{
		tempo = _tempo;
	}
	
	public void setCase(String _caso)
	{
		caso = _caso;
	}
	
	public void setTries(int _tentativi)
	{
		tentativi = _tentativi;
	}
	
	public void setCodice(String _codice)
	{
		codice= _codice;
	}
	
	public void setIdEntry(int _id_entry)
	{
		id_entry = _id_entry;
	}
	
	public Timestamp getDate()
	{
		return data;
	}
	
	public String getTime()
	{
		return tempo;
	}
	
	public String getCase()
	{
		return caso;
	}
	
	public int getTries()
	{
		return tentativi;
	}
	
	public String getCode()
	{
		return codice;
	}
	
	public int getIdEntry()
	{
		return id_entry;
	}
}