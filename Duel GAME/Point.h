// MADE BY TAL CHAUSHU AND HAIM ELBAZ
#ifndef POINT_H
#define POINT_H

#include <iostream>

class Point
{
private:
	int x;
	int y;
public:
	Point();
	Point(int _x, int _y);
	~Point();




	int getX()const { return x; };             //inline mathods
	int getY()const { return y; };             //inline mathods
	void setX(const int _x);
	void setY(const int _y);
	void printPoint()const;

};
bool operator==(const Point &p1, const Point &p2);
bool operator!=(const Point &p1, const Point &p2);
#endif 
