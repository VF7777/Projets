package Projet;

import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.Point;
import java.awt.Rectangle;
import java.awt.Shape;
import java.awt.Stroke;
import java.util.ArrayList;

public abstract class Node {

	/**
	 * @author Yang CHEN
	 */
	protected boolean Visibility;
	protected Point Bordure;
	protected Node Parents;// information of parent
	protected ArrayList<Node> Children;// List of children
	protected RootNode canvas;
	protected Color outline, fill;
	protected Shape shape;
	protected Boolean isSelected;

	public Node(RootNode c, /*Node myparent,*/Color o, Color f) {
		canvas = c;
		fill = f;
		outline = o;
		shape = null;
		isSelected = false;
		Visibility = false;
		isSelected = false;

	}
	public void select() {
		isSelected = true;
		canvas.repaint();
	}

	public void deselect() {
		isSelected = false;
		canvas.repaint();
	}
	public void setOutlineColor(Color c) {
		outline = c;
		canvas.repaint();
	}

	public void setFillColor(Color c) {
		fill = c;
		canvas.repaint();
	}

	public void addChild(Node child) {
		Children.add(child);
	}

	public void removeChild(Node child) {
		Children.remove(child);
	}

	public void removeChildren() {
		Children.removeAll(Children);
	}

	public ArrayList<Node> getChildren() {
		return Children;
	}

	public Boolean contains(Point p) {
		return shape.contains(p);
	}

	protected void drawShape(Graphics2D g) {
		Stroke oldstrk = null;
		if (isSelected) {
			oldstrk = g.getStroke();
			g.setStroke(new BasicStroke(5));
		}
		g.setColor(outline);
		g.draw(shape);
		if (oldstrk != null)
			g.setStroke(oldstrk);
	}
	
	protected void fillShape(Graphics2D g) {
		g.setColor(fill);
		g.fill(shape);
	}
	public void paint(Graphics2D g) {
		fillShape(g);
		drawShape(g);
	}

	public Rectangle getBordure(){
		return shape.getBounds();
	}
	public abstract void update(Point p);

	public abstract void move(int dx, int dy);
}
