#ifndef BOARD_H
#define BOARD_H

#include "Tile.h"
#include "Player.h"
#include "Point.h"


class Board
{
private:
	Tile** gameboard;
	int rows;
	int columns;
public:
	Board(int r, int c);
	Board(const Board& board, int r, int c);

	Tile** getGameBoard() { return gameboard; };
	Tile& getTile(int x, int y)const { return gameboard[y][x]; };
	
	void PrintBoard(ofstream& Bible)const;
	int getColumns()const { return columns; };
	int getRows()const { return rows; };
	void setMovementOfPlayer(Tile&, Player&, int, int);

	~Board();
};


#endif
