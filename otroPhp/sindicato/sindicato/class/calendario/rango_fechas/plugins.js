function fOnload() {
	//fInitLayer();
}

var _startc,_endc;
function fStartPop(startc,endc) {
  _startc=startc;
  _endc=endc;
  var sd=fParseInput(endc.value); 
  if (!sd) sd=gEnd;
  fPopCalendar(startc, [gBegin,sd,sd]);
}

function fEndPop(startc,endc) {
  _startc=startc;
  _endc=endc;
  var sd=fParseInput(startc.value);
  if (!sd) sd=gBegin; 
  fPopCalendar(endc, [sd,gEnd,sd]);
}
