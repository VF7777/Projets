package progAdvIS;

import java.awt.event.KeyEvent;
import java.awt.geom.Point2D;
import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.Socket;
import java.net.UnknownHostException;

import fr.lri.swingstates.canvas.CExtensionalTag;
import fr.lri.swingstates.canvas.CShape;
import fr.lri.swingstates.canvas.CStateMachine;
import fr.lri.swingstates.canvas.Canvas;
import fr.lri.swingstates.canvas.transitions.LeaveOnTag;
import fr.lri.swingstates.canvas.transitions.PressOnTag;
import fr.lri.swingstates.canvas.transitions.ReleaseOnTag;
import fr.lri.swingstates.sm.State;
import fr.lri.swingstates.sm.Transition;
import fr.lri.swingstates.sm.transitions.Drag;
import fr.lri.swingstates.sm.transitions.KeyRelease;
import fr.lri.swingstates.sm.transitions.Release;
import fr.lri.swingstates.sm.transitions.Press;
@SuppressWarnings("unused")
public class SelectionTool extends CStateMachine {
	public CExtensionalTag baseTag, selectionTag;
	public State idle, move, addOneMore, deselectall;
	private Point2D p;

	Boolean step = false;
	Socket s = null;

	OutputStream os;
	BufferedWriter bw = null;
	InputStream is;
	BufferedReader br = null;

	public SelectionTool() {
		this(BUTTON1, NOMODIFIER);
	}

	public SelectionTool(final int button, final int modifier) {

		baseTag = new CExtensionalTag() {
		};
		selectionTag = new SelectionTag();

		idle = new State() {
			Transition moveSelection = new PressOnTag(selectionTag, button, NOMODIFIER, ">> move") {
				public void action() {
					p = getPoint();
					consumes(true);
					// System.out.println("moveSelection");
				}
			};

			Transition select = new ReleaseOnTag(baseTag, button, NOMODIFIER, ">> move") {
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
				}};

			Transition delete = new KeyRelease(KeyEvent.VK_BACK_SPACE) {
				public void action() {
					Canvas canvas = (Canvas) getEvent().getSource();
					canvas.removeShapes(selectionTag);
					consumes(true);
					System.out.println("delete");

				}
			};
			Transition test = new Drag(">> addOneMore") {

				// Transition select = new Press(button, NOMODIFIER, ">>
				// delete"){
				public void action() {
					// System.out.println("select one more1");

				}
			};
			Transition deselectAll = new Press(button, NOMODIFIER) {
				public void action() {
					Object[] shapes = selectionTag.getCollection().toArray();
					for (Object o : shapes) {
						CShape shape = (CShape) o;
						shape.removeTag(selectionTag);
					}
					consumes(true);
				}
			};

			Transition duplicate = new KeyRelease(KeyEvent.VK_ENTER) {
				public void action() {
					Object[] shapes = selectionTag.getCollection().toArray();

					try {
/************************ Important! Set adresse IP here ************************/
						s = new Socket("172.20.10.4", 8888);
						System.out.println("creat client");
						os = s.getOutputStream();
						is = s.getInputStream();
						OutputStream out = new BufferedOutputStream(os);
						InputStream in = new BufferedInputStream(is);
						bw = new BufferedWriter(new OutputStreamWriter(out));
						br = new BufferedReader(new InputStreamReader(in));

					} catch (UnknownHostException e) {
						e.printStackTrace();
					} catch (IOException e) {
						e.printStackTrace();
					}
					String message = null;
					for (Object o : shapes) {
						CShape shape = (CShape) o;

						String aShape = null;

						switch (shape.getClass().getName()) {
						case "fr.lri.swingstates.canvas.CRectangle":
							aShape = "0" + "s" + shape.getCenterX() + "s" + shape.getCenterY() + "s" + shape.getWidth()
									+ "s" + shape.getHeight() + "s" + shape.getFillPaint().toString() + "s"
									+ (int) shape.getReferenceX() + "s" + shape.getOutlinePaint() + "f";
							break;
						case "fr.lri.swingstates.canvas.CEllipse":
							aShape = "1" + "s" + shape.getCenterX() + "s" + shape.getCenterY() + "s" + shape.getWidth()
									+ "s" + shape.getHeight() + "s" + shape.getFillPaint().toString() + "s"
									+ (int) shape.getReferenceX() + "s" + shape.getOutlinePaint() + "f";
							break;
						}

						message = aShape + message;
					}
					try {

						// send a message to server

						bw.write(message + "\n");
						bw.flush();

						if (br.readLine().equals("ok")) {
							s.close();
							System.out.println("connection closed" + s.isClosed());
						}

					} catch (IOException e) {
						e.printStackTrace();
					}

					consumes(true);
				}
			};
		};
		addOneMore = new State() {

			Transition select = new LeaveOnTag(baseTag, ">> addOneMore") {

				public void action() {

					getShape().addTag(selectionTag);
					consumes(true);

				}
			};

			Transition release = new Release(">> idle") {
				public void action() {

				}
			};
		};
		deselectall = new State() {

			Transition deselect = new Release(">> idle") {

				public void action() {
					((Canvas) getEvent().getSource()).removeTag(selectionTag);
					consumes(true);
					System.out.println("deselectAll");
				}
			};

		};
		move = new State() {
			Transition drag = new Drag(button, modifier) {
				public void action() {
					Point2D q = getPoint();
					selectionTag.translateBy(q.getX() - p.getX(), q.getY() - p.getY());
					p = q;
				}
			};
			Transition stop = new Release(button, modifier, ">> idle") {
				public void action() {
					Point2D q = getPoint();
					selectionTag.translateBy(q.getX() - p.getX(), q.getY() - p.getY());
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
