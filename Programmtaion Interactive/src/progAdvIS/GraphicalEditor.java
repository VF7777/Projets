package progAdvIS;

import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.LinearGradientPaint;
import java.awt.Paint;
import java.awt.Point;
import java.awt.Rectangle;
import java.awt.TexturePaint;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyEvent;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.geom.Point2D;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.EventObject;

import javax.imageio.ImageIO;
import javax.swing.AbstractButton;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.ButtonGroup;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JSlider;
import javax.swing.event.ChangeEvent;
import javax.swing.event.ChangeListener;
import javax.swing.filechooser.FileNameExtensionFilter;

import fr.lri.swingstates.canvas.CExtensionalTag;
import fr.lri.swingstates.canvas.CHierarchyTag;
import fr.lri.swingstates.canvas.CPolyLine;
import fr.lri.swingstates.canvas.CShape;
import fr.lri.swingstates.canvas.CStateMachine;
import fr.lri.swingstates.canvas.CText;
import fr.lri.swingstates.canvas.Canvas;
import fr.lri.swingstates.canvas.transitions.DragOnTag;
import fr.lri.swingstates.canvas.transitions.LeaveOnTag;
import fr.lri.swingstates.canvas.transitions.PressOnTag;
import fr.lri.swingstates.debug.StateMachineVisualization;
import fr.lri.swingstates.events.VirtualEvent;
import fr.lri.swingstates.gestures.Gesture;
import fr.lri.swingstates.sm.JStateMachine;
import fr.lri.swingstates.sm.State;
import fr.lri.swingstates.sm.StateMachineListener;
import fr.lri.swingstates.sm.Transition;
import fr.lri.swingstates.sm.jtransitions.EnterOnJTag;
import fr.lri.swingstates.sm.jtransitions.LeaveOnJTag;
import fr.lri.swingstates.sm.transitions.Drag;
import fr.lri.swingstates.sm.transitions.Event;
import fr.lri.swingstates.sm.transitions.KeyPress;
import fr.lri.swingstates.sm.transitions.Press;
import fr.lri.swingstates.sm.transitions.Release;

@SuppressWarnings("unused")
public class GraphicalEditor extends JFrame {

	private static final long serialVersionUID = 1L;
	private Canvas canvas;
	private CShape palette;
	private CShape sCouleur;
	private SelectionTool selector;
	private GestureTool gesture;
	private Gesture currentGesture;
	private GestureRecognition gestureRecognition;
	private ArrayList<CStateMachine> tools, toolsStyle;
	private ArrayList<CShape> items =  new ArrayList<CShape>();
	private JFrame smviz;
	private int newStrokeValue, newColorValue;
	private CStateMachine toolCouleur;
	private JSlider sliderColor, slider;
	private Boolean GestureMode=false; // Mode of Gesture

	private JPanel paneMenu_l;// pane for set strock
	private JPanel paneMenu;// pane for set strock and color
	private JPanel paneMenu_r;// pane for set strock and color

	private JButton button1;
	private JButton button2;
	private JButton button3;
	private JButton button4;
	private JButton button5;
	private JButton button6;

	private boolean b = false;
	private String fileName;
	private BufferedImage img;
	private AddImage addimage;
	private Color color = Color.gray;// fill paint
	private Color gestureColor = new Color(51,153,255);
	private Color StrokColor = Color.black;
	private boolean setStrock = false;
	public int lineWidth;// represente the size of stroke

	/* 
	 * Drawing a BufferedImage with differente colors by LinearGradientPaint,
	 * charge it in a Graphics2D, then we can find the color of each pixel in this Bufferedimage
	 *  */

	public BufferedImage getColorSliderPixel() {

		float[] dist = { 0.0f, 0.2f, 0.4f, 0.6f, 0.8f, 1.0f };
		Color[] colors = { new Color(181, 32, 255), Color.blue, Color.green,
				Color.yellow, Color.orange, Color.red };
		Point2D start = new Point2D.Float(50, 0);// Le point départ
		Point2D end = new Point2D.Float(50, 200);// Le point final

		BufferedImage image = new BufferedImage(40, 200,
				BufferedImage.TYPE_INT_RGB);
		Graphics2D g = image.createGraphics();
		LinearGradientPaint p = new LinearGradientPaint(start, end, dist,
				colors);
		g.setPaint(p);
		g.fillRect(0, 0, 40, 200);
		g.dispose();
		return image;
	}
	/* Getting color RGB of a pixel */
	public Color GetPixelColor(int x, int y, BufferedImage newimage)
			throws IOException {

		// Getting pixel color by position x and y
		int clr = newimage.getRGB(x, y);
		int red = (clr & 0x00ff0000) >> 16;
		int green = (clr & 0x0000ff00) >> 8;
		int blue = clr & 0x000000ff;
		// System.out.println("RGB = " + red + "," + green + "," + red);
		Color c = new Color(red, green, blue);

		return c;

	}
	/* Listener of drawing，change the size of stroke and color*/

