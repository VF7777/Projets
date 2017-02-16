package Projet;

import java.awt.Color;
import java.awt.Point;
import java.awt.Rectangle;

public class RectNode extends Node {
	Point firstPoint;

	public RectNode(RootNode c, Color o, Color f, Point p) {
		super(c, o, f);
		shape = new Rectangle(p.x, p.y, 0, 0);
		firstPoint = p;
	}

	public void update(Point p) {
		((Rectangle) shape).setFrameFromDiagonal(firstPoint, p);
		canvas.repaint();
	}

	public void move(int dx, int dy) {
		((Rectangle) shape).x += dx;
		((Rectangle) shape).y += dy;
		canvas.repaint();
	}
}
