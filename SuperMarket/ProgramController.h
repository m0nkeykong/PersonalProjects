#ifndef PROGRAMCONTROLLER_H
#define PROGRAMCONTROLLER_H

#include <string>
#include <fstream>
#include <iostream>
#include "CommandLineUI.h"

using namespace std;



class ProgramController
{
private:

public:
	ProgramController();
	
	bool executeCommand(ICommand command) {};
	ICommand parseCommand(string commandsyntax) {};

	
	
	~ProgramController();
};

#endif