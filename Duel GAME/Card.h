// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#ifndef CARD_H
#define CARD_H


#include <iostream>

using namespace std;
enum Color { Red, Green, Blue, Purple, Orange, Unknown };

class Card
{
private:
	char* name;
	int value;
	Color color;
	bool used;
public:
	Card();
	Card(char* _name, int _value, char* _color);
	~Card();
	void printCard()const;
	char* getName() { return name; };
	int getValue() { return value; };
	Color getColor() { return color; };
	bool getUsed()const { return used; };
	void setName(char* _name);
	bool setValue(int _value);
	bool setColor(char* _color);
	void printColor()const;
	void setUsed(bool condition) { used = condition; };
};

//void InitArrayOfCards(Card*const& cards);
char* color2char(Color color);
bool addCard2Deck(Card* deck, Card& card);
#endif






