package progAdvIS;

import fr.lri.swingstates.canvas.CStateMachine;
import fr.lri.swingstates.sm.State;
import fr.lri.swingstates.sm.Transition;
import fr.lri.swingstates.sm.transitions.Drag;
import fr.lri.swingstates.sm.transitions.Press;
import fr.lri.swingstates.sm.transitions.Release;
@SuppressWarnings("unused")

public class HelpTool extends CStateMachine {

	public State start, draw;

	public HelpTool() {
		this(BUTTON1, NOMODIFIER);

	}

	public HelpTool(final int button, final int modifier) {
		start = new State() {
			Transition press = new Press(button, modifier, ">> draw") {};
		};
		draw = new State() {
			Transition draw = new Drag(button, modifier) {
				public void action() {}
			};
			Transition stop = new Release(button, modifier, ">> start") {
				public void action() {}
			};
		};
	}

}
