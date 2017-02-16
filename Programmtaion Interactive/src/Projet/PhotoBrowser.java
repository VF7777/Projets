package Projet;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.Font;
import java.awt.GridLayout;
import java.awt.Image;
import java.awt.Point;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionAdapter;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.FilenameFilter;
import java.io.IOException;

import javax.imageio.ImageIO;
import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.ButtonGroup;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JColorChooser;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JPanel;
import javax.swing.JRadioButton;
import javax.swing.JScrollPane;
import javax.swing.JToggleButton;
import javax.swing.JToolBar;
import javax.swing.border.LineBorder;
import javax.swing.filechooser.FileNameExtensionFilter;
/**
 * @author Yang CHEN
 */
@SuppressWarnings("serial")
public class PhotoBrowser extends JFrame {

	private String fileName,clickImage;
	private BufferedImage img;
	private RootNode photocomponent;
	private Node selection; // Stores the selected item
	private JPanel outline;
	private JPanel fill;
	private String mode;
	private JButton backward = new JButton("Back to Browsers");
	private File[] FilesList;
	private Point mousepos; // Stores the previous mouse position
	private JScrollPane jsp;
	private JToggleButton FamilyMode = new JToggleButton("Family");
	private JToggleButton VacationMode = new JToggleButton("Vacation");
	private JToggleButton Schoolmode = new JToggleButton("School");
	public boolean BrowsersMode, ViewMode, SplitMode;
	public boolean TextMode =true;
	
	JMenuBar MainMenuBar = new JMenuBar();
	

	JPanel mainPanel = new JPanel();
	JPanel browserPanel = new JPanel();
	JPanel toolsPanel = new JPanel();
	JPanel bottomPanel = new JPanel();
	
	JLabel[] imagesLabel;
	JLabel StatutLabel = new JLabel();
	JLabel MainLabel = new JLabel();
	Color bottomColor = new Color(228, 227, 228);// the color of bottom panel act as a status bar
	Color mainPanelColor = new Color(30, 30, 30);// the color of main panel
	Color mainLabelColor = new Color(183, 181, 187);// the color of main pane
	Color borderLabelColor = new Color(129, 216, 253);// the color of photo's border

	// Select an Item
	private void select(Node item) {
		if (selection != null)
			selection.deselect();
		selection = item;
		if (selection != null) {
			selection.select();
			outline.setBackground(selection.outline);
			fill.setBackground(selection.fill);
			// for (JButton op : operations)
			// op.setEnabled(true);
		} // else {
			// for (JButton op : operations)
			// op.setEnabled(false);
		// }
	}

	// Create the radio button for the mode
	public JRadioButton createMode(String description, ButtonGroup group) {
		JRadioButton rbtn = new JRadioButton(description);
		rbtn.setActionCommand(description);
		rbtn.setFocusable(false);
		rbtn.setFont(rbtn.getFont().deriveFont(15.0f));
		rbtn.setForeground(Color.WHITE);
		if (mode == description)
			rbtn.setSelected(true);
		rbtn.addActionListener(modeListener);
		group.add(rbtn);
		return rbtn;
	}

	// Listen the click on the color chooser
	private MouseAdapter colorListener = new MouseAdapter() {
		public void mouseClicked(MouseEvent e) {
			JPanel p = (JPanel) e.getSource();
			Color c = p.getBackground();
			c = JColorChooser.showDialog(null, "Select a color", c);
			if (selection == null)
				p.setBackground(c);
			else if (p == outline) {
				p.setBackground(c);
				selection.setOutlineColor(c);
			} else if (p == fill) {
				p.setBackground(c);
				selection.setFillColor(c);
			}
		}
	};

	// Create the color sample used to choose the color
	private JPanel createColorSample(Color c) {
		JPanel p = new JPanel();
		p.setBorder(BorderFactory.createLineBorder(Color.BLACK, 1));
		p.setOpaque(true);
		p.setBackground(c);
		p.setMaximumSize(new Dimension(500, 150));
		p.addMouseListener(colorListener);
		return p;
	}
	
