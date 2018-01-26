#ifndef COMMANDLINEUI_H
#define COMMANDLINEUI_H



#include <string>
#include <fstream>
#include <iostream>
#include "ICommand.h"

using namespace std;



class CommandLineUI
{
private:
	string input;
public:
	CommandLineUI() : input(0) {};

	string getInput() { cout << "enter command:\n"; cin >> input; };						//get input from user

	~CommandLineUI();
};



#endif
