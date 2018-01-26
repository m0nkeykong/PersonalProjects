// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#include "Card.h"
#include <string.h>
#include <iostream>

using namespace std;
/*default constructor*/
Card::Card()
{
	//intializing default card
	if (!(name = new char[15])) { value = -1; }
	value = 0;
	color = Unknown;
	used = false;
}

/*constructor with values*/
Card::Card(char* _name, int _value, char* _color) : value(_value), used(false)
{
	name = _strdup(_name);
	if (!(setColor(_color)))
		value = -1;
}



void  Card::printColor()const
{
	switch (color)
	{
	case 0:
		cout << "Red";
		break;
	case 1:
		cout << "Green";
		break;
	case 2:
		cout << "Blue";
		break;
	case 3:
		cout << "Purple";
		break;
	case 4:
		cout << "Orange";
		break;
	default:
		cout << "Unknown color";
	}
}


void Card::printCard()const
{
	cout << "Card Details:" << endl << "Name: " << name << "," << endl
		<< "Value: " << value << "," << endl << "Color: ";
	printColor();
	cout << "." << endl << endl;
}


void Card::setName(char* _name) { strcpy(name, _name); }

bool Card::setValue(int _value)
{
	if (_value < 1)
		return false;
	value = _value;
	return true;
}


bool Card::setColor(char* _color)
{
	if (!(strcmp(_color, "Red")))
		color = Red;
	else if (!(strcmp(_color, "Green")))
		color = Green;
	else if (!(strcmp(_color, "Blue")))
		color = Blue;
	else if (!(strcmp(_color, "Purple")))
		color = Purple;
	else if (!(strcmp(_color, "Orange")))
		color = Orange;
	else {
		color = Unknown;
		return false;
	}
	return true;
}



char* color2char(Color c)
{
	switch (c)
	{
	case 0:
		return "Red";
	case 1:
		return "Green";
	case 2:
		return "Blue";
	case 3:
		return "Purple";
	case 4:
		return "Orange";
	default:
		cerr << "error! Unknown color" << endl;
		return "Al azubi";
	}
}


/* Add a card to the Deck of a player*/
bool addCard2Deck(Card* deck, Card& card)
{
	int i = 0;
	for (; (i<5) && (deck[i].getValue() != 0); i++) {}                //getting to the next open space for a card in the arrey
	if (i == 5)
	{
		cerr << "error! the Player's hand is full." << endl;
		return false;
	}
	deck[i].setName(card.getName());
	deck[i].setColor(color2char(card.getColor()));
	deck[i].setValue(card.getValue());
	cout << "a new card '" << deck[i].getName() << "' was added to the player's deck!" << endl;
	return true;
}


Card::~Card()
{
	delete (name);
}
