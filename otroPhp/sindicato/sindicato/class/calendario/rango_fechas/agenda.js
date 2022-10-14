function fHoliday(y,m,d) {
	var rE=fGetEvent(y,m,d), r=null;

	// you may have sophisticated holiday calculation set here, following are only simple examples.
	if (m==1&&d==1)
		r=[" Ene 1, "+y+" \n Feliz Año Nuevo! ",gsAction,"skyblue","red"];
	else if (m==1&&d==6)
		r=[" Ene 6, "+y+" \n Santos Reyes ",gsAction,"skyblue","red"];
	else if (m==3&&d==19)
		r=[" Mar 19, "+y+" \n Día del Padre ",gsAction,"skyblue","red"];
	else if (m==5&&d==1)
		r=[" May 1, "+y+" \n Día del Trabajador Boliviano ",gsAction,"skyblue","red"];
	else if (m==5&&d==27)
		r=[" May 27, "+y+" \n Día de la Madre Boliviana ",gsAction,"skyblue","red"];
	else if (m==6&&d==6)
		r=[" Jun 6, "+y+" \n Día del Maestro, Docente ",gsAction,"skyblue","red"];
	else if (m==8&&d==6)
		r=[" Ago 6, "+y+" \n Día de la Patria ",gsAction,"skyblue","red"];
	else if (m==8&&d==17)
		r=[" Ago 17, "+y+" \n Día de la Bandera Boliviana ",gsAction,"skyblue","red"];
	else if (m==9&&d==14)
		r=[" Sep 14, "+y+" \n Efemérides de Cochabamba ",gsAction,"skyblue","red"];
	else if (m==8&&d==6)
		r=[" Sep 21, "+y+" \n Día del Estudiante ",gsAction,"skyblue","red"];
	else if (m==11&&d==1)
		r=[" Nov 1, "+y+" \n Día de los Difuntos ",gsAction,"skyblue","red"];
	else if (m==12&&d==25)
		r=[" Dic 25, "+y+" \n Feliz Navidad! ",gsAction,"skyblue","red"];
	return rE?rE:r;	// favor events over holidays
}


