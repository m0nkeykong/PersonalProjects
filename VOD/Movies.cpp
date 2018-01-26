#include "Movies.h"
#include <iostream>
using namespace std;


//constructor
Movies::Movies(string _id, string _name, int _playRunTime, bool _oscarWinner)
{
	id = _id; name = _name; playRunTime = _playRunTime; oscarWinner = _oscarWinner;
	currentlyWatchingMe.clear();
}

//deconstructor
Movies::~Movies()
{
}


//gets all the info about the series
string Movies::getInfo()
{
	return ("ID: " + id + "\nName: " + name + "\nMovie Runtime: " + to_string(playRunTime) + "\nDid i win an Oscar? " + to_string(oscarWinner) + "\n");
}




//"plays" requested series
bool Movies::play()
{
	cout << "\n\n" << "''" + name + "''" + " is now playing!" << "\n\n" << endl;
	return true;
}