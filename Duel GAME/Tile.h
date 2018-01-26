#ifndef TILE_H
#define TILE_H

#include "Player.h"

class Tile
{
private:
	bool isOccupied;
	bool isTraversable;
	Player* currentPlayer;
	bool pathFlag;
public:
	Tile() : isOccupied(false), isTraversable(true), currentPlayer(0), pathFlag(false) {};

	//inline functions
	bool getOccuiped() { return isOccupied; };
	bool getTraversable() { return isTraversable; };
	Player* getPlayerInTile() { return currentPlayer; };
	char getPlayerFirstLetter() { return currentPlayer->getName()[0]; };
	bool getPathFlag()const { return pathFlag; };

	void setPathFlag(bool b) { pathFlag = b; };
	void setOccuipied();
	void setTraversable();
	void setCurrentPlayer(Player* player);

	~Tile();
};

#endif
