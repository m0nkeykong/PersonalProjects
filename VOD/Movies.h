#ifndef MOVIES_H
#define MOVIES_H

#include "Viewable.h"
using namespace std;

class Movies : public ViewAble
{
private:
	bool oscarWinner;
	
public:
	Movies(string _id, string _name, int _playRunTime, bool _oscarWinner);
	string getInfo();
	bool play();


	void setId(int _id) { id = _id; };

	~Movies();
};

#endif