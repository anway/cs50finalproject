/***********************************************************************
 * scripts.js
 *
 * Computer Science 50
 * Problem Set 7
 *
 * Global JavaScript, if any.
 **********************************************************************/
/*resizes cells for day view. cells for overlapping events are in the same row and thus need to be the same size*/ 
function resizecells()
 {
    $(".tasks").each(function(){
        var num=$(this).find('td').index()+1;
        
        if (num>1)
            $(this).find('td').each(function(){
               
                var nm=(100.0/num)+"%";

                $(this).css({'width':num});
            })
    })
 };
