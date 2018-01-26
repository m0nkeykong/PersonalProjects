#include "PlayerService.h"



PlayerService::PlayerService(): requests(0)
{
	database.clear();
}


void PlayerService::printItem(string newLine)																							//prints the item and number of viewers
{
	cout << "\n\n" << requestViewable(newLine)->getInfo() << "Number Of Viewers: " << requestViewable(newLine)->numOfViewers() << "\n\n"  << endl;
}


SmartPtr<ViewAble> PlayerService::requestViewable(string id)																			//relates to printItem function
{
	for (int i = 0; i < database.size(); ++i)
	{
		if (id == database[i]->getID())
			return database[i];
	}
	cerr << "\n\n error! cannot find requested item details (requestViewable method)\n\n " << endl;
	return 0;
};


bool PlayerService::addSeries(SmartPtr<ViewAble>& toAdd)																				//add series from file to database
{
	if (!toAdd) return false;

	SmartPtr<ViewAble> temp(toAdd);
	database.push_back(temp);
	cout << "\n\nTHIS IS DATABASE CURRENT SIZE:               " << database.size() << endl << endl;
	return true;
};

bool PlayerService::addMovie(SmartPtr<ViewAble>& toAdd)																				//add movie from file to database
{
	if (!toAdd) return false;

	SmartPtr<ViewAble> temp(toAdd);
	database.push_back(temp);
	cout << "\n\nTHIS IS DATABASE CURRENT SIZE:               " << database.size() << endl << endl;
	return true;
};

void PlayerService::printSeries()														//print all series from database
{
	for (int i = 0; i < database.size(); ++i)
	{		
		
		if (typeid(*database[i]) == typeid(Series))									//identify if its a series or movie 
			cout << database[i]->getInfo() << endl;
	}
}

void PlayerService::printMovies()													//print all movies from database
{
	
	for (int i = 0; i < database.size(); ++i)
	{
		if (typeid(*database[i]) == typeid(Movies))									//identify if its a series or movie 
		cout << database[i]->getInfo() << endl;
	}
}




PlayerService::~PlayerService()
{
}
