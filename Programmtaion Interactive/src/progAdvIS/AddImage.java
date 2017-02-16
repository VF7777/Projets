package progAdvIS;

import fr.lri.swingstates.canvas.CStateMachine;
import fr.lri.swingstates.canvas.Canvas;
import fr.lri.swingstates.canvas.CRectangle;
import fr.lri.swingstates.sm.State;
import fr.lri.swingstates.sm.Transition;
import fr.lri.swingstates.sm.transitions.*;

import java.awt.Graphics;
import java.awt.Image;
import java.awt.Point;
import java.awt.geom.Point2D;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;
import javax.swing.JFileChooser;
import javax.swing.filechooser.FileNameExtensionFilter;

@SuppressWarnings("unused")
public class AddImage extends CStateMachine {

	private CRectangle rect;
	private Point2D p1;
	private Point2D p2;
	public State start, draw;

	public AddImage() {
		this(BUTTON1, NOMODIFIER);

	}

	public AddImage(final int button, final int modifier) {
		start = new State() {
			Transition press = new Press(button, modifier, ">> draw") {
				public void action() {
					Canvas canvas = (Canvas) getEvent().getSource();
					p1 = getPoint();
					rect = canvas.newRectangle(p1, 1, 1);
					System.out.println("premier point" + p1);

				}
			};
		};
		draw = new State() {
			Transition draw = new Drag(button, modifier) {
				public void action() {
					rect.setDiagonal(p1, getPoint());
				}
			};
			Transition stop = new Release(button, modifier, ">> start") {
				public void action() {
					p2 = getPoint();
					System.out.println("deuxieme point" + p2);
					rect.setDiagonal(p1, getPoint());
					System.out.println("original width " + rect.getWidth()
							+ "height" + rect.getHeight());
					fireEvent(new ShapeCreatedEvent(AddImage.this, rect));
				}
			};
		};
	}

	public Point2D getFirstPoint() {
		System.out.println("retrun p1");
		return p1;

	}

	public Point2D getSecondePoint() {
		System.out.println("retrun p2");
		return p2;

	}
	/*
	 * public Boolean imgcontains(Point p) { return (p.x > positionimage.x &&
	 * p.x < positionimage.x + img.getHeight() && p.y > positionimage.y && p.y <
	 * positionimage.y + img.getHeight()); }
	 */

}
