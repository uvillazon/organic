function checkAll(form)
{
    for(i=0; i < form.elements.length; i++) {
        if(form.elements[i].type == "checkbox")
        {
            form.elements[i].checked = true ;
        }
    }
}

function uncheckAll(form)
{
    for(i=0; i < form.elements.length; i++) {
        if(form.elements[i].type == "checkbox")
        {
            form.elements[i].checked = false ;
        }
    }
} 