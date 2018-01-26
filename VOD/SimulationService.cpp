#include "SimulationService.h"
#include <typeinfo>

using namespace std;
SimulationService::SimulationService()
{
}


//run the viewable content and promote content that is during a view - if a client exceeded the run time, remove him from viewing
void SimulationService::update()													
{
	for (int i = 0; i < clientServer->getClients().size(); ++i)
	{ 
		if (clientServer->getClients()[i]->playViewAble())
		{
			if ((clientServer->getClients()[i]->getTimer()) >= (clientServer->getClients()[i]->getScreen()->getTime()))					//check if client finished the movie/series
			{
				clientServer->getClients()[i]->getScreen()->unregister(clientServer->getClients()[i]->getID());							//remove client from Item's viewers list
				clientServer->getClients()[i]->setViewAble(0);																			//removes item from clients screen
			}
			else
			{
			clientServer->getClients()[i]->setTimer(clientServer->getClients()[i]->getTimer() + 5);										//promote viewing timer by 5
			cout << clientServer->getClients()[i]->getName() << " is playing " << clientServer->getClients()[i]->getScreen()->getName() << "\nDuration Time: " << clientServer->getClients()[i]->getScreen()->getTime() << "/" << clientServer->getClients()[i]->getTimer() << endl;
			}
		}
	}
};

//initialize the database from the files
bool SimulationService::loadData()
{	
	
	string token[5];
	int runtime = 0;
	PlayerService PS;
	ClientService CS;
	//Movies Initialization

	int truefalse = 0;
	string truue = "true";
	fstream movieFile("moviesFile.txt");
	if (!movieFile.is_open())																					//check if the file is open
	{
		cerr << "error opening Movies Input File" << endl;
		return false;
	}
	
	while (!movieFile.eof())
	{
		getline(movieFile, token[0], ',');
		getline(movieFile, token[1], ',');
		getline(movieFile, token[2], ',');
		getline(movieFile, token[3], '\n');	
		
		if (token[3] == "true")
			truefalse = 1;
		else
			truefalse = 0;

		runtime = atoi(token[2].c_str());
		PS.addMovie(SmartPtr<ViewAble>(new Movies(token[0], token[1], runtime, truefalse)));
		

	}
	movieFile.close();


	//Series Initialization
	int episodee = 0;
	int seasooon = 0;
	fstream seriesFile("seriesFile.txt");
	if (!seriesFile.is_open())																					//check if the file is open
	{
		cerr << "error opening Series Input File" << endl;
		return false;
	}

	while (!seriesFile.eof())
	{
		getline(seriesFile, token[0], ',');
		getline(seriesFile, token[1], ',');
		getline(seriesFile, token[2], ',');
		getline(seriesFile, token[3], ',');
		getline(seriesFile, token[4], '\n');

		episodee = atoi(token[2].c_str());
		seasooon = atoi(token[3].c_str());
		runtime = atoi(token[4].c_str());
		PS.addSeries(SmartPtr<ViewAble>(new Series(token[0], token[1], episodee, seasooon, runtime)));
	}
	seriesFile.close();



	//Clients Initialization																

	fstream clientFile("clientFile.txt");
	if (!clientFile.is_open())																					//check if the file is open
	{
		cerr << "error opening Clients Input File" << endl;
		return false;
	}

	while (!clientFile.eof())
	{
		getline(clientFile, token[0], ',');
		getline(clientFile, token[1], ',');
		getline(clientFile, token[2], '\n');

		CS.addClient(SmartPtr<Client>(new Client(token[0], token[1], token[2])));
	}
	clientFile.close();

	playerServer = SmartPtr<PlayerService>(new PlayerService(PS));
	clientServer = SmartPtr<ClientService>(new ClientService(CS));
	

	return true;
};

//initialize the simulation from simulation file
bool SimulationService::executeSimulation()				
{
	string token;
	string newLine;
	string delimiter = ":";


	fstream simulationFile("simulationFile.txt");
	if (!simulationFile.is_open())																				//check if the file is open
	{
		cerr << "error opening Simulation Input File" << endl;
		return false;
	}

	//simulation BEGINS
	while (!simulationFile.eof())
	{
		getline(simulationFile, newLine);
		playerServer->setRequests();
		cout << newLine << endl << endl;
		system("pause");

		
		if (newLine.compare("printSeries") == 0)
		{ 
			playerServer->printSeries();
		}

		else if (newLine.compare("printMovies") == 0)
		{ 
			playerServer->printMovies();
		}

		else if (newLine.compare("printInactives") == 0)
		{ 
			for (int i = 0; i < clientServer->getClients().size(); ++i)
			{
				if (!clientServer->getClients()[i]->playViewAble())										//need to check if client is currently viewing something
					cout << clientServer->getClients()[i]->getInfo() << endl;
			}
		}


		else if (newLine.compare("update") == 0)
		{ 
			update();
		}

		else																			
		{
			//split the string to start working on commands that arent simplefied above
			size_t pos = 0;
			while ((pos = newLine.find(delimiter)) != string::npos)												
			{
				token = newLine.substr(0, pos);																	//token holds the first parse (before the ":")
				newLine.erase(0, pos + delimiter.length());														//newLine now holds the second parse (after the ":")
			}


			if (token.compare("printItem") == 0)																		//if the command is to print and item
			{
				playerServer->printItem(newLine);
			}

			

			else																								//in case something else is inserted
			{
				for (int i = 0; i < clientServer->getClients().size(); ++i)										//check all clients list
				{

					if (clientServer->getClients()[i]->getID().compare(token) == 0)								//if inserted ID exists in client list
					{
						if (newLine.compare("stop") == 0)														//if the command is to stop client from viewing
						{
							cout << "\n\n" << clientServer->getClients()[i]->getName() << " has stoped watching " << clientServer->getClients()[i]->getScreen()->getName() << "\n\n" << endl;
							clientServer->getClients()[i]->getScreen()->unregister(token);						//problem - see definition
							//clientServer->getClients()[i]->clearViewAble();									//see definition
							break;
						}

						else																					//if the command is client wishes to start viewing content
						{
							for (int j = 0; j < playerServer->getDataBase().size(); ++j)						//search the requested item
								if (playerServer->getDataBase()[j]->getID().compare(newLine) == 0)
								{
									playerServer->getDataBase()[j]->registeer(clientServer->getClients()[i]);	//register the located client to the requested item in order to start viewing
									break;
								}
									
						}
					}
				}
			}
		}

	
	
	}
	simulationFile.close();


	return true;

};

SimulationService::~SimulationService()					
{

}
