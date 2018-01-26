#ifndef VIEWABLE_H
#define VIEWABLE_H

#include <string>
#include "SmartPtr.h"
#include <vector>
#include "Client.h"

using namespace std;


class ViewAble
{
protected:
	string name;
	string id;
	int playRunTime;
	vector<SmartPtr<Client>> currentlyWatchingMe;

public:	
	virtual string getInfo() = 0;							
	string getID() { return id; };												// global method
	bool registeer (SmartPtr<Client>);											// global method - will be called by user:someid           
	bool unregister(string id);													// global method - will be called by user:stop
	virtual bool play() = 0;		
	vector<SmartPtr<Client>> getViewersList() { return currentlyWatchingMe; };
	int numOfViewers() { return currentlyWatchingMe.size(); };
	int getTime() { return playRunTime; };										// global method
	string getName() { return name; };											// global method

};



#endif