#include "Database.h"


void WarehouseManager::createWarehouse()								//create warehouse stock 
{
	Item item1(1004, 130, "Ford Fiesta Car Model", 5);		
	Item item2(0001, 105, "Spotted Horse Model", 5);
	DiscountItem sale1(0101, 173, "Vespa Prototype Model", 5, 0.15);
	DiscountItem sale2(0100, 188, "Desoto Squad Car Model", 5, 0.38);
	
	availableitems.push_back(item1);
	availableitems.push_back(item2);
	availableitems.push_back(sale1);
	availableitems.push_back(sale2);

	

}


Item WarehouseManager::getItemByID(int ID, int quantity)												//returns specific item by his ID
{
	for (int i = 0; i < 4; ++i)
		if (availableitems[i].getName == ID)
		{
			availableitems[i].setQuantity(availableitems[i].getQunatity() - quantity);
			return availableitems[i];
		}

	cout << "Item Was Not Found In The System\n";
	return;
}


bool WarehouseManager::writeNewOrder(Cart& tempCart)										//creates a new order on a specific cart
{
	/*??????????????????????????????????????????????????????*/


	//return trueOrfalse after creating a new Order (by input?? how The Fuck?!)
}



