function printit(){  
if (window.print) {
    window.print() ;  
} else {
    var webbrowser = '<object id="webbrowser1" width=0 height=0 classid="clsid:8856f961-340a-11d0-a96b-00c04fd705a2"></object>';
document.body.insertadjacenthtml('beforeend', webbrowser);
    webbrowser1.execwb(6, 2);//use a 1 vs. a 2 for a prompting dialog box    webbrowser1.outerhtml = "";  
}
}

