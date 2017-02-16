package progAdvIS;

import java.awt.BasicStroke;
import java.awt.Color;
import java.util.Hashtable;

import fr.lri.swingstates.canvas.CElement;
import fr.lri.swingstates.canvas.CExtensionalTag;
import fr.lri.swingstates.canvas.CRectangle;
import fr.lri.swingstates.canvas.CShape;

class SelectionTag extends CExtensionalTag {
	private Hashtable<CShape, CShape> marks;
	private CExtensionalTag marksTag;
	public SelectionTag() {
		super();
		marks = new Hashtable<CShape, CShape>();
		marksTag = new CExtensionalTag() {
		};
	}

	public void added(CShape s) {//Method called when this tag is added to an CShape.
		 //System.out.format("Adding SelectionTag to %s\n",s) ;

			CRectangle mark = s.getBoundingBox();//border
			s.getCanvas().addShape(mark);
			mark.setDiagonal(mark.getMinX() - 3, mark.getMinY() - 3,
					mark.getMaxX() + 3, mark.getMaxY() + 3);
			float dash[] = { 5.0f };
			mark.setStroke(new BasicStroke(1.0f, BasicStroke.CAP_BUTT,
					BasicStroke.JOIN_MITER, 10.0f, dash, 0.0f));
			mark.setFilled(false).setOutlinePaint(Color.RED).aboveAll();
			marks.put(s, mark);
			mark.addTag(marksTag);
		
	}

	public void removed(CShape s) {
		 System.out.format("Removing SelectionTag from %s\n",s) ;

			CShape mark = marks.get(s);
			mark.setOutlinePaint(Color.RED);
			mark.getCanvas().removeShape(mark);
			marks.remove(s);
		
	}

	public CElement translateBy(double tx, double ty) {
		reset();
		while (hasNext())
			(nextShape()).translateBy(tx, ty);
		marksTag.translateBy(tx, ty);
		return this;
	}
}