#include "Tile.h"



void Tile::setOccuipied() { isOccupied = !isOccupied; }

void Tile::setTraversable() { isTraversable = !isTraversable; }

void Tile::setCurrentPlayer(Player* player)
{
	currentPlayer = player;
}




Tile::~Tile() {};
