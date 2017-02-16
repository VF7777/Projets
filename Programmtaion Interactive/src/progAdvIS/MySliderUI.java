package progAdvIS;

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.Polygon;
import java.awt.Rectangle;
import java.awt.RenderingHints;

import javax.swing.JSlider;
import javax.swing.plaf.basic.BasicSliderUI;
/** Slider pour changer la taille de trait*/

public class MySliderUI extends BasicSliderUI {


	public MySliderUI(JSlider slider) {
		super(slider);
	}

	public void getCurrentColor(int point) {

	}

	@Override
	public void paintTrack(Graphics g) {//dessiner le trajectoire
	    int cy, cw;
	    Rectangle trackBounds = trackRect;
	    if (slider.getOrientation() == JSlider.VERTICAL) {
	      Graphics2D g2 = (Graphics2D) g;
	      cy = -2 + trackBounds.height / 2;
	      cw = trackBounds.width;

	   // Paramètres Anti-aliasing
	      g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
	      g2.translate(trackBounds.x, trackBounds.y + cy);//changer la position de JSlider
	 
	   // Dessin de fond de piste (black)
	      g2.setPaint(Color.black);
	      Polygon polygon1 = new Polygon();
	      polygon1.addPoint(8, cy+16);//l'angle bas de triangle
	      //polygon1.addPoint(cw, cy);
	      polygon1.addPoint(-2, -cy-7);//supérier gauche coin
	      polygon1.addPoint(cw+2, -cy-7);//supérier droit coin
	      g2.fillPolygon(polygon1);
	 
	    //Dessin Bordure noire
	      g2.setPaint(Color.black);
	    //g2.drawPolygon(polygon1);
	 
	      g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_OFF);
	      g2.translate(-trackBounds.x, -(trackBounds.y + cy));//La position de pointeur
	    } else {
	      super.paintTrack(g);
	    }
	  }

	@Override
	public void paintThumb(Graphics g) {//Dessiner le pointeur
	    if (slider.getOrientation() == JSlider.VERTICAL) {
	        Graphics2D g2 = (Graphics2D) g;
	        g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
	        g2.setPaint(Color.lightGray);
	        int x = thumbRect.x + thumbRect.width / 2 - 2;
	        int y = thumbRect.y;
	        int w = 40;//width
	        int h = thumbRect.height;//hight
	        g2.fill3DRect(x-17, y, w, h-5, true);
	      } else {
	        super.paintThumb(g);
	      }
	    }

}
