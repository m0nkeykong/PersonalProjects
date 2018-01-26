#ifndef CART_H
#define CART_H

#include "Item.h"

class Cart
{
private:
	vector<Item> itemlist;																//items in cart
	int numofprod;
public:
	Cart() : itemlist(0) {};
	
	float getTotal();																	//return cart current price
	
	vector<Item> getItemList() { return itemlist; };								//return list of items in cart
	
	bool addItem(Item _item, int quantity);												//add item to cart
	
	bool removeItem(int _id);												//remove item from cart
		

	int getNumOfProd() { return numofprod; }											//return number of products in the cart

	void setNumOfProd(int _numofprod) { numofprod = _numofprod; };						//sets number of products in the cart

	~Cart();
};

#endif 


