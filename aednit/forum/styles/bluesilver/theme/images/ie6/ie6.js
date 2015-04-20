/**
* based on  proFormell by marc1706
*/

$(document).ready(function(){
		replace_png();
});

function replace_png()
{
	// Fix forum icons
	$('.icon').each(function() {
		var str = $(this).css('background-image');
		if(str != '')
		{
			$(this).css('background-image', str.substring(0, str.length - 5) + 'gif")');
		}
	});
}

$(document).ready(function(){
	resize_images();
	// Image popup
	$('img', 'dt.attach-image').click(function(){
		image_load($(this).attr('src'), $(this).attr('alt'));
		centerImage();
	});
	
	$('.content img').click(function(){
		var check = $(this).parent().hasClass('content');
		if(check)
		{
			image_load($(this).attr('src'), $(this).attr('alt'));
			centerImage();
		}
	});

});

function resize_images()
{
	var hello = $('dl.attachbox dd dl.file dt.attach-image img').innerWidth();
	var maxWidth = $('div.content').innerWidth() - 30;
	
	// resize the attached images
	$('img', 'dt.attach-image').each(function(i){
		// check the width of the image
		if ($(this).width() > maxWidth)
		{
			// calculate new image dimensions
			newWidth = maxWidth;
			newHeight = $(this).height() / ( $(this).width() / maxWidth );
			   
			// set new image dimensions
			$(this).height(newHeight).width(newWidth);
		}
	});
	
	// resize the images that were added via [img] bbcode
	$('img', 'div.content').each(function(i){
		// check the width of the image
		$(this).css('max-width', maxWidth); // fix for IE
		if ($(this).width() > maxWidth)
		{
			// calculate new image dimensions
			newWidth = maxWidth;
			newHeight = $(this).height() / ( $(this).width() / maxWidth );
			   
			// set new image dimensions
			$(this).height(newHeight).width(newWidth);
		}
	});
}