	/************************* Browser mode*************************/
	public MouseListener MouseImagesFolderAction = new MouseListener(){
		public void mouseClicked(MouseEvent e) {

			for (int i = 0; i < imagesLabel.length; i++) {
				imagesLabel[i].setBorder(null);//set each photo's border with null
			}
			JLabel jl = (JLabel) e.getSource();
			System.out.println(jl.getName());
			clickImage=jl.getName();//get the path of photo which we clicked
			jl.setBorder(new LineBorder(borderLabelColor));//add border when click on it
		/////////////////Open a image to edit/////////////////////////////////////////////
		if (e.getClickCount() == 2) {
			try {
			img = ImageIO.read(new File(clickImage));
			photocomponent = new RootNode(img);
			//remove all listner
			mainPanel.removeKeyListener(myKeyListener);
			photocomponent.removeMouseListener(sourisListener);
			photocomponent.removeMouseMotionListener(sourisMotionListener);
			mainPanel.removeAll();
			repaint();
			//add listner
			photocomponent.addMouseListener(sourisListener);
			photocomponent.addMouseMotionListener(sourisMotionListener);
			JScrollPane ScrollPane = new JScrollPane(photocomponent);
			ScrollPane.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
			ScrollPane.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED);
			ScrollPane.setPreferredSize(new Dimension(800, 600));
			ScrollPane.getViewport().setBackground(Color.LIGHT_GRAY);
			// remove all
			//mainPanel.remove(MainLabel);
			//mainPanel.remove(jsp);
			//mainPanel.add(backward);
			mainPanel.add(ScrollPane);
			//mainPanel.add(toolsPanel);
			mainPanel.requestFocus();
			mainPanel.setFocusable(true);
			mainPanel.addKeyListener(myKeyListener);
			revalidate();
			} catch (IOException e1) {
				e1.printStackTrace();
			}
				}
			}
		@Override
		public void mousePressed(MouseEvent e) {}
		@Override
		public void mouseReleased(MouseEvent e) {}
		@Override
		public void mouseEntered(MouseEvent e) {}
		@Override
		public void mouseExited(MouseEvent e) {}
	};
	
	//resize pictures
	public void resizeIcon(ImageIcon Icon, JLabel jlb) {
		ImageIcon icon = Icon;
		icon = new ImageIcon(Icon.getImage().getScaledInstance(150, 120, Image.SCALE_SMOOTH));
		jlb.setIcon(icon);
	}
	// Listen the mode changes and update the Title
	private ActionListener modeListener = new ActionListener() {
		public void actionPerformed(ActionEvent e) {
			mode = e.getActionCommand();
			updateInformation();
		}
	};

	// Update the Title
	private void updateInformation() {
		StatutLabel.setText("Draw " + mode);
	}
