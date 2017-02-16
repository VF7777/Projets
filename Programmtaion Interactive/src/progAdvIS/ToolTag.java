package progAdvIS;

import fr.lri.swingstates.canvas.CExtensionalTag;
import fr.lri.swingstates.canvas.CStateMachine;

class ToolTag extends CExtensionalTag {
	private CStateMachine tool;

	ToolTag(CStateMachine csm) {// set
		tool = csm;
	}

	CStateMachine getTool() {// get
		return tool;
	}
}