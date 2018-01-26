#ifndef DATABASE_H
#define DATABASE_H


#include <string>
#include <fstream>
#include <iostream>
#include "Cart.h"
#include <vector>

using namespace std;

class Database
{
private:

public:

	virtual vector<Item> listAllItems() = 0;
	virtual Item getItemByID(int ID) = 0;
	virtual bool writeNewOrder(Cart& tempCart) = 0;
	virtual vector<Cart> getAllOrders() = 0;

	virtual ~Database() = 0;
};



class WarehouseManager : public Database
{
private:
	vector<Item> availableitems;										//items in stock
	vector<Cart> purchases;												//orders purchased
	vector<Cart> orders;												//oreders commited (purchased or not)
public:
	WarehouseManager() { createWarehouse(); };

	void setPurchased(Cart& cart) { purchases.push_back(cart); };
	void setOrders(Cart& cart) { orders.push_back(cart); };
	vector<Item> listAllItems() { return availableitems; };
	Item getItemByID(int ID, int quantity);
	bool writeNewOrder(Cart& tempCart);
	vector<Cart> getAllOrders() { return orders; };
	vector<Cart> getPurchases() { return purchases; };


	void createWarehouse();

	~WarehouseManager() {};
};


#endif