/************************************MouseListener*****************************/
	private MouseAdapter sourisListener = new MouseAdapter() {

		public void mouseClicked(MouseEvent e) {
			if (0 < e.getX() && e.getX() < img.getWidth() && 0 < e.getY()
					&& e.getY() < img.getHeight()) {
				if (e.getClickCount() == 2) {
					if (photocomponent.flipped == false) {
						photocomponent.flipped = true;
						mainPanel.add(toolsPanel);
						revalidate();
					} else {
						photocomponent.flipped = false;
					}
					// System.out.println("countMouse" + " " + flipped + " " +
					// e.getClickCount());
				}
				if (photocomponent.flipped&&TextMode) {
					photocomponent.insertion = new Point(photocomponent.x,
							photocomponent.y);
					photocomponent.words.put(photocomponent.insertion,
							photocomponent.text);
					photocomponent.x = e.getX();
					photocomponent.y = e.getY();
					//System.out.println(photocomponent.x+","+photocomponent.y);
					// Initialize the point to detect line breaks
					photocomponent.wrap_x = 0;
					photocomponent.textLegnth = 0;
					photocomponent.wrap_Legnth = 0;
					photocomponent.wrap_y = photocomponent.y;

					photocomponent.text = "";
					e.consume();

					// System.out.println("Haha" + x + "," + y);
				} else if (!photocomponent.flipped) {
					mainPanel.remove(toolsPanel);

				}
				//revalidate();
				repaint();
			}
		}

		public void mousePressed(MouseEvent e) {
			Point p = e.getPoint();
			if (photocomponent.flipped) {

				if (mode.equals("Select/Move"))
					select(photocomponent.getItemAt(p));
				else {
					Node item = null;
					Color o = outline.getBackground();
					Color f = fill.getBackground();
					if (mode.equals("Rectangle")){
						item = new RectNode(photocomponent, o, f, p);
						TextMode = false;
					}
					else if (mode.equals("Text")){
						TextMode = true;
						item =null;
					}
						//textItem = new TextNode(photocomponent, o, f, p);
					else if (mode.equals("Ellipse")){
						item = new EllipseNode(photocomponent, o, f, p);
						TextMode = false;
					}
					else if (mode.equals("Line")){
						item = new LineNode(photocomponent, o, f, p);
						TextMode = false;
					}
					else if (mode.equals("Path")){
						item = new PathNode(photocomponent, o, f, p);
						TextMode = false;
					}
					if (item instanceof RectNode|| item instanceof EllipseNode|| 
							item instanceof LineNode|| item instanceof PathNode) {
						photocomponent.addNode(item);
						select(item);
						//System.out.println("select");
					}
				}
				mousepos = p;
				
			} else {
				mainPanel.add(toolsPanel);
			}
		}
		
		public void mouseReleased(MouseEvent e) {}

		public void mouseEntered(MouseEvent e) {}

		public void mouseExited(MouseEvent e) {}
	};

	private MouseMotionAdapter sourisMotionListener = new MouseMotionAdapter() {

		public void mouseMoved(MouseEvent e) {}

		public void mouseDragged(MouseEvent e) {
			if (0 < e.getX() && e.getX() < img.getWidth() && 0 < e.getY()
					&& e.getY() < img.getHeight()) {
				if (photocomponent.flipped&&!TextMode) {
					// System.out.format("mouseDragged %s %s\n",mode,selection) ;
					if (selection == null)
						return;
					if (mode.equals("Select/Move")) {
						selection.move(e.getX() - mousepos.x, e.getY() - mousepos.y);
					} else
						selection.update(e.getPoint());
					mousepos = e.getPoint();
					pack();
					setVisible(true);
					repaint();					
				}
			}

			
		}

	};
	//////////////////////////KeyBoard Listenr//////////////////////

	private KeyAdapter myKeyListener = new KeyAdapter() {
		public void keyTyped(KeyEvent e) {}

		public void keyPressed(KeyEvent e) {
			System.out.println("test!");
			if (photocomponent.flipped && TextMode) {

				photocomponent.keyWord = e.getKeyChar();

				// recalculate the length of string when word wrap
				photocomponent.wrap_x = photocomponent.textLegnth
						- photocomponent.wrap_Legnth;
				photocomponent.wrap_x = photocomponent.x
						+ photocomponent.wrap_x;
				// If the text reaches the end, text wrap,add the height of text
				if (photocomponent.wrap_x >= img.getWidth()
						- photocomponent.fontsize / 2) {
					photocomponent.wrap_y = photocomponent.textHeight
							+ photocomponent.wrap_y;
					// If the text has not reached the bottom end
					if (photocomponent.wrap_y < img.getHeight()
							- photocomponent.fontsize) {
						photocomponent.text = photocomponent.text + "\n";
						photocomponent.wrap_Legnth = photocomponent.textLegnth;
						// recalculate the length of the new line
					}
				}
				// System.out.println(wrap_x+","+wrap_Legnth+","+textLegnth);

				if (photocomponent.keyWord != KeyEvent.CHAR_UNDEFINED
						&& photocomponent.keyWord != KeyEvent.VK_BACK_SPACE
						&& photocomponent.wrap_y < img.getHeight()- photocomponent.fontsize) 
				{
					photocomponent.text = photocomponent.text + photocomponent.keyWord;// Add characters
				}
				switch (photocomponent.keyWord) {

				case KeyEvent.VK_ENTER:
					photocomponent.text = photocomponent.text + "\n";
					photocomponent.wrap_Legnth = photocomponent.textLegnth;
					photocomponent.wrap_y = photocomponent.textHeight
							+ photocomponent.wrap_y;
					// when the enter key is pressed, add the height of the text

				case KeyEvent.VK_BACK_SPACE:
					photocomponent.text = photocomponent
							.BackSpace(photocomponent.text);
					// remove last characters
					// System.out.println(BackSpace(text));

				}

			}
			e.consume();
			repaint();
			// System.out.println(y+","+wrap_y + "," + wrap_y1 + ","+
			// image.getHeight());
		}

		public void keyReleased(KeyEvent e) {
		}

	};
	/***************************Photo viewer mode(default)***********************/
	private ActionListener photoListener = new ActionListener() {

		@Override
		public void actionPerformed(ActionEvent e) {
			FileNameExtensionFilter filter = new FileNameExtensionFilter(
				"Image Files", "jpg", "png", "gif", "jpeg");
			JFileChooser chooser = new JFileChooser();
			chooser.setFileFilter(filter);
			int returnVal = chooser.showOpenDialog(null);
			if (returnVal == JFileChooser.APPROVE_OPTION) {
				fileName = chooser.getSelectedFile().getName();
				StatutLabel.setText("You chose to open this file: "
					+ chooser.getSelectedFile().getPath());
				fileName = chooser.getSelectedFile().getPath();
				try {
					img = ImageIO.read(new File(fileName));
					photocomponent = new RootNode(img);
					photocomponent.addMouseListener(sourisListener);
					photocomponent.addMouseMotionListener(sourisMotionListener);

					// photocomponent.requestFocusInWindow();
					JScrollPane ScrollPane = new JScrollPane(photocomponent);
					// Display the ScrollBar when needed
					ScrollPane.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
					ScrollPane.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED);
					ScrollPane.setPreferredSize(new Dimension(800, 600));
					// set background of area of scrollPane
					ScrollPane.getViewport().setBackground(Color.LIGHT_GRAY);

					// remove remain label
					mainPanel.remove(MainLabel);
					mainPanel.add(ScrollPane);
					mainPanel.requestFocus();
					mainPanel.setFocusable(true);
					ScrollPane.addKeyListener(myKeyListener);
					mainPanel.addKeyListener(myKeyListener);
				} catch (IOException e1) {
					e1.printStackTrace();
					}
				}
			
			}
		
		};
		public void browersList() {

			mainPanel.removeAll();
			mainPanel.add(jsp);
			browserPanel.requestFocus();
			browserPanel.setFocusable(true);
			repaint();
		}
	public PhotoBrowser() {

		super("Photo Browser");

		Container pane = getContentPane();
		pane.setLayout(new BorderLayout());
		//mainPanel.setLayout(new );

		// align Jlabel to the right of JPanel
		bottomPanel.setLayout(new FlowLayout(FlowLayout.RIGHT));

		// set the menu
		this.setTitle("File");
		this.setJMenuBar(MainMenuBar);
		// this.setResizable(false);

		// add the menu
		JMenu FileMenu, ViewMenu;
		FileMenu = new JMenu("File");
		ViewMenu = new JMenu("View");

		MainMenuBar.add(FileMenu);
		MainMenuBar.add(ViewMenu);

		// add option to menu
		JMenuItem ImportFileOption, DeleteOption, QuitOption, ImportFolderOption;
		ImportFileOption = new JMenuItem("Open File");
		ImportFolderOption = new JMenuItem("Open Folder");

		DeleteOption = new JMenuItem("Delete");
		QuitOption = new JMenuItem("Quit");
		FileMenu.add(ImportFileOption);
		FileMenu.addSeparator();
		FileMenu.add(ImportFolderOption);
		FileMenu.addSeparator();
		FileMenu.add(DeleteOption);
		FileMenu.addSeparator();
		FileMenu.add(QuitOption);

		JRadioButton PhviewOption, BrowOption, SplitOption;
		PhviewOption = new JRadioButton("Photo viewer");
		BrowOption = new JRadioButton("Browser");
		SplitOption = new JRadioButton("Split mode");

		// Add all radio buttons to button group
		ButtonGroup ViewGroup = new ButtonGroup();
		ViewGroup.add(PhviewOption);
		ViewGroup.add(BrowOption);
		ViewGroup.add(SplitOption);

		// Add all radio buttons to view menu
		ViewMenu.add(PhviewOption);
		ViewMenu.addSeparator();
		ViewMenu.add(BrowOption);
		ViewMenu.addSeparator();
		ViewMenu.add(SplitOption);

		// add ActionListener to File menu
		ImportFileOption.addActionListener(photoListener);
		///////////////////////////Browser mode///////////////////////////////

		ImportFolderOption.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {

				JFileChooser folderchooser = new JFileChooser();
				folderchooser.setFileSelectionMode(JFileChooser.DIRECTORIES_ONLY);
				folderchooser.setAcceptAllFileFilterUsed(false);
				
				// array of supported extensions
				String[] filetypes = new String[]{"gif", "png", "bmp","jpg","jpeg","GIF","TIFF","ICO","BMP" // and other formats you need
				    };
				// filter to identify images based on their extensions
				FilenameFilter IMAGE_FILTER = new FilenameFilter() {
					@Override
					public boolean accept(final File dir, final String name) {
						for (final String type : filetypes) {
							if (name.endsWith("." + type)) {
				                    return (true);
				                }
				            }
				        return (false);
				        }
				    };
					/////////////////////////BrowserMode add a folder/////////////////////////////////
				int returnVal = folderchooser.showOpenDialog(null);
				if (returnVal == JFileChooser.APPROVE_OPTION) {
					
					fileName = folderchooser.getSelectedFile().getPath();
					StatutLabel.setText("You chose to open the folder: " + fileName);
					// File representing the folder that you select using a FileChooser
					File dir = new File(fileName);
		        	imagesLabel = new JLabel[dir.listFiles(IMAGE_FILTER).length];//Initialize a JLabel array    	
		        	for (int i = 0; i < imagesLabel.length; i++) {//add all pictures
		    			imagesLabel[i] = new JLabel();
		    			browserPanel.add(imagesLabel[i]);
		    		}
					if (dir.isDirectory()) { // make sure it's a directory
						FilesList = dir.listFiles(IMAGE_FILTER);
						int nbRow= (int)Math.ceil((double)FilesList.length/4);//calculate the nomber of row
						browserPanel.setLayout(new GridLayout(nbRow, 5, 20, 20));

						for (int i = 0; i < FilesList.length; i++) {
		            		imagesLabel[i].setIcon(new ImageIcon(FilesList[i].toString()));//关键，每个图片加到Label上
			        		imagesLabel[i].addMouseListener(MouseImagesFolderAction);
			        		//set the image path as label's name
			        		imagesLabel[i].setName(FilesList[i].toString());//String.valueOf(i)
			        		resizeIcon(new ImageIcon(FilesList[i].toString()), imagesLabel[i]);
			            }
			        }
					jsp = new JScrollPane();
					jsp.getViewport().add(browserPanel);
					jsp.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
					jsp.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED);
					// set background of area of scrollPane
					jsp.getViewport().setBackground(Color.LIGHT_GRAY);
					browersList();
				}	   
			}
		});
		DeleteOption.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				mainPanel.removeAll();// remove all photos
				repaint();
				mainPanel.add(MainLabel);
			}
		});
		QuitOption.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				System.exit(0);// exit the application
			}
		});

		// add ActionListener to three radio buttons of view menu
		PhviewOption.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				StatutLabel.setText("Photo viewer mode");

			}
		});
		BrowOption.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				StatutLabel.setText("Browser mode");
				browersList();

			}
		});
		SplitOption.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				StatutLabel.setText("Split mode");
			}
		});

		// add ActionListener to different categories of photos
		FamilyMode.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				StatutLabel.setText("Family photos");
			}
		});
		VacationMode.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				StatutLabel.setText("Vacation photos");
			}
		});
		Schoolmode.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				StatutLabel.setText("School photos");
			}
		});

		// The Main Window
		pane.setPreferredSize(new Dimension(1000, 800));
		pane.add(mainPanel, BorderLayout.CENTER);
		pane.add(bottomPanel, BorderLayout.SOUTH);

		// The Main Panel
		mainPanel.setBackground(mainPanelColor);
		mainPanel.setPreferredSize(new Dimension(1000, 200));
		// The tools Panel
		toolsPanel.setBackground(mainPanelColor);
		toolsPanel.setLayout(new BoxLayout(toolsPanel, BoxLayout.PAGE_AXIS));
		toolsPanel.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
		// toolsPanel.setPreferredSize(new Dimension(150, 500));
		// Create the left tools menu
		mode = "Text";
		ButtonGroup group = new ButtonGroup();
		toolsPanel.add(createMode("Select/Move", group));
		toolsPanel.add(createMode("Path", group));
		toolsPanel.add(createMode("Text", group));
		toolsPanel.add(createMode("Rectangle", group));
		toolsPanel.add(createMode("Ellipse", group));
		toolsPanel.add(createMode("Line", group));
		toolsPanel.addMouseListener(sourisListener);
		toolsPanel.add(Box.createVerticalStrut(30));
		fill = createColorSample(Color.LIGHT_GRAY);
		toolsPanel.add(fill);
		toolsPanel.add(Box.createVerticalStrut(10));
		outline = createColorSample(Color.BLACK);
		toolsPanel.add(outline);
		toolsPanel.add(Box.createVerticalStrut(30));
		backward.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				browersList();
			}
			
		});
		toolsPanel.add(Box.createVerticalStrut(10));
		toolsPanel.add(backward);

		// The status bar
		StatutLabel.setFont(new Font("Serif", Font.PLAIN, 16));
		StatutLabel.setForeground(Color.black);
		// The main label
		MainLabel.setFont(new Font("Serif", Font.PLAIN, 56));
		MainLabel.setForeground(mainLabelColor);
		MainLabel.setText("File -> Import to choose a photo");
		mainPanel.add(MainLabel);

		bottomPanel.setBackground(bottomColor);
		bottomPanel.setPreferredSize(new Dimension(1000, 23));
		bottomPanel.add(StatutLabel);
		// The Tool bar
		JToolBar jToolBar = new JToolBar("my tool bar");
		// Set the tool bar movable
		jToolBar.setFloatable(true);
		// Add the JToggleButton represent different categories of photos
		jToolBar.add(FamilyMode);
		jToolBar.add(VacationMode);
		jToolBar.add(Schoolmode);

		pane.add(jToolBar, BorderLayout.NORTH);
		setLocation(150, 0);

		pack();
	}

	public static void main(String[] args) {
		PhotoBrowser PB = new PhotoBrowser();
		PB.pack();
		PB.setVisible(true);
		PB.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

	}
}
