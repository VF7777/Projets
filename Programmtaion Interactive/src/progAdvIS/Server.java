package progAdvIS;

import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.Point;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.ServerSocket;
import java.net.Socket;

import fr.lri.swingstates.canvas.CEllipse;
import fr.lri.swingstates.canvas.CRectangle;
import fr.lri.swingstates.canvas.CShape;
import fr.lri.swingstates.canvas.Canvas;

public class Server {

	@SuppressWarnings({ "resource", "static-access" })
	public Server(Canvas canvas, SelectionTool selector,GestureTool gesture) {
		ServerSocket ss = null;
		try {
			ss = new ServerSocket(8888);
		} catch (IOException e1) {
			e1.printStackTrace();
		}
		System.out.println("server start....");
		while (true) {
			try {

				Socket s = ss.accept();
				System.out.println("client:"
						+ s.getInetAddress().getLocalHost()
						+ "has connected to server");

				BufferedReader br = new BufferedReader(new InputStreamReader(
						s.getInputStream()));
				//Receving the messages from client
				String mess = br.readLine();
				System.out.println("server side :" + mess);

				String[] sArray = mess.split("f");
				for (int i = 0; i < sArray.length - 1; i++) {

					String[] shape = sArray[i].split("s");
					Point p = new Point();
					switch (shape[0]) {

					case "0":
						System.out.println("rectangle at position (" + shape[1]
								+ "," + shape[2] + ") with width" + shape[3]
								+ " and height " + shape[4]);

						p.setLocation(
								Double.parseDouble(shape[1])
										- Double.parseDouble(shape[3]) / 2 ,
								Double.parseDouble(shape[2])
										- Double.parseDouble(shape[4]) / 2 );

						CRectangle e;
						e = canvas.newRectangle(p,
								Double.parseDouble(shape[3]),
								Double.parseDouble(shape[4]));
						String[] step1 = shape[5].split("=");
						String[] step2 = step1[1].split(",");
						String[] step3 = step1[2].split(",");
						String[] step4 = step1[3].split("]");

						e.setFillPaint(new Color(Integer.parseInt(step2[0]),
								Integer.parseInt(step3[0]), Integer
										.parseInt(step4[0])));

						String[] step5 = shape[7].split("=");
						String[] step6 = step5[1].split(",");
						String[] step7 = step5[2].split(",");
						String[] step8 = step5[3].split("]");

						e.setOutlinePaint(new Color(Integer.parseInt(step6[0]),
								Integer.parseInt(step7[0]), Integer
										.parseInt(step8[0])));
						e.setStroke(new BasicStroke(Integer.parseInt(shape[6])));

						Object[] shapes = selector.selectionTag.getCollection()
								.toArray();

						for (Object o : shapes) {
							CShape shape1 = (CShape) o;
							shape1.removeTag(selector.selectionTag);
						}
						
						Object[] shapes2 = gesture.selectionTag.getCollection().toArray();
						for (Object o : shapes) {
							CShape shape2 = (CShape) o;
							shape2.removeTag(gesture.selectionTag);
							}
						
						e.addTag(selector.baseTag)
								.addTag(selector.selectionTag);
						e.addTag(gesture.baseTag)
						.addTag(gesture.selectionTag);
						e.setReferencePoint(Integer.parseInt(shape[6]), 0);
						new ShapeCreatedEvent(canvas, e);
						break;

					case "1":
						System.out.println("Ellipse at position (" + shape[1]
								+ "," + shape[2] + ") with width" + shape[3]
								+ " and height " + shape[4]);
						p.setLocation(Double.parseDouble(shape[1]),
								Double.parseDouble(shape[2]));
						CEllipse ell;

						ell = canvas.newEllipse(p,
								Double.parseDouble(shape[3]),
								Double.parseDouble(shape[4]));

						String[] step11 = shape[5].split("=");
						String[] step12 = step11[1].split(",");
						String[] step13 = step11[2].split(",");
						String[] step14 = step11[3].split("]");

						// e.setStroke(new BasicStroke(shape[6]));

						ell.setFillPaint(new Color(Integer.parseInt(step12[0]),
								Integer.parseInt(step13[0]), Integer
										.parseInt(step14[0])));

						System.out.println(shape[7]);
						String[] step15 = shape[7].split("=");
						String[] step16 = step15[1].split(",");
						String[] step17 = step15[2].split(",");
						String[] step18 = step15[3].split("]");

						ell.setOutlinePaint(new Color(Integer
								.parseInt(step16[0]), Integer
								.parseInt(step17[0]), Integer
								.parseInt(step18[0])));
						ell.setStroke(new BasicStroke(Integer
								.parseInt(shape[6])));

						Object[] shapes1 = selector.selectionTag
								.getCollection().toArray();

						for (Object o : shapes1) {
							CShape shape1 = (CShape) o;
							shape1.removeTag(selector.selectionTag);
						}

						ell.addTag(selector.baseTag).addTag(
								selector.selectionTag);
						ell.setReferencePoint(Integer.parseInt(shape[6]), 0);

						new ShapeCreatedEvent(canvas, ell);
						break;

					}
				}

				BufferedWriter bw = new BufferedWriter(new OutputStreamWriter(
						s.getOutputStream()));
				bw.write("ok\n");
				bw.flush();

			} catch (IOException e) {
				e.printStackTrace();
			}
		}
	}
}