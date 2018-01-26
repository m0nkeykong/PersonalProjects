// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#ifndef GAME_MANAGER_H
#define GAME_MANAGER_H


#include <iostream>
#include <fstream>
#include "Player.h"
#include "Board.h"


//players in linked list 

struct Jogador
{
	Player* jogador;
	Jogador* next;
};

// handle of players
struct head_Jogador
{
	int count;
	Jogador* first_p;
};

///////////////////////////////////////////////////////////////////////////

class GameManager
{
private:
	Board* board;
	int active;
	Jogador* activePlayers;
	int passive;
	Jogador* passivePlayers;
public:
	GameManager(char* filename, char* simulation, char* gameOn);

	void Genesis(char* creation_file);
	void Eden(char* simulation_file, ofstream& gameOn);
	void create_player(char* buffer);
	void create_card(char* buffer);
	void gameSTART(ofstream& Bible) ;
	void gameOVER() {};

	void print_Playerlist();

	void duelSTART(Player& attacker, Player& attacked, ofstream& Bible, ifstream& Eve);
	void duelOVER(Player& attacker, Player& defender, ostream& Bible);
	int battleSTART(Player& attacker, Player& defender, int cardindex1, int cardindex2, ofstream& Bible);
	int battleOVER(Card& currentCard1, Card& currentCard2);
	Board getBoard()const { return *board; };
	void createBoard(char* filename);
	void addToActList(Player& player);
	void addToPassList(const Player& player);
	void movePlayerTo(Player& player, Point& location, ofstream& Bible, ifstream& Eve);
	Player* search_player(int tempID, char ap);
	~GameManager();
};


///////////////////////////////////////////////////////////////////////////



int char2digit(char* &buffer);


#endif
