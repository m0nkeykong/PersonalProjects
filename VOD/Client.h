#ifndef CLIENT_H
#define CLIENT_H

#include <string>
#include "SmartPtr.h"
#include <vector>

using namespace std;

class ViewAble;
class Client
{
private:
	SmartPtr<ViewAble> currentViewAble;
	string id;
	string name;
	string location;
	int timer;


	
public:
	Client(string id, string name, string location);
	~Client();

	bool playViewAble() ;

	string getID() { return id; };
	string getName() { return name; };
	string getLocation() { return location; };
	string getInfo();
	void setViewAble(SmartPtr<ViewAble> temp) { currentViewAble = temp; };  
	void clearViewAble() { currentViewAble = 0; };									//redefine this to remove viewable content from user without erasing IT
	int getTimer() { return timer; };
	void setTimer(int _timer) { timer = _timer; };
	SmartPtr<ViewAble> getScreen() { return currentViewAble; };

};


#endif

