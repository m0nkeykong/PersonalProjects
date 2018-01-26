#ifndef ITEM_H
#define ITEM_H

#include <iostream>
#include <string>
//#include "ProgramController.h"
#include <vector>

using namespace std;


class Item
{
protected:
	int id;
	float price;
	string name;
	int quantity;
	
public:
	Item(int _id, float _price, string _name, int _quantity) : id(_id), price(_price), name(_name), quantity(_quantity) {};

	float getPrice() { return price; };
	int getQunatity() { return quantity; };
	string getName() { return name; };
	int getID() { return id; };
	void setQuantity(int _quantity) { quantity = _quantity; };
	void setPrice(float _price) { price = _price; };
	friend ostream& operator<<(ostream& PRINT, Item& Other);

	~Item() {};
};


class DiscountItem : public Item     										//discount item - inherits from item
{
private:
	float discountValue;

public:
	DiscountItem(int _id, float _price, string _name, int _quantity, float _discountValue) : Item(_id, discountedPrice(), _name, _quantity), discountValue(_discountValue) {};

	float discountedPrice() { return (price - discountValue); };			//returns item price after discount

	void updateDiscount(float newprice) { discountValue = newprice; };		//change discount value


	~DicountItem();
}


#endif
