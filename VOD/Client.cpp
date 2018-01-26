#include "Client.h"

//check problem with string
//define what method do
//smartPTR assignment
using namespace std;

Client::Client(string _id, string _name, string _location)
{
	id = _id;
	name = _name;
	location = _location;
	timer = 0;
	SmartPtr<ViewAble> currentViewAble = 0;
}

bool Client::playViewAble()
{
	if (!currentViewAble) return false;

	return true; 
}


//gets all the info about the client
string Client::getInfo()
{
	return ("ID: " + id + "\nName: " + name + "\nLocation: " + location +"\n");
}


Client::~Client()
{
}

