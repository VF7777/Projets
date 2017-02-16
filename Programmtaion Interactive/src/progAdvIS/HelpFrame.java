package progAdvIS;

import java.awt.Container;
import java.awt.Graphics;
import java.awt.Image;

import javax.swing.ImageIcon;
import javax.swing.JFrame;
import javax.swing.JPanel;

public class HelpFrame extends JFrame {

	private static final long serialVersionUID = 1L;
	Container ct;
	BackgroundPanel bgp;

	public HelpFrame() {
		ct = this.getContentPane();
		this.setLayout(null);

		bgp = new BackgroundPanel((new ImageIcon("./resources/HelpText.png")).getImage());
		bgp.setBounds(0, 0, 800, 500);
		ct.add(bgp);

		this.setSize(800, 500);
		this.setLocation(200, 200);
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		this.setVisible(true);
		setTitle("Use Help");

		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);

		setVisible(true);
	}

	class BackgroundPanel extends JPanel {

		private static final long serialVersionUID = 1L;
		Image im;

		public BackgroundPanel(Image im) {
			this.im = im;
			this.setOpaque(true);
		}

		// Draw the back ground.
		public void paintComponent(Graphics g) {
			super.paintComponents(g);
			g.drawImage(im, 0, 0, this.getWidth(), this.getHeight(), this);

		}
	}
}
