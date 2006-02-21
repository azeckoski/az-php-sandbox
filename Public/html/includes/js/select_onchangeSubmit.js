function initSelect()
{
	var theSelect = document.getElementById("type");
	
	theSelect.changed = false;
	theSelect.onfocus = selectFocussed;
	theSelect.onchange = selectChanged;
	theSelect.onkeydown = selectKeyed;
	theSelect.onclick = selectClicked;
	
	return true;
}




function selectChanged(theElement)
{
	var theSelect;
	
	if (theElement && theElement.value)
	{
		theSelect = theElement;
	}
	else
	{
		theSelect = this;
	}
	
	if (!theSelect.changed)
	{
		return false;
	}

	alert("The select has been changed to " + theSelect.value);
	
	return true;
}




function selectClicked()
{
	this.changed = true;
}




function selectFocussed()
{
	this.initValue = this.value;
	
	return true;
}




function selectKeyed(e)
{
	var theEvent;
	var keyCodeTab = "9";
	var keyCodeEnter = "13";
	var keyCodeEsc = "27";
	
	if (e)
	{
		theEvent = e;
	}
	else
	{
		theEvent = event;
	}

	if ((theEvent.keyCode == keyCodeEnter || theEvent.keyCode == keyCodeTab) && this.value != this.initValue)
	{
		this.changed = true;
		selectChanged(this);
	}
	else if (theEvent.keyCode == keyCodeEsc)
	{
		this.value = this.initValue;
	}
	else
	{
		this.changed = false;
	}
	
	return true;
}