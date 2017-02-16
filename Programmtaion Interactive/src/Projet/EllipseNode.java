package Projet;

import java.awt.Color;
import java.awt.Point;
import java.awt.geom.Ellipse2D;

public class EllipseNode extends Node{
	Point startPoint;
	public EllipseNode(RootNode c, Color o, Color f, Point p) {
		super(c, o, f);
		shape = new Ellipse2D.Double(p.x, p.y, 0, 0);
		startPoint = p;
	}
/*	public EllipseNode(EllipseNode other) {
		super(other.canvas, other.outline, other.fill);
		Ellipse2D.Double s = (Ellipse2D.Double) other.shape;
		shape = new Ellipse2D.Double(s.getX(), s.getY(), s.getWidth(),
				s.getHeight());
		isSelected = false;
		startPoint = other.startPoint;
	}
*/
	public void update(Point p) {
		((Ellipse2D.Double) shape).setFrameFromDiagonal(startPoint, p);
		canvas.repaint();
	}

	public void move(int dx, int dy) {
		((Ellipse2D.Double) shape).x += dx;
		((Ellipse2D.Double) shape).y += dy;
		canvas.repaint();
	}

}
