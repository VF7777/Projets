package Projet;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.Point;
import java.awt.geom.AffineTransform;
import java.awt.geom.GeneralPath;
/**
 * @author Yang CHEN
 */
public class PathNode extends Node{

	public PathNode(RootNode c, Color o, Color f,Point p) {
		super(c, o, f);
		GeneralPath path = new GeneralPath();
		path.moveTo(p.x, p.y);
		shape = path;
	
	}

	public void update(Point p) {
		GeneralPath path = (GeneralPath) shape;
		path.lineTo(p.x, p.y);
		canvas.repaint();
	}

	public void move(int dx, int dy) {
		shape = AffineTransform.getTranslateInstance(dx, dy)
				.createTransformedShape(shape);
		canvas.repaint();
	}

	public void paint(Graphics2D g) {
		drawShape(g);
	}
}
