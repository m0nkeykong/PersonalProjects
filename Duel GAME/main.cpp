// MADE BY TAL CHAUSHU AND HAIM ELBAZ


#include <iostream>
#include <fstream>
#include <string>
#include "Game_Manager.h"
using namespace std;

#pragma once

int main(int argc, char *argv[])
{

	

	//initial buffer
	char* buff = new char[512];
	if (buff == 0) { cerr << "error allocating memory for buffer" << endl; exit(1); };

	//opening all the working files (input, output).

	GameManager gm(argv[1], argv[2], argv[3]);
	ifstream if_simulation(argv[2]);
	ofstream of_gameOn(argv[3]);

	//user interface
	int choice = 0;


	cout << endl << "If you'll comeback later, that'll be the end of it." << endl << "I will not look for you, I will not pursue you." << endl << "But if you don't, I will look for you," << endl << "I will find you," << endl << "And I will kill you." << endl << endl;
	cout << endl << endl << endl << "MADE BY TAL CHAUSHU AND HAIM ELBAZ" << endl;





	return 0;
}
