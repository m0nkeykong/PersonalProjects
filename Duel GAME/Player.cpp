// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#include "Player.h"
#include <string>
#include <iostream>
#include <fstream>
#include "Game_Manager.h"

using namespace std;

/*Default Constructor*/
Player::Player() :ID(20) ,tempWins(0) {};

/*Constructor with values*/
Player::Player(char* _name, int _ID, int _wins, int _loses, int _x, int _y) :position(_x, _y), ID(_ID)
{
	if (!(name = _strdup(_name)))
		cout << "Out of memory!" << endl;
	wins = _wins;
	loses = _loses;
	AVmoves = 3;
	tempWins = 0;
	isplaying = true;
}

/*Destructor*/
Player::~Player()
{
	delete[] name;
}

void Player::printPlayer()
{
	cout << endl << "Player details:" << endl << "ID: " << ID << ", Name: " << name << "," << endl
		<< "Wins: " << wins << ", Loses: " << loses << "," << endl
		<< "Number of Available moves: " << AVmoves << " ,and the Position is: ";
	position.printPoint();
	cout << " ." << endl;
	if (IsPlaying() == false)
		cout << "The Player Is Currently Not Playing" << endl;
	cout << "And His Cards Are: " << endl;
	printDeck();

}


void Player::setName(const char*  _name)
{
	delete[] name;
	if (!(name = _strdup(_name)))
		cerr << "error! out of memory." << endl;

}

void Player::setPoint(int _x, int _y)
{
	position.setX(_x);
	position.setY(_y);
}

void Player::setID(int _ID) { ID = _ID; }

void Player::setWins(int _wins)
{
	if (_wins < 0)
	{
		cerr << "error! invalid number of wins." << endl;
		wins = 0;
		return;
	}
	wins = _wins;
}

void Player::setLoses(int _loses)
{
	if (_loses < 0)
	{
		cerr << "error! invalid number of loses." << endl;
		loses = 0;
		return;
	}
	loses = _loses;

}


Card* Player::attackUsingCard(int i, ofstream& Bible)
{
	while ((i<0) || (i>5))
	{
		cerr << "error! invalid index of card." << endl;
		cout << "Enter another card index: ";
		cin >> i;
	}
	
	while (deck[i].getUsed() == true)
	{
		cout << "The selected card is already been used in this duel." << endl << "You can't just pick them again from the floor...." << endl;
		Bible << "The selected is already been used in this duel." << endl << "You can't just pick them again from the floor...." << endl;
		cout << "Enter another card index: ";
		cin >> i;
	}
	
	deck[i].setUsed(true);

	return &deck[i];
}

bool Player::winMatch()
{
	//write to the screen
	cout << "Player " << name << " just won a match! " << endl;

	wins++;
	return true;
}

bool Player::loseMatch()
{
	//write to the screen
	cout << "Player " << name << " just lose a match! " << endl;
	loses++;
	return true;
}

void Player::printDeck()
{
	Card*  _card = getDeck();
	int _val;
	for (int i = 0; ((_val = _card[i].getValue()) != 0) && (i<Max_Cards); ++i)
		_card[i].printCard();
}


