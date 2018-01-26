#include "Board.h"



Board::Board(int r, int c) :rows(r), columns(c)
{
	gameboard = new Tile*[r];
	for (int i = 0; i < rows; ++i)
		gameboard[i] = new Tile[c];
}

//copy constructor
Board::Board(const Board& board, int r, const int c)
{
	Board* newboard = new Board(r, c);
	if (newboard == 0)
		cerr << "out of memory" << endl; // assumes error exits

	for (int i = 1; i <= board.columns; i++)
		for (int j = 1; j <= board.rows; j++)
			newboard->gameboard[j - 1][i - 1] = board.gameboard[j - 1][i - 1];

	gameboard = newboard->gameboard;
	columns = c;
	rows = r;
	delete newboard;
}






void Board::setMovementOfPlayer(Tile& currT, Player& currP, int x, int y)
{
	currP.setPoint(x, y);
	currP.setAVmoves((currP.getAVmoves()) - 1);
	currT.setOccuipied();
	currT.setCurrentPlayer(&currP);
	
}


void Board::PrintBoard(ofstream& Bible)const
{
	for (int i = 0; i < rows; ++i)
	{
		for (int j = 0; j < columns; ++j)
		{
			if (gameboard[i][j].getOccuiped())
			{
				cout << gameboard[i][j].getPlayerFirstLetter();
				Bible << gameboard[i][j].getPlayerFirstLetter();
			}
			else if (gameboard[i][j].getTraversable())
			{
				cout << " ";
				Bible << " ";
			}
			else
			{
				cout << "X";
				Bible << "X";
			}

		}
		cout << endl;
		Bible << endl;
	}

	cout << endl << endl;

}





Board::~Board()
{
}


