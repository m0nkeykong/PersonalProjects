#include "ICommand.h"





bool ShowAvaillItems::execute()
{
	vector<Item> temp = db->listAllItems();
	
	if (temp == 0)									//how to handle something like this***********************************
		return false;

	for (int i = 0; i < 4; ++i)
		cout << temp;

	return true;
}


bool AddItemCommand::execute()
{
	Item temp = db->getItemByID(getItemID(), getQuantity());		

	if ((getQuantity() == 0) || temp == 0)			//how to handle something like this***********************************
		return false;

	cartToAddTo->addItem(temp, getQuantity());
	return true;
}



bool RemoveItemCommand::execute()
{
	if (getItemID() == 0)							
		return false;

	cartToRemoveFrom->removeItem(getItemID());
	return true;
}



bool ShowCartCommand::execute()
{
	vector<Item> temp = curCart->getItemList();
	
	if (temp == 0)												//how to handle something like this***********************************
		return false;

	for (int i = 0; i < curCart->getNumOfProd(); ++i)
		cout << temp[i] << endl;


	return true;
}




bool FinalizeOrderCommand::execute()
{
	vector<Item> temp = cartToPurchase->getItemList();

	if (temp == 0)												//how to handle something like this***********************************
		return false;

	for (int i = 0; i < cartToPurchase->getNumOfProd(); ++i)
		cout << temp[i] << endl; 


	cout << "Total amount for payment: "
		<< cartToPurchase->getTotal() << endl;

	//*******add to warehouseManager->purchased and orders +1
	return true;
}





bool ShowSalesCommand::execute()
{
	//****** gets from warehouseManager the purchased list
}



bool QuitCommand::execute()
{
	//end the day and destroyes the database and everything
}