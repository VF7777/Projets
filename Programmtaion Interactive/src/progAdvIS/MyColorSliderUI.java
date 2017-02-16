package progAdvIS;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.LinearGradientPaint;
import java.awt.Rectangle;
import java.awt.RenderingHints;
import java.awt.geom.Point2D;

import javax.swing.JSlider;
import javax.swing.plaf.basic.BasicSliderUI;

/** Slider pour changer la couleur*/

public class MyColorSliderUI extends BasicSliderUI{
	private int thumbHeight = 22;//pointeur height
    private int thumbWidth = 22;//pointeur width

    public MyColorSliderUI(JSlider b) {
        super(b);
    }

    @Override
    protected Dimension getThumbSize() {
        return new Dimension(thumbHeight, thumbWidth);
    }

    @Override
    public void paintTrack(Graphics g) {
        Graphics2D g2d = (Graphics2D) g;
        Rectangle r = trackRect;
        r.setSize(40, 200);
        
        float[] dist = { 0.0f,0.2f, 0.4f, 0.6f, 0.8f, 1.0f };
        /*
        * Produces a gradient through the rainbow: violet, blue, green, yellow,
        * orange, red
        */
        r.x =0;
        r.y =0;
        Color[] colors = {new Color(181, 32, 255), Color.blue, Color.green,
                Color.yellow, Color.orange, Color.red};
        Point2D start = new Point2D.Float(r.x+r.width, r.y);
        //System.out.println("x"+r.x+"y"+r.y);
        Point2D end = new Point2D.Float(r.x+r.width, r.y + r.height);
        //Dessiner le fond de Color Slider
        LinearGradientPaint p = new LinearGradientPaint(start, end, dist,
                colors);
        g2d.setPaint(p);
        g2d.fill(r);
    }
    

    @Override
    public void paintThumb(Graphics g) {//Dessiner le pointeur
	    if (slider.getOrientation() == JSlider.VERTICAL) {
	        Graphics2D g2 = (Graphics2D) g;
	        g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
	        g2.setPaint(Color.black);
	        int x = thumbRect.x + thumbRect.width / 2 - 2;
	        int y = thumbRect.y;
	        int w = 50;//width
	        int h = thumbRect.height+5;//hight
	        g2.fill3DRect(x-16, y, w, h-20, true);
	      } else {
	        super.paintThumb(g);
	      }
	    }

}
