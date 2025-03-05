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

    $(".dot, .next").on("click", function(event) { 
		
		var timeselected = 0;
		$("input[name='times[]']:checked").each(function() {
			timeselected++;
		});

		$('.choose-time-error-msg').html('');
		var extslot = $("#existing_slot").val();
		if(extslot > 0 && parseInt(extslot) != timeselected) {
			wizard.lock();
			$('.choose-time-error-msg').focus();
            $('.choose-time-error-msg').html('<div class="alert alert-danger alert-dismissible fade show"> <b> Kindly select '+ extslot +' slots.</b> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button> </div>');
		} else {
			validateWizard(wizard, wizard.getCurrentStep()); 
		}
	});

})();


function validateWizard(wizard, steps) {

	switch (steps) {
	    case 0:
	    	var available_time = $("input[type=checkbox][name='times[]']:checked").val();
	    	if(available_time === undefined) {
	    		$('.choose-time-error-msg').focus();
	    		$('.choose-time-error-msg').html('<div class="alert alert-danger alert-dismissible fade show"> <b>Please select court available date & time</b> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button> </div>');
	    	 	var Final = wizard.lock() 
	    	} else {
	    		$('.choose-time-error-msg').html('');
	    	  	var Final = wizard.unlock();
	    	}
	    	return Final;
	    	break;	

	    case 1:
	    	var cust_name = $('input[name=cust_name]').val();
	        var cust_email = $('input[name=cust_email]').val();
	        var cust_phone = $('input[name=cust_phone]').val();

	        var action = validation({'cust_name' : cust_name, 'cust_email' : cust_email, 'cust_phone' : cust_phone});
	        var Final = (action === false) ? wizard.lock() : wizard.unlock();
	        return Final;
	    	break;	

	    case 1:
	    	var title = $('#sign-btn').data('title');
	    	
	    	if(title == "sign-in") {
	    		var cust_name   = $('input[name=cust_name]').val();
	    		var cust_lname   = $('input[name=cust_lname]').val();
		        var cust_email  = $('input[name=cust_email]').val();
		        var cust_phone  = $('input[name=cust_phone]').val();
		        var cust_pwd    = $('#cust_pwd').val();
		        
		        var action = validation({'cust_name':cust_name, 'cust_lname':cust_lname, 'cust_email':cust_email, 'cust_phone':cust_phone,'cust_pwd':cust_pwd});
	    	}

	    	if(title == "sign-up") {

	    		var signin_phone = $('#signin_phone').val();
		        var cust_password = $('#cust_password').val();
		        var action = validation({'signin_phone':signin_phone, 'cust_password':cust_password});
	    	}	    	

	    	// action = (ajax.responseJSON.status == 401) ? false : true;
	    	var Final = (action === false) ? wizard.lock() : wizard.unlock();
	    	return Final;
	    	break;

	    default:
	    	wizard.setStep(0);
    }

}