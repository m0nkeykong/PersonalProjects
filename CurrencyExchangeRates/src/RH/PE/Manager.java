package RH.PE;

import java.io.IOException;

public class Manager implements Runnable {

	private View software;
	@Override
	public void run() {
		try {
			software = new View();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

}
