#include "Series.h"
#include <iostream>
using namespace std;


//constructor
Series::Series(string _id, string _name, int _episode, int _season, int _playRunTime)
{
	id = _id; name = _name; episode = _episode; season = _season; playRunTime = _playRunTime;
	currentlyWatchingMe.clear();
}

//deconstructor
Series::~Series()
{
}


//gets all the info about the series
string Series::getInfo()
{
	return ("ID: " + id + "\nName: " + name  + "\nEpisode #" + to_string(episode)  + "\nSeason#" + to_string(season) + "\nEpisode Duration: " + to_string(playRunTime) + "\n");
}




//"plays" requested series
bool Series::play()
{
	cout << "Series " + name + " is now playing!" << endl;
	return true;
}
