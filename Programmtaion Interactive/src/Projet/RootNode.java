package Projet;

import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.Point;
import java.awt.RenderingHints;
import java.awt.image.BufferedImage;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import javax.swing.JComponent;

/**
 * @author Yang CHEN
 */
@SuppressWarnings("serial")
public class RootNode extends JComponent {
	ArrayList<Node> nodes;//List of children belong to root
	public int x;//Enter x coordinate
	public int y;//Enter y coordinate
	public int wrap_x, textLegnth, wrap_Legnth = 0;
	public int wrap_y, textHeight;
	public String text = "";
	public int fontsize = 24;
	public char keyWord;
	public boolean flipped;
	public Point insertion;//Enter point of text
	private BufferedImage image;
	// text mode
	public HashMap<Point, String> words = new HashMap<Point, String>();


	public RootNode(BufferedImage img) {
		image = img;
		flipped = false;
		nodes = new ArrayList<Node>();
	}

	@Override
	public Dimension getPreferredSize() {
		if (image != null) {
			return new Dimension(image.getWidth(), image.getHeight());
		} else {
			return new Dimension(200, 100);
		}
	}
	
	// for display in another line
	public void drawString(Graphics g, String text, int x, int y) {
		for (String line : text.split("\n"))
			g.drawString(line, x, y += g.getFontMetrics().getHeight());
	}
	
	// for delete the last charactere 
	public String BackSpace(String str) {// remove the last charactere in String
		if (str == null || str.length() == 0) {// test the text length
			return str;
		} else {
			return str.substring(0, str.length() - 1);
		}

	}

	@Override
	public void paintComponent(Graphics g) {

		Graphics2D g2d = (Graphics2D) g;
		// super.paintComponent(g);
		this.setFocusable(true);
		if (flipped) {
			// /////////////////////draw rectangle//////////////////////

			g2d.drawRect(0, 0, image.getWidth(), image.getHeight());
			g2d.setColor(Color.WHITE);// color of rectangle
			g2d.fillRect(0, 0, image.getWidth(), image.getHeight());
			/***************draw all shapes*********/
			BasicStroke s = new BasicStroke(3.0f, BasicStroke.CAP_ROUND,
					BasicStroke.JOIN_ROUND);
			g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING,
					RenderingHints.VALUE_ANTIALIAS_ON);
			
			g2d.setStroke(s);
			for (Node item : nodes){
				item.paint(g2d);
			}
			
			//System.out.println(nodes.size());

			// /////////////////////Enter text//////////////////////

			g2d.setFont(new Font("TimesRoman", Font.PLAIN, fontsize));
			g2d.setColor(Color.black);
			// Display current text
			drawString(g2d, text, x, y);
			textLegnth = g2d.getFontMetrics().stringWidth(text);
			textHeight = g2d.getFontMetrics().getHeight();

			// Iterating all texts, to display all text
			Iterator<Map.Entry<Point, String>> iterator = words.entrySet()
					.iterator();// parcours hashmap
			while (iterator.hasNext()) {
				Map.Entry<Point, String> entry = iterator.next();
				entry.getKey();
				entry.getValue();
				drawString(g2d, entry.getValue(), entry.getKey().x,
						entry.getKey().y);
			}
			//System.out.println(words.size());

		} else {
			g2d.drawImage(image, 0, 0, null);
		}
		
		
		revalidate();
	}
	
	public Node getItemAt(Point p) {
		for (int i = nodes.size() - 1; i >= 0; i--) {
			Node item = nodes.get(i);
			if (item.contains(p))
				return item;
		}
		return null;
	}
	public Point getBordure() {
		return null;
	}

	public void addNode(Node node) {
		nodes.add(node);
	}

	public void removeNode(Node node) {
		nodes.remove(node);
	}

	public void removeAllNode() {
		nodes.removeAll(nodes);
	}

	public ArrayList<Node> getAllNodes() {
		return nodes;
	}
}
