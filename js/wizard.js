$(document).ready(function() {
    // Smart Wizard   
	$('#wizard').smartWizard({
			onFinish:onFinishCallback	
	  }); 
	
    function onFinishCallback() {
		$('#wizard').smartWizard('showMessage', 'Finish Clicked');    
        alert('Finish Clicked');
    }

	$("#p-b").click(function() {
		
	});


});