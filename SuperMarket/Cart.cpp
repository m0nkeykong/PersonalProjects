#include "Cart.h"



float Cart::getTotal() 
{
	float total;
	float ifdiscount;
	vector<Item> temp = itemlist;
	
	for (int i = 0; i < getNumOfProd(); ++i)
	{
		//if (temp[i].discountedprice != 0)												//need to check decleration in Database (insertion of items)
		//	total += (temp[i].discountedPrice * temp[i].getQunatity());
		//else
			total += (temp[i].getPrice() * temp[i].getQunatity());	
	}

	return total;
}






bool Cart::addItem(Item _item, int quantity)										//need to check if to get by & or by value
{
	
	vector<Item> temp = getItemList();
	_item.setQuantity(quantity);
	temp.push_back(_item);
	return true;
}

bool Cart::removeItem(int _id) 
{
	vector<Item> temp = getItemList();
	
	for (int i = 0; i < getNumOfProd(); ++i)
	{
		if (temp[i].getID() == _id)
		{
			temp.erase(temp.begin() + i);
			setNumOfProd(getNumOfProd() - 1);
			return true;
		}
	}
	return false;
}


Cart::~Cart()
{
}
