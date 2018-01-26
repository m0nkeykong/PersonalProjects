package RH.PE;

import java.io.IOException;

import javax.swing.JFrame;

public class Execute{
	
	public static void main(String[] args) throws IOException{
		
		Thread execute = new Thread(new Manager(), "executeThread");
		execute.start();
	}
}