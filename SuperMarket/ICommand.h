#ifndef ICOMMAND_H
#define ICOMMAND_H
#include <string>
#include <fstream>
#include <iostream>
#include "Database.h"

using namespace std;


class ICommand															//this is the command center
{
public:
	virtual bool execute() = 0;
};

class ShowAvaillItems : public ICommand									//shows all available items in the warehouse
{
private:
	Database* db;
public:
	ShowAvaillItems(Database* _db) : db(_db) {};
	bool execute();
};



class AddItemCommand : public ICommand									//command to add item to a specific cart
{
private:
	int itemID;
	int quantity;
	Cart* cartToAddTo;
	Database* db;
public:
	AddItemCommand(Database* db, int _itemID, int _quantity, Cart& _cart) : itemID(_itemID), quantity(_quantity), cartToAddTo(_cart), db(_db) {};
	int getItemID() { return itemID; };
	int getQuantity() { return quantity; };
	bool execute();

};



class RemoveItemCommand : public ICommand								//command to remove item from a specific cart
{
private:
	int itemID;
	Cart* cartToRemoveFrom;

public:
	RemoveItemCommand(int _itemID, Cart* _cart) : itemID(_itemID), cartToRemoveFrom(_cart) {};
	int getItemID() { return itemID; };
	bool execute();
	
};



class ShowCartCommand : public ICommand									//command that shows the consumer what items are in his cart
{
private:
	Cart* curCart;
public:
	ShowCartCommand(Cart* _cart) : curCart(_cart) {};
	bool execute();

};


class FinalizeOrderCommand : public ICommand							//command that gets the customer the the cashiering section
{
private:
	Cart* cartToPurchase;
	Database* db;
public:
	FinalizeOrderCommand(Cart& _cart, Database* _db) : cartToPurchase(&_cart), db(_db) {};
	bool execute();

};

class ShowSalesCommand : public ICommand								//command that shows the user all the purchases that has been commited 
{
private:
	Database* db;
public:
	ShowSalesCommand(Database* _db) : db(_db) {};
	bool execute();

};



class QuitCommand : public ICommand										//command that shuts down the system
{
	bool execute();

};





#endif