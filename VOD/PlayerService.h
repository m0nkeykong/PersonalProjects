#ifndef PLAYERSERVICE_H
#define PLAYERSERVICE_H

#include "Series.h"
#include "Movies.h"

using namespace std;
class PlayerService
{
private:
	vector<SmartPtr<ViewAble>> database;
	int requests;																	
public:
	PlayerService();
	
	SmartPtr<ViewAble> requestViewable(string id);
	bool addSeries(SmartPtr<ViewAble>&);
	bool addMovie(SmartPtr<ViewAble>&);
	void setRequests() { requests = ++requests; };
	void printSeries();
	void printMovies();
	void printItem(string);
	vector<SmartPtr<ViewAble>>& getDataBase() { return database; };

	~PlayerService();
};

#endif