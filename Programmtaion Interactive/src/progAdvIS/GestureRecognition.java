package progAdvIS;

import fr.lri.swingstates.gestures.Gesture;
import fr.lri.swingstates.gestures.dollar1.Dollar1Classifier;

public class GestureRecognition {

  Dollar1Classifier classifier = null;
  
  public GestureRecognition () {
    
    classifier = Dollar1Classifier.newClassifier("rsc/vocabulaire.cl");
  }
  
  public String gestureRecognized (Gesture gesture) {
    String gc = null;
    try {
        gc = classifier.classify(gesture);
        //System.out.println("Recognized gesture: "+gc);
    } catch (Exception e) {
        e.printStackTrace();
    }
    return gc;
  }
  
}