	private StateMachineListener smlistener = new StateMachineListener() {
		public void eventOccured(EventObject e) {

			ShapeCreatedEvent csce = (ShapeCreatedEvent) e;
			csce.getShape().addTag(selector.getBaseTag()).setFillPaint(color);
			csce.getShape().addTag(gesture.getBaseTag()).setFillPaint(color);//gesture

			csce.getShape().addTag(selector.getBaseTag())
					.setOutlinePaint(StrokColor);
			csce.getShape().addTag(selector.getBaseTag())
					.setStroke(new BasicStroke(lineWidth));
			csce.setLineWidth(lineWidth);
			if (b) {
				int p_x = (int) addimage.getFirstPoint().getX();
				int p_y = (int) addimage.getFirstPoint().getY();
				int l_x = (int) addimage.getSecondePoint().getX();
				int l_y = (int) addimage.getSecondePoint().getY();
				Rectangle r = new Rectangle(p_x, p_y, l_x - p_x, l_y - p_y);
				TexturePaint slatetp = new TexturePaint(img, r);
				System.out.println("twxture" + r);
				csce.getShape().addTag(selector.getBaseTag())
						.setFillPaint((Paint) slatetp);
				b = false;
			}
			new CHierarchyTag(palette).aboveAll();
			//items.add(csce.getShape());
		}
	};

