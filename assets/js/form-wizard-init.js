(function() {

    let i = {
        wz_class: ".wizard-tab",
        highlight: true,
        highlight_time: 1000
    };

    const wizard = new Wizard1(i);
    wizard.init(), 

    flatpickr(".staffCalen", {
    	dateFormat:"M d/Y",
    	mode: 'single',
    	maxDate: 'today',
    	defaultDate: false,
    }), 

    flatpickr(".anniver", {
    	dateFormat:"M d/Y",
    	mode: 'single',
    	defaultDate: false,
    });

    /*document.querySelector("#appointment_form .next").addEventListener("click", function(event) {
        validateWizard(wizard, wizard.getCurrentStep());
    });*/

    $('.dot').parent('.wizard-step').on('click', function() {
    	validateWizard(wizard, wizard.getCurrentStep());
    });

    $('.prev').on('click', function() { wizard.unlock(); });

    $(".dot, .next").on("click", function(event) { validateWizard(wizard, wizard.getCurrentStep()); });

})();


function validateWizard(wizard, steps) {

	switch (steps) {
    	case 0:
    		var cust_name = $('input[name=cust_name]').val();
	        var cust_email = $('input[name=cust_email]').val();
	        var cust_phone = $('input[name=cust_phone]').val();
	        var cust_lname = $('input[name=cust_lname]').val();

	        var action = validation({'cust_name' : cust_name, 'cust_email' : cust_email, 'cust_phone' : cust_phone, 'cust_lname' : cust_lname});
	        var Final = (action === false) ? wizard.lock() : wizard.unlock();
	        return Final;
	    	break;

	    case 1:
	    	var serv = $("input[type=radio][name='admincourt']:checked").val();
	    	if(serv === undefined) {
	    		$('.choose-serv-error-msg').focus();
	    		$('.choose-serv-error-msg').html('<div class="alert alert-danger alert-dismissible fade show mb-4"> <b>Please choose any one court</b> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button> </div>');
	    	 	var Final = wizard.lock() 
	    	} else {
	    		$('.choose-serv-error-msg').html('');
	    	  	var Final = wizard.unlock();
	    	}
	    	return Final;
	    	break;

	    case 2:
	    	var time = $("input[type=checkbox][name='times[]']:checked").val();
	    	if(time === undefined) {
	    		$('.choose-time-error-msg').focus();
	    		$('.choose-time-error-msg').html('<div class="alert alert-danger alert-dismissible fade show mb-4"> <b>Please select timings you want</b> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button> </div>');
	    	 	var Final = wizard.lock() 
	    	} else {
	    		$('.choose-time-error-msg').html('');
	    	  	var Final = wizard.unlock();
	    	}
	    	return Final;
	    	break;
	    	
	    default:
	    	wizard.setStep(0);
    }

}