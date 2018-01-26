#include "Viewable.h"


using namespace std;


//adds a client as a viewer
bool ViewAble::registeer(SmartPtr<Client> toReg)
{
	if (!toReg) return false;

	for (int i = 0; i < this->getViewersList().size(); ++i)
	{
		if (this->currentlyWatchingMe[i]->getID() == toReg->getID())
		{
			cerr << "\n\nClient is already watching this content!\n\n" << endl;
			return false;
		}
	}
	cout << "\n\n" << toReg->getName() << " is now viewing " << this->getName() << "\n\n" << endl;
	toReg->setViewAble(this);
	currentlyWatchingMe.push_back(toReg);

	return true;
}


//removes a client from costumer list
bool ViewAble::unregister(string unreg)
{
	for (int i = 0; i < currentlyWatchingMe.size(); ++i)
	{
		if (unreg.compare(currentlyWatchingMe[i]->getID()) == 0)
		{
			currentlyWatchingMe.erase(currentlyWatchingMe.begin() + i);								//this line erases the item itself insted of just removing it - WHY GOD WHY?!
			return true;
		}
	}
	return false;
}
