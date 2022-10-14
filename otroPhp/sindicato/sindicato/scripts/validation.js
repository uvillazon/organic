function ValidTestimonial()
{
	
	for (var i=0;i < document.FrmTestimonial.elements.length;i++)
	{
		var element = document.FrmTestimonial.elements[i];		
		if(element.type=="text")
		{
			if(element.name=="TestimonialAuthor")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Author is required."); element.focus(); return false;
				}				
			}
			if(element.name=="tema")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Tema is required."); element.focus(); return false;
				}				
			}
		}
		if(element.type=="textarea")
		{
			if(element.name=="richEdit0")
			{
				var f=element.value;
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Testimonial is required."); return false;
				}				
			}
		}
	}//for
	document.FrmTestimonial.submit(); 
}
function ValidTestimonial1()
{
	
	for (var i=0;i < document.FrmTestimonial.elements.length;i++)
	{
		var element = document.FrmTestimonial.elements[i];		
		if(element.type=="text")
		{
			if(element.name=="nombre")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("requiere Nombre de iglesia."); element.focus(); return false;
				}				
			}
			if(element.name=="union")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Union is required."); element.focus(); return false;
				}				
			}
			
			if(element.name=="direccion")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Direccion is required."); element.focus(); return false;
				}				
			}
			if(element.name=="telefono")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Telefono is required."); element.focus(); return false;
				}				
			}
			if(element.name=="email")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Email is required."); element.focus(); return false;
				}				
			}
		}
		if(element.type=="textarea")
		{
			if(element.name=="vision")
			{
				var f=element.value;
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Vision is required."); return false;
				}				
			}
			if(element.name=="richEdit0")
			{
				var f=element.value;
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Testimonial is required."); return false;
				}				
			}
		}
	}//for
	document.FrmTestimonial.submit(); 
}
function ValidTestimonial2()
{
	
	for (var i=0;i < document.FrmTestimonial.elements.length;i++)
	{
		var element = document.FrmTestimonial.elements[i];		
		if(element.type=="text")
		{
			
			
			if(element.name=="direccion")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Direccion is required."); element.focus(); return false;
				}				
			}
			if(element.name=="telefono")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Telefono is required."); element.focus(); return false;
				}				
			}
			if(element.name=="email")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Email is required."); element.focus(); return false;
				}				
			}
		}
		if(element.type=="textarea")
		{
			if(element.name=="vision")
			{
				var f=element.value;
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Vision is required."); return false;
				}				
			}
			
		}
		
	}//for
	document.FrmTestimonial.submit(); 
}

function ValidContact()
{
	for (var i=0;i < document.FrmEMail.elements.length;i++)
	{
		var element = document.FrmEMail.elements[i];		
		if(element.type=="text")
		{
			if(element.name=="txtName")
			{
				var f=element.value
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Name is required."); element.focus(); return false;
				}				
			}
			else
				if(element.name=="txtEMail")
				{
					var f=element.value
					if (f.replace(/ /g, '')=="") 
					{ 
					  alert ("E-mail is required."); element.focus(); return false;
					}
					else
					{
						if(!ValidEMail(f))
						{
							alert ("E-mail is invalid."); element.focus(); return false;
						}
					}
				}
		}
		if(element.type=="textarea")
		{
			if(element.name=="txtMessage")
			{
				var f=element.value;
				if (f.replace(/ /g, '')=="") 
				{ 
				  alert ("Message is required."); return false;
				}				
			}
		}
	}//for
	document.FrmEMail.submit(); 
}
function ValidEMail(email){
    regx = /^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/;
    return regx.test(email);
}

function validateEmptyFeature() {
  if (document.formdesign.designname.value.length == 0) {
	  alert("There is no name for your design. Please fill in the name box and save again.");
	  return false;
  }
  return true;
}

function validateRoom(){
  if (document.formPackages.rooms.selectedIndex == 0) {
	  alert("Pick one room from the list.");
	  return false;
  }
  return true;
}
//change dropdown in DB
function Dochange(num,obj){
  ajax('popup','createdesign.php?action=savePackNumber&id=' + num + '&obj=' + obj,''); 
  return false;
}

function makeFilter(id,dpId,filter){
  ajax('popup','createdesign.php?action=listPackItems&id=' + id +'&dpId=' + dpId + '&filter=' + filter,''); 
  return false;
}

function makefilter2(){
  var x = document.form1.filter.value;
  window.location.href = "./designcenter.php?filter=" + x;
  return false;
}

function validateChangePassword()
{
    oNewPassword = document.forms.change_password_form.new_password;
    oRePassword = document.forms.change_password_form.re_password;
    oOldPassword = document.forms.change_password_form.old_password;
    
    if (oNewPassword == null)  return false;
    
    if (oOldPassword.value.length == 0)
	{
	    alert ("Please fill in your old password.");
		oOldPassword.focus();
		return false;
	}
    
    if (oNewPassword.value.length > 0)
	{
	    if (oRePassword.value.length == 0)
	    {
	       alert("Please retype your new password");
	       oRePassword.focus();
	       return false;
	    }
		if ((oNewPassword.value.length < 6) || (oNewPassword.value.length > 30))
		{
            alert ("Password must have between 6 and 30 characters.");
            oNewPassword.focus();
            return false;
		}
        if (oNewPassword.value != oRePassword.value)
        {
            alert ("The passwords you provided do not match, please fill them again.");
            oNewPassword.focus();
            return false;
        }
	}
	else
	{
		alert ("Please fill in your new password.");
		oNewPassword.focus();
		return false;
	}
	
	//question 1
   
    return true;
}
