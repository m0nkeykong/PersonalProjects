// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#ifndef PLAYER_H
#define PLAYER_H


#include <iostream>
#include <fstream>
#include "Point.h"
#include "Card.h"

using namespace std;

const int Max_Cards = 5;                          //const varible for the max of card

class Player
{
private:
	Card deck[Max_Cards];
	char* name;
	int ID;
	int wins;
	int loses;
	int AVmoves;
	Point position;
	bool isplaying;
	int tempWins;

public:
	Player();
	Player(char* _name, int _ID, int _wins, int _loses, int _x, int _y);
	~Player();

	void printPlayer();
	void printDeck();

	Card* getDeck() { return deck; };
	char* getName() const { return name; };
	int getID() const { return ID; };
	int getWins() const { return wins; };
	int getLoses() const { return loses; };
	int getAVmoves() const { return AVmoves; };
	bool IsPlaying() const { return isplaying; };
	Point getPosition() const { return position; };
	int gettempWins() const { return tempWins; };
	
	void settempWins(int temp) { tempWins = temp; };
	void setName(const char* const _name);
	void setID(int _ID);
	void setIsPlaying(bool doeshe) { isplaying = doeshe; };
	void setWins(int _wins);
	void setLoses(int _loses);
	void setAVmoves(int _AVmoves) { AVmoves = _AVmoves; };
	void setPoint(int _x, int _y);

	Card* attackUsingCard(int i, ofstream& Bible);
	bool winMatch();
	bool loseMatch();




};
#endif