	public GraphicalEditor(String title, int width, int height) {

		super(title);
		currentGesture = new Gesture();
		gestureRecognition = new GestureRecognition();
		canvas = new Canvas(width, height);
		canvas.setAntialiased(true);
		getContentPane().add(canvas);// add to collection of JFrame
		smviz = null;

		this.setGlassPane(canvas);
		this.getGlassPane().setVisible(true);
		canvas.setOpaque(false);//opaque or not

		/* add the functions drawing */
		tools = new ArrayList<CStateMachine>();
		selector = new SelectionTool();
		gesture = new GestureTool();

		tools.add(selector);
		tools.add(new RectangleTool());
		tools.add(new EllipseTool());
		tools.add(new LineTool());
		tools.add(new PathTool());
		addimage = new AddImage();
		tools.add(addimage);
		tools.add(gesture);
		tools.add(new HelpTool());// outil help

		int iconsize = 50;// the size of a icone
		palette = canvas.newRectangle(220, 5, tools.size() * iconsize, 15);
		palette.addTag(selector.getBaseTag());
		CText ptitle = canvas.newText(0, 0, "TOOLS", new Font("verdana",
				Font.PLAIN, 12));
		ptitle.setParent(palette);
		/* The reference point is relative to the shape's bounding box.*/
		ptitle.setReferencePoint(0.5, 0.5).translateTo(palette.getCenterX(),
				palette.getCenterY());// (0.5, 0.5) est le center

		/* Create the sub menus */
		paneMenu_l = new JPanel();
		paneMenu_l.setPreferredSize(new Dimension(40, 30));
		paneMenu_l.setLayout(new BoxLayout(paneMenu_l, BoxLayout.Y_AXIS));

		paneMenu_r = new JPanel();
		paneMenu_r.setPreferredSize(new Dimension(40, 30));
		paneMenu_r.setLayout(new BoxLayout(paneMenu_r, BoxLayout.Y_AXIS));

		paneMenu = new JPanel();

		paneMenu.setPreferredSize(new Dimension(800, 600));
		paneMenu.setLayout(new BoxLayout(paneMenu, BoxLayout.X_AXIS));
		/* the buttons for set the size of stroke */
		button1 = new JButton();
		ImageIcon icon = new ImageIcon("resources/1.png");
		icon = new ImageIcon(icon.getImage().getScaledInstance(25, 25,
				Image.SCALE_SMOOTH));

		button1.setIcon(icon);
		button1.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				button1.setBackground(Color.gray);
				button2.setBackground(getBackground());
				button3.setBackground(getBackground());
				lineWidth = 1;

			}
		});
		button2 = new JButton();
		ImageIcon icon3 = new ImageIcon("resources/3.png");
		icon3 = new ImageIcon(icon3.getImage().getScaledInstance(25, 25,
				Image.SCALE_SMOOTH));
		button2.setIcon(icon3);
		button2.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				button1.setBackground(getBackground());
				button2.setBackground(Color.gray);
				button3.setBackground(getBackground());
				lineWidth = 3;

			}
		});
		button3 = new JButton();
		ImageIcon icon5 = new ImageIcon("resources/5.png");
		icon5 = new ImageIcon(icon5.getImage().getScaledInstance(25, 25,
				Image.SCALE_SMOOTH));
		button3.setIcon(icon5);
		button3.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				button1.setBackground(getBackground());
				button2.setBackground(getBackground());
				button3.setBackground(Color.gray);
				lineWidth = 5;

			}
		});

		button4 = new JButton();
		ImageIcon icon_pink = new ImageIcon("resources/pink.png");
		icon_pink = new ImageIcon(icon_pink.getImage().getScaledInstance(25,
				25, Image.SCALE_SMOOTH));
		button4.setIcon(icon_pink);
		button4.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				button4.setBackground(Color.gray);
				button5.setBackground(getBackground());
				button6.setBackground(getBackground());

				StrokColor = Color.pink;

			}
		});
		button5 = new JButton();

		ImageIcon icon_orange = new ImageIcon("resources/orange.png");
		icon_orange = new ImageIcon(icon_orange.getImage().getScaledInstance(
				25, 25, Image.SCALE_SMOOTH));
		button5.setIcon(icon_orange);
		button5.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				button4.setBackground(getBackground());
				button5.setBackground(Color.gray);
				button6.setBackground(getBackground());
				StrokColor = Color.orange;
			}
		});
		button6 = new JButton();

		ImageIcon icon_green = new ImageIcon("resources/green.png");
		icon_green = new ImageIcon(icon_green.getImage().getScaledInstance(25,
				25, Image.SCALE_SMOOTH));
		button6.setIcon(icon_green);
		button6.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				button4.setBackground(getBackground());
				button5.setBackground(getBackground());
				button6.setBackground(Color.gray);
				StrokColor = Color.green;
			}
		});

		button1.setOpaque(true);
		button2.setOpaque(true);
		button3.setOpaque(true);
		button4.setOpaque(true);
		button5.setOpaque(true);
		button6.setOpaque(true);

		/* button for change the colors */

		ButtonGroup group1 = new ButtonGroup();
		group1.add(button1);
		group1.add(button2);
		group1.add(button3);
		ButtonGroup group2 = new ButtonGroup();
		group2.add(button4);
		group2.add(button5);
		group2.add(button6);

		paneMenu_l.add(button1);
		paneMenu_l.add(button2);
		paneMenu_l.add(button3);

		paneMenu_r.add(button4);
		paneMenu_r.add(button5);
		paneMenu_r.add(button6);
		paneMenu.add(paneMenu_l);
		paneMenu.add(Box.createHorizontalStrut(20));
		paneMenu.add(paneMenu_r);

		getContentPane().add(paneMenu);
		getContentPane().setVisible(false);
		
