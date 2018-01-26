#ifndef SIMULATIONSERVICE_H
#define SIMULATIONSERVICE_H

#include "PlayerService.h"
#include "ClientService.h"
#include <fstream>
#include <ostream>
#include <string>
#include <iostream>

using namespace std;
class SimulationService
{
private: 
	SmartPtr<ClientService> clientServer;
	SmartPtr<PlayerService> playerServer;
public:
	SimulationService();

	void update();															//run the viewable content
	bool loadData();														//initialize the database
	bool executeSimulation();												//initialize the simulation


	~SimulationService();
};

#endif