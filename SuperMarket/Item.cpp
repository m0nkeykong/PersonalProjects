#include "Item.h"
using namespace std;

//dont forget to check if discount or not***********************************

ostream& operator<<(ostream& PRINT, Item& Other)
{
	PRINT << Other.getName() << endl
		<< "ID: " << Other.getID() << endl
		<< "Price: " << Other.getPrice() << endl
		<< "Available Stock: " << Other.getQunatity() << endl;
}

