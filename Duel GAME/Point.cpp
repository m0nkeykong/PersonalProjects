// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#include "Point.h"
#include <string.h>
#include <iostream>

using namespace std;

/*default constructor*/
Point::Point() { x = 0; y = 0;}

/*constructor with values*/
Point::Point(int _x, int _y)
{
	if (_x<0 || _y<0) {
		cerr << "illegal move! player has been sent to starting point(0,0)." << endl;
		x = y = 0;
		return;
	}

	x = _x;
	y = _y;
}

bool operator== (const Point &p1, const Point &p2)
{
	return (p1.getX() == p2.getX() &&
		p1.getY() == p2.getY());
}

bool operator!=(const Point &p1, const Point &p2)
{
	return !(p1 == p2);
}


void Point::setX(const int _x)
{
	if (_x<0) {
		cerr << "illegal move! player has been sent to starting point(0,Y)." << endl;
		x = 0;
		return;
	}
	x = _x;

}

void Point::setY(const int _y)
{
	if (_y<0) {
		cerr << "illegal move! player has been sent to starting point(X,0)." << endl;
		y = 0;
		return;
	}
	y = _y;

}

void Point::printPoint()const { cout << x << " , " << y; }

Point::~Point() {}

