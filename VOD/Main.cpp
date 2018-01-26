///////////////////////////////////////////////Haim Elbaz & Omri Leo Finkelstein///////////////////////////////////////////////////////////
#include <iostream>
#include <string>
#include "SimulationService.h"
using namespace std;

int main() 
{

	SimulationService s;
	s.loadData();
	s.executeSimulation();
	system("pause");
	
	return 0;
}