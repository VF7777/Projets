package progAdvIS;

import java.awt.event.KeyEvent;
import java.awt.geom.Point2D;

import fr.lri.swingstates.canvas.CExtensionalTag;
import fr.lri.swingstates.canvas.CShape;
import fr.lri.swingstates.canvas.CStateMachine;
import fr.lri.swingstates.canvas.Canvas;
import fr.lri.swingstates.canvas.transitions.DragOnTag;
import fr.lri.swingstates.canvas.transitions.ReleaseOnTag;
import fr.lri.swingstates.sm.State;
import fr.lri.swingstates.sm.Transition;
import fr.lri.swingstates.sm.transitions.Drag;
import fr.lri.swingstates.sm.transitions.KeyRelease;
import fr.lri.swingstates.sm.transitions.Press;
import fr.lri.swingstates.sm.transitions.Release;
@SuppressWarnings("unused")
public class GestureTool extends CStateMachine {

	public CExtensionalTag baseTag, selectionTag;
	public State idle, move;
	public Point2D p;

	public GestureTool() {
		this(BUTTON1, NOMODIFIER);
	}

	public GestureTool(final int button, final int modifier) {
		baseTag = new CExtensionalTag() {};
		selectionTag = new SelectionTag();

		idle = new State() {//all actions except move

			Transition deselectOne = new ReleaseOnTag(selectionTag, button,
					CONTROL) {
				public void action() {
					Object[] shapes = selectionTag.getCollection().toArray();
					for (Object o : shapes) {
						CShape shape = (CShape) o;
						shape.removeTag(selectionTag);
					}
					//getShape().removeTag(selectionTag);
					consumes(true);
				}
			};
			Transition select = new DragOnTag(baseTag, button, NOMODIFIER) {
				public void action() {
					Object[] shapes = selectionTag.getCollection().toArray();
					for (Object o : shapes) {
						CShape shape = (CShape) o;
						shape.removeTag(selectionTag);
					}
					getShape().addTag(selectionTag);//Adds a CNamedTag tag to this shape.
					p = getPoint();
					consumes(true);
					System.out.println("select");
				}
			};
			Transition selectOneMore = new ReleaseOnTag(baseTag, button,
					CONTROL) {
				public void action() {
					getShape().addTag(selectionTag);
					consumes(true);
					//System.out.println("selectOneMore");

				}
			};
			Transition deselectAll = new Press(button, NOMODIFIER) {
				public void action() {
					if (((Canvas) getEvent().getSource()).hasTag(selectionTag)) {
					((Canvas) getEvent().getSource()).removeTag(selectionTag);
					}
					consumes(true);
					//System.out.println("deselectAll");

				}
			};
			Transition delete = new KeyRelease(KeyEvent.VK_BACK_SPACE) {
				public void action() {
					Canvas canvas = (Canvas) getEvent().getSource();
					canvas.removeShapes(selectionTag);
					consumes(true);
					//System.out.println("delete");

				}
			};
			Transition duplicate = new KeyRelease(KeyEvent.VK_ENTER) {
				public void action() {
					Object[] shapes = selectionTag.getCollection().toArray();
					for (Object o : shapes) {
						CShape shape = (CShape) o;
						shape.removeTag(selectionTag);
						CShape dup = shape.duplicate();
						dup.aboveAll().translateBy(5, 5);
						dup.addTag(baseTag).addTag(selectionTag);
						System.out.println("duplicate");

					}
					consumes(true);
				}
			};
		};

		move = new State() {//Drag
			Transition drag = new Drag(button, modifier) {
				public void action() {
					Point2D q = getPoint();
					selectionTag.translateBy(q.getX() - p.getX(),
							q.getY() - p.getY());
					p = q;
				}
			};
			
			Transition stop = new Release(button, modifier, ">> idle") {
				public void action() {
					Point2D q = getPoint();
					selectionTag.translateBy(q.getX() - p.getX(),
							q.getY() - p.getY());
				}
			};
		};

	}

	public CExtensionalTag getBaseTag() {
		return baseTag;
	}

	public CExtensionalTag getSelectionTag() {
		return selectionTag;
	}
	
}