/////////////////////draw the crossing on canvas and do the crossing on the two JSliders///////////////////
		CStateMachine CrossingTrace = new CStateMachine() {
		/* A state machine to handle events with one or more CElement(Canvas, CTag or CShape).*/
			private Point2D pInit = new Point2D.Double(0, 0);

			private CPolyLine line;
			
			State waiting = new State() {
				Transition press = new Press(BUTTON1, ">> onPress") {
					public void action() {
				/*set for call by other Statemachine*/
						fireEvent(new VirtualEvent("pressEvent"));
						pInit.setLocation(getPoint());
						line = canvas.newPolyLine(getPoint());//draw orange line
						line.setDrawable(true);// the configuration for drawing
						line.setFilled(false);
						if(!GestureMode){
							line.setOutlinePaint(Color.ORANGE);
						}else {
							line.setOutlinePaint(gestureColor);
						}
						
						if (GestureMode) {
							currentGesture.reset();
							currentGesture.addPoint(getPoint().getX(), getPoint().getY());
						}
					}
				};
			};

			State onPress = new State() {
				Transition drag = new Drag(BUTTON1) {
					public void action() {

						line.lineTo(getPoint());//draw the line
						double x = getPoint().getX();
						double y = getPoint().getY();
						if (GestureMode) {
						currentGesture.addPoint(x, y);
						}
						//System.out.println("drag"+x+","+y);
						/* the location of slider */
						if (20 < x && x < 60 && 20 < y && y < 220) {
							newStrokeValue = 11 - (int) (y / 20);
							slider.setValue(newStrokeValue);
							// System.out.println(newStrokeValue);
						}

						if (110 < x && x < 150 && 20 < y && y < 220) {

							try {
								BufferedImage sliderbackgroundColor = getColorSliderPixel();
								color = GetPixelColor((int) (x - 110),
										(int) (y - 20), sliderbackgroundColor);
								newColorValue = 110 - (int) (y / 2);// (0 - 100)
								//System.out.println("color value test"+ newColorValue);
								sliderColor.setValue(newColorValue);
							} catch (IOException e) {
								e.printStackTrace();
							}

						}
					}
				};
				Transition release = new Release(BUTTON1, ">> waiting") {
					public void action() {
						fireEvent(new VirtualEvent("releaseEvent"));
						line.setDrawable(false);// stop drawing						
					}
				};
			};
		};
		CrossingTrace.attachTo(canvas);
		//showStateMachine(CrossingTrace);

		/* Detecte the crossing, the action for clique on buttons of sub menu.*/
		 
		JStateMachine CrossingDetection = new JStateMachine() {

			State waiting = new State() {
				Transition press = new Event("pressEvent", ">> ext") {
				};
			};

			State ext = new State() {
				Transition enter = new EnterOnJTag(
						AbstractButton.class.getName(), ">> inte") {
					public void action() {}
				};
				Transition release = new Event("releaseEvent", ">> waiting") {
					public void action() {
						//System.out.println("release");
						/*System.out.println(gestureRecognition
						.gestureRecognized(currentGesture));*/
			if (GestureMode) {
					String gestureRecognized = gestureRecognition
						.gestureRecognized(currentGesture);
				if (gestureRecognized != null) {
					if (gestureRecognized.equals("delete")) {
						System.out.println("delete");
						canvas.removeShapes(gesture.selectionTag);
					}

					if (gestureRecognized.equals("duplicate")) {
						Object[] shapes2 = selector.selectionTag.getCollection().toArray();
						for (Object o : shapes2) {
							CShape shape = (CShape) o;
							shape.removeTag(selector.selectionTag);
						}
						Object[] shapes = gesture.selectionTag.getCollection().toArray();
						for (Object o : shapes) {
							CShape shape = (CShape) o;
							shape.removeTag(gesture.selectionTag);
							shape.removeTag(selector.selectionTag);
							CShape dup = shape.duplicate();
							dup.aboveAll().translateBy(5, 5);
							dup.addTag(gesture.baseTag).addTag(gesture.selectionTag);
							dup.addTag(selector.baseTag).addTag(selector.selectionTag);
							System.out.println("duplicate");

						}
						consumes(true);
					
						System.out.println("duplicate");
						}
				};
			 }
		  }
	   };
	};

			State inte = new State() {
				Transition leave = new LeaveOnJTag(
						AbstractButton.class.getName(), ">> ext") {
					public void action() {
						((AbstractButton) getComponent()).doClick();
						// clique on the boutons
						//System.out.println("do click");
					}
				};
				Transition release = new Event("releaseEvent", ">> waiting") {
				};
			};
		};
		CrossingDetection.attachTo(this);
		//showJStateMachine(CrossingDetection);
		CrossingTrace.addStateMachineListener(CrossingDetection);

		// //////////////cd1 display a sub menu and add a image//////////////////
		CStateMachine cd1 = new CStateMachine() {
			State start = new State() {
				Transition changeTool = new Press(BUTTON1, ">>select") {
					public void action() {
					}
				};
			};
			State select = new State() {

				Transition changeTool = new DragOnTag(ToolTag.class,
						">>release") {

					public void action() {
						ToolTag tt = (ToolTag) getTag();
						canvas.getTag(ToolTag.class).setStroke(
								new BasicStroke(1));
						tt.aboveAll();
						CStateMachine theTool = tt.getTool();
						if (theTool.getClass().getName() == "progAdvIS.SelectionTool") {
							Object[] shapes2 = gesture.selectionTag.getCollection().toArray();
							for (Object o : shapes2) {
								CShape shape = (CShape) o;
								shape.removeTag(gesture.selectionTag);
							}
							GestureMode = false;
						}
						
						if (theTool.getClass().getName() == "progAdvIS.AddImage") {
							GestureMode = false;
						}
							
						if (theTool.getClass().getName() == "progAdvIS.PathTool") {
							GestureMode = false;
							getContentPane().setLayout(null);
							//System.out.println((int) palette.getCenterY());
							paneMenu.setLocation(
									(int) palette.getCenterX() + 60,
									(int) palette.getCenterY() - 180);
							getContentPane().add(paneMenu);
							getContentPane().setVisible(true);
							// System.out.println("Creation du Sous Menu set path");
							setStrock = true;

						}

						if (theTool.getClass().getName() == "progAdvIS.LineTool") {
							GestureMode = false;
							CPolyLine line2;
							Point2D pInit2 = new Point2D.Double(0, 0);
							pInit2.setLocation(getPoint());
							line2 = canvas.newPolyLine(getPoint());//draw orange line
							line2.setDrawable(true);//configuration for draw
							line2.setFilled(false);
							line2.setOutlinePaint(Color.BLUE);	
							getContentPane().setLayout(null);
							//System.out.println((int) palette.getCenterY());
							paneMenu.setLocation((int) palette.getCenterX(),
									(int) palette.getCenterY() - 180);
							getContentPane().add(paneMenu);
							getContentPane().setVisible(true);
							setStrock = true;

						}
						
						if (theTool.getClass().getName() == "progAdvIS.EllipseTool") {
							GestureMode = false;
							getContentPane().setLayout(null);
							paneMenu.setLocation(
									(int) palette.getCenterX() - 60,
									(int) palette.getCenterY() - 180);
							getContentPane().add(paneMenu);
							getContentPane().setVisible(true);
							// System.out.println("Creation Sub Menu of ellipse");

						}
						if (theTool.getClass().getName() == "progAdvIS.RectangleTool") {
							GestureMode = false;
							getContentPane().setLayout(null);
							paneMenu.setLocation(
									(int) palette.getCenterX() - 90,
									(int) palette.getCenterY() - 180);
							getContentPane().add(paneMenu);
							getContentPane().setVisible(true);
							//System.out.println("Creation Sub Menu of Rectangle");

						}
						if (theTool.getClass().getName() == "progAdvIS.GestureTool") {
							GestureMode = true;
						}
						
						if (theTool.getClass().getName() == "progAdvIS.AddImage") {
							GestureMode = false;
							FileNameExtensionFilter filter = new FileNameExtensionFilter(
									"Image Files", "jpg", "png", "gif", "jpeg");
							JFileChooser chooser = new JFileChooser();
							chooser.setFileFilter(filter);
							int returnVal = chooser.showOpenDialog(canvas);
							if (returnVal == JFileChooser.APPROVE_OPTION) {
								fileName = chooser.getSelectedFile().getName();
								System.out
										.println("You chose to open this file: "
												+ chooser.getSelectedFile()
														.getPath());
								fileName = chooser.getSelectedFile().getPath();

								try {
									img = ImageIO.read(new File(fileName));
								} catch (IOException e1) {
									e1.printStackTrace();
								}
								b = true;
							}

						}
						if (theTool.getClass().getName() == "progAdvIS.HelpTool") {
							new HelpFrame();
						}
						for (CStateMachine aTool : tools) {
							aTool.setActive(aTool == theTool);
						}
						consumes(true);

					}
				};
			};

			State release = new State() {
				Transition changeTool = new Release(BUTTON1, ">>start") {

					public void action() {
						getContentPane().remove(paneMenu);
						getContentPane().setVisible(false);

					}

					Transition leave = new LeaveOnTag(ToolTag.class, ">> ext") {
						public void action() {
							ToolTag tt = (ToolTag) getTag();
						}
					};
				};
			};

		};

		cd1.attachTo(canvas);
		//showStateMachine(cd1);

		new CStateMachine() {//change the tool
			State start = new State() {
				Transition changeTool = new PressOnTag(ToolTag.class, BUTTON1) {
					public void action() {//click on toolbar
						ToolTag tt = (ToolTag) getTag();
						canvas.getTag(ToolTag.class).setStroke(
								new BasicStroke(1));
						tt.setStroke(new BasicStroke(4));
						tt.aboveAll();
						CStateMachine theTool = tt.getTool();
						for (CStateMachine aTool : tools)
							aTool.setActive(aTool == theTool);
						
						if (theTool.getClass().getName() == "progAdvIS.SelectionTool") {
							GestureMode = false;
							Object[] shapes2 = gesture.selectionTag.getCollection().toArray();
							for (Object o : shapes2) {
								CShape shape = (CShape) o;
								shape.removeTag(gesture.selectionTag);
							}
						}
						if (theTool.getClass().getName() == "progAdvIS.AddImage") {
							GestureMode = false;

							GestureMode = false;
							FileNameExtensionFilter filter = new FileNameExtensionFilter(
									"Image Files", "jpg", "png", "gif", "jpeg");
							JFileChooser chooser = new JFileChooser();
							chooser.setFileFilter(filter);
							int returnVal = chooser.showOpenDialog(canvas);
							if (returnVal == JFileChooser.APPROVE_OPTION) {
								fileName = chooser.getSelectedFile().getName();
								System.out
										.println("You chose to open this file: "
												+ chooser.getSelectedFile()
														.getPath());
								fileName = chooser.getSelectedFile().getPath();

								try {
									img = ImageIO.read(new File(fileName));
								} catch (IOException e1) {
									e1.printStackTrace();
								}
								b = true;
							}

						
						}
							
						if (theTool.getClass().getName() == "progAdvIS.PathTool") {
							GestureMode = false;
						}

						if (theTool.getClass().getName() == "progAdvIS.LineTool") {
							GestureMode = false;
						}
						
						if (theTool.getClass().getName() == "progAdvIS.EllipseTool") {
							GestureMode = false;
						}
						if (theTool.getClass().getName() == "progAdvIS.RectangleTool") {
							GestureMode = false;
						}
						if (theTool.getClass().getName() == "progAdvIS.GestureTool") {
							GestureMode = true;
						}
						if (theTool.getClass().getName() == "progAdvIS.AddImage") {
							GestureMode = false;
						}
						if (theTool.getClass().getName() == "progAdvIS.HelpTool") {
							new HelpFrame();
						}
						consumes(true);

					}
				};

				Transition changeTool2 = new DragOnTag(ToolTag.class, BUTTON1) {
					public void action() {//Hignlight when cross on toolbar
						ToolTag tt = (ToolTag) getTag();
						canvas.getTag(ToolTag.class).setStroke(
								new BasicStroke(1));
						tt.setStroke(new BasicStroke(4));
						tt.aboveAll();
						CStateMachine theTool = tt.getTool();
						for (CStateMachine aTool : tools)
							aTool.setActive(aTool == theTool);
						consumes(true);
					}
				};

			};
		}.attachTo(canvas);

		// For choose the shapes
		for (int i = 0; i < tools.size(); i++) {
			CStateMachine tool = tools.get(i);
			tool.addStateMachineListener(smlistener);
			tool.attachTo(canvas);
			if (tool != selector)
				tool.setActive(false);// desactive StateMachine
			CShape s = canvas.newImage(220 + i * iconsize, 20, "resources/"
					+ tool.getClass().getName() + ".png");
			s.setParent(palette);
			s.addTag(new ToolTag(tool));

		}
		
		/** Slider of Color chosser*/

		toolCouleur = new ColorSlider();
		toolCouleur.attachTo(canvas);
		if (toolCouleur != selector)
			toolCouleur.setActive(false);

		sliderColor = new JSlider(JSlider.VERTICAL, 0, 100, 1);
		toolsStyle = new ArrayList<CStateMachine>();//add in a list
		toolsStyle.add(toolCouleur);

		sliderColor.setMinorTickSpacing(2);
		sliderColor.setMajorTickSpacing(10);
		sliderColor.setPaintTicks(false);
		sliderColor.setPaintLabels(false);
		sliderColor.setPreferredSize(new Dimension(40, 200));
		sliderColor.setUI(new MyColorSliderUI(sliderColor));
		/* point top left */
		sCouleur = canvas.newWidget(sliderColor, 110, 20); 
		sCouleur.addTag(new ToolTag(toolCouleur));
		sliderColor.addChangeListener(new ChangeListener() {

			public void stateChanged(ChangeEvent e) {

				JSlider source = (JSlider) e.getSource();
				if (!source.getValueIsAdjusting()) {
					int fps = (int) source.getValue();
					sliderColor.setValue(newColorValue);
				}
			}
		});
		sliderColor.addMouseListener(new MouseListener() {
			public void mousePressed(MouseEvent event) {}
			@Override
			public void mouseClicked(MouseEvent arg0) {}
			@Override
			public void mouseEntered(MouseEvent arg0) {}
			@Override
			public void mouseExited(MouseEvent arg0) {}
			@Override
			public void mouseReleased(MouseEvent arg0) {
				sliderColor.setValue(newColorValue);
				}
		});

		
		/*Slider for change the size of stroke*/

		CStateMachine toolTrait = new slide();
		toolsStyle.add(toolTrait);
		toolTrait.attachTo(canvas);
		if (toolTrait != selector)
			toolTrait.setActive(false);

		slider = new JSlider(JSlider.VERTICAL, 0, 10, 1);
		slider.setMinorTickSpacing(2);
		slider.setMajorTickSpacing(10);
		slider.setPaintTicks(false);
		slider.setPaintLabels(false);
		slider.setPreferredSize(new Dimension(40, 200));
		slider.setUI(new MySliderUI(slider));

		slider.addChangeListener(new ChangeListener() {

			public void stateChanged(ChangeEvent e) {

				JSlider source = (JSlider) e.getSource();
				if (!source.getValueIsAdjusting()) {
					int fps = (int) source.getValue();
					lineWidth = fps + 2;
				}
			}
		});
		slider.addMouseListener(new MouseListener() {
			public void mousePressed(MouseEvent event) {}
			
			@Override
			public void mouseClicked(MouseEvent arg0) {}

			@Override
			public void mouseEntered(MouseEvent arg0) {}

			@Override
			public void mouseExited(MouseEvent arg0) {}

			@Override
			public void mouseReleased(MouseEvent arg0) {
				slider.setValue(newStrokeValue);
			}
		});

		CShape sTrait = canvas.newWidget(slider, 20, 20);
		sTrait.setAntialiased(true);
		sTrait.setFillPaint(Color.WHITE);// definit the background color of slider
		sTrait.addTag(new ToolTag(toolTrait));

		CStateMachine vizToggler = new CStateMachine() {
			public State invisible = new State() {
				Transition help = new KeyPress(KeyEvent.VK_F1, ">> visible") {
					public void action() {
						if (smviz == null) {
							smviz = new JFrame("StateMachine Viz");
							Container pane = smviz.getContentPane();
							pane.setLayout(new BoxLayout(pane,
									BoxLayout.PAGE_AXIS));
							for (CStateMachine csm : tools) {
								pane.add(new JLabel(csm.getClass().getName()));
								pane.add(new StateMachineVisualization(csm));
							}
							smviz.pack();
						}
						smviz.setVisible(true);
					}
				};
			};
			public State visible = new State() {
				Transition help = new KeyPress(KeyEvent.VK_F1, ">> invisible") {
					public void action() {
						smviz.setVisible(false);
					}
				};
			};
		};
		vizToggler.attachTo(canvas);
		//showStateMachine(selector);
		//showStateMachine(gesture);
		pack();
		setVisible(true);
		canvas.requestFocusInWindow();
		new Server(canvas, selector, gesture);

	}

	public void populate() {
		canvas.newRectangle(10, 210, 30, 30).addTag(selector.getBaseTag());
		canvas.newRectangle(50, 300, 30, 30).addTag(selector.getBaseTag());
		canvas.newRectangle(100, 250, 30, 30).addTag(selector.getBaseTag());
		canvas.newRectangle(10, 210, 30, 30).addTag(gesture.getBaseTag());
		canvas.newRectangle(50, 300, 30, 30).addTag(gesture.getBaseTag());
		canvas.newRectangle(100, 250, 30, 30).addTag(gesture.getBaseTag());	}

	public static void showStateMachine(CStateMachine sm) {
		JFrame viz = new JFrame();
		viz.getContentPane().add(new StateMachineVisualization(sm));
		viz.pack();
		viz.setVisible(true);
	}

	public static void showJStateMachine(JStateMachine sm) {
		JFrame viz = new JFrame();
		viz.getContentPane().add(new StateMachineVisualization(sm));
		viz.pack();
		viz.setVisible(true);
	}

	public static void main(String[] args) {
		GraphicalEditor editor = new GraphicalEditor("Graphical Editor", 500,
				300);
		//editor.populate() ;
		editor.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	}

}
