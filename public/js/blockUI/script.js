/*
	jQuery Document Ready
*/
$(function()
{
	/*
		We are using setTimeout so after defined millisecond
		page will be automatically unblocked
	*/	
	
	/*
		Default Page Block
	*/
	$('#default').click(function()
	{
		$.blockUI();
		setTimeout($.unblockUI, 2000);
	});
	
	/*
		adding custom block message
	*/	
	$('#custommessage').click(function()
	{
		$.blockUI(
		{
			/*
				message displayed when blocking (use null for no message)
			*/
			message: '<h1><img src="http://s13.postimg.org/80vkv0coz/image.gif" /> Please Wait Custom Message...</h1>'
		});
		setTimeout($.unblockUI, 3000);
	});
	
	/*
		adding element block with custom message and css
	*/
	      
	/*
		un block blocked element
	*/
	$('#unblockElement').click(function()
	{
		$('div.blockUI').unblock();
	});
	
	/*
		show login form in page block
	*/
	$('#loginButton').click(function()
	{
        $.blockUI(
		{
			/*
				giving DOM object as message will 
				show given DOM html as block message,
				In our case it will show login form
			*/
			message: $('#loginForm')
		});
 
        setTimeout($.unblockUI, 2000); 
    });
});