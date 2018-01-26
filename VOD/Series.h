#ifndef SERIES_H
#define SERIES_H

#include "Viewable.h"
using namespace std;

class Series : public ViewAble
{
protected: 
	int season;
	int episode;
	
public:
	Series(string _id, string _name, int _episode, int _season, int _playRunTime);
	string getInfo();
	bool play();
	~Series();
};

#endif