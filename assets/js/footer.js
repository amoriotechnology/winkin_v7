$(document).ready(function() {
    
    if("<?= $this->session->flashdata('wishes'); ?>" == 'Popup') {
        $('#wishesModal').modal('show');
    }
    
    $('#wish_form').submit(function(e) {
        e.preventDefault();

        var bdata = [];
        var adata = [];
        $("input[type=checkbox][name='bday_wish[]']:checked").each(function() {
            bdata.push($(this).val());
        });

        $("input[type=checkbox][name='anni_daywish[]']:checked").each(function() {
            adata.push($(this).val());
        });

        $('.wish-error').html('');
        if(bdata == '' && adata == '') {
            $('.wish-error').html('Select any persons');
        }

        if(bdata != "" || adata != "") {
            $.ajax({
                url: 'send_wishes',
                type: 'post',
                data : $(this).serialize(),
                dataType: 'json',
                success : function (res) {

                    if(res.status == 200) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Sent Successfully!!',
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if(result.isConfirmed) { location.reload(); }
                        });
                        
                    } else {
                        Swal.fire({
                            title: 'Failed!',
                            text: 'SentSomething Went wrong',
                            icon: 'error',
                            confirmButtonText: 'Try Again',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if(result.isConfirmed) { location.reload(); }
                        });
                    }
                },
                error : function(xhr, status, error) { console.log(xhr.responseText); }
            });
        }
    });
    
});

function TimeAlign(timeArray) {
    var checkArray = $.isArray(timeArray);
    if(checkArray != true) {
        var strArray = timeArray.replace(/["\[\]]/g, "");
        var timeArray = strArray.split(",");
        var checkArray = $.isArray(timeArray);
    }
    if(checkArray == true) {
        timeArray.sort(function(a, b) {
        // Function to convert time string to a Date object
            function convertToMinutes(time) {
                var timeParts = time.match(/(\d+):(\d+) (AM|PM)/);
                var hours = parseInt(timeParts[1], 10);
                var minutes = parseInt(timeParts[2], 10);
                var period = timeParts[3];
                if (period === "PM" && hours !== 12) {
                    hours += 12;
                }
                if (period === "AM" && hours === 12) {
                    hours = 0;
                }
                return hours * 60 + minutes; // Convert to minutes
            }
            return convertToMinutes(a) - convertToMinutes(b);
        });
    }
    return timeArray;
}

function arrayAlign(arrayValue) {
    var check = $.isArray(arrayValue);
    if(check == true) {
        arrayValue.sort(function(a, b) {
            let timeA = new Date('01/01/2000 ' + a[3]);
            let timeB = new Date('01/01/2000 ' + b[3]);
            return timeA - timeB;
        });
        return arrayValue;
    } else {
        return arrayValue;
    }
}

function MinutesToHour(minutes) {
    var Hours = parseInt(parseFloat(minutes) / 60);
    var Mints = (parseFloat(minutes) - (Hours * 60));
    var Hour = (Hours < 9) ? '0'+Hours : Hours;
    var Mins = (Mints < 9) ? '0'+Mints : Mints;
    return Hour+':'+Mins;
}

function DisplayTime(time, duration) 
{
    var d = new Date('2000-01-01 ' + time);
    d.setMinutes(d.getMinutes() + duration);
    var hours = d.getHours() % 12 || 12; 
    var minutes = d.getMinutes().toString().padStart(2, '0'); 
    var period = d.getHours() >= 12 ? 'PM' : 'AM'; 
    var timestru = hours.toString().padStart(2, '0') + ':' + minutes + ' ' + period;
    return timestru;
}

/*----------- Validate numbers only use number & str length ------------*/
function NumberOnly(input, maxLength) {
    input.value = input.value.replace(/\D/g, '');
    if (input.value.length > maxLength) { input.value = input.value.slice(0, maxLength); }
}


function AlphaOnly(input, maxLength = 0) {
    input.value = input.value.replace(/[^a-zA-Z]/g, '');
    if (input.value.length > maxLength && maxLength != 0) {
        input.value = input.value.slice(0, maxLength);
    }
}

function AlphaWithSpaces(input, maxLength = 0) {
    input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Allow letters and spaces
    if (maxLength > 0 && input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}



/*----------- Validate numbers only use number, dot & str length ------------*/
function AmtOnly(input, maxLength) {
    input.value = input.value.replace(/[^0-9.]/g, '');
    
    if ((input.value.match(/\./g) || []).length > 1) {
        input.value = input.value.replace(/\.(?=.*\.)/g, '');
    }
    
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}


/*----------- Validate email ------------*/
function IsEmail(email) {
    const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}


flatpickr(".daterange",{
    dateFormat:"M d/Y",
    disableMobile:!0,
    maxDate: "today",
});

function displayDate(date) {

    var displayDate = "";
    if(date != null && date != "0000-00-00" && date != "0000-00-00 00:00:00") {
        var length = date.length;
        var curDate = new Date(date);
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        var Day = curDate.getDate();
        Day = Day < 10 ? '0' + Day : Day;
        
        var Month = (curDate.getMonth() + 1);
        Month = Month < 10 ? '0' + Month : Month;

        var Year = curDate.getFullYear();

        displayDate =  Day + '/' + Month + '/' + Year;
        if(length > 11) {
            displayDate = Day + '/' + Month + '/' + Year + ' ' + curDate.toLocaleString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        }
    }
    return displayDate;
}

function displayDateOnly(date) {

    var displayDate = "";
    if(date != null && date != "0000-00-00" && date != "0000-00-00 00:00:00") {
        var length = date.length;
        var curDate = new Date(date);
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        var Day = curDate.getDate();
        Day = Day < 10 ? '0' + Day : Day;
        
        var Month = (curDate.getMonth() + 1);
        Month = Month < 10 ? '0' + Month : Month;

        var Year = curDate.getFullYear();

        displayDate =  Day + '/' + Month + '/' + Year;
        if(length > 11) {
            displayDate = Day + '/' + Month + '/' + Year;
        }
    }
    return displayDate;
}


function dbDate(date) {

    var dbDate = "";
    if(date != null && date != "0000-00-00" && date != "0000-00-00 00:00:00") {
        var length = date.length;
        var curDate = new Date(date);

        var Day = curDate.getDate();
        Day = Day < 10 ? '0' + Day : Day;

        var Month = (curDate.getMonth() + 1);
        Month = Month < 10 ? '0' + Month : Month;

        var Year = curDate.getFullYear();
        var Hour = curDate.getHours();

        Hour = Hour < 10 ? '0' + Hour : Hour;
        var Minute = curDate.getMinutes();
        Minute = Minute < 10 ? '0' + Minute : Minute;

        dbDate =  Year + '-' + Month + '-' + Day;
        if(length > 11) {
            dbDate = Year + '-' + Month + '-' + Day + ' ' + Hour + ':' + Minute;
        }
    }
    return dbDate;
}


/* -------- When submit form validate the fields --------- */
function validation(values) {

    var key = Object.keys(values);
    var value = Object.values(values);
    var action = true;

    for(var i = 0; i < value.length; i++) {

        $('#' + key[i]).css('border', '');
        var element = $('#' + key[i]).parent().children('span');
        var ext_element = $('#' + key[i]).parent().parent().children('span');
        element.html(''); ext_element.html('');

        if(value[i] == "") {
            $('#' + key[i]).css('border', '1px solid red');
            element.html('This information is required');
            ext_element.html('This information is required');
            action = false;
        }

        if(preg_match(/email/, key[i]) && value[i] != "" && IsEmail(value[i]) === false) {
            element.html('Please enter a valid email address');
            ext_element.html('Please enter a valid email address');
            action = false;
        }

        if(preg_match(/phone/, key[i]) && value[i] != "" && value[i].length <= 9) {
            element.html('Phone number should contain 10 digits');
            ext_element.html('Phone number should contain 10 digits');
            action = false;
        }

        if(preg_match(/password/, key[i]) && value[i] != "" && value[i].length <= 5) {
            element.html('Password should contain 6 character');
            ext_element.html('Password should contain 6 character');
            action = false;
        }

        if(preg_match(/pwd/, key[i]) && value[i] != "" && value[i].length <= 5) {
            element.html('Password should contain 6 character');
            ext_element.html('Password should contain 6 character');
            action = false;
        }
    }
    return action;
}


/* ----- remove red line border and error message ------ */
function removeValidation(values) {
    var key = Object.keys(values);
    var value = Object.values(values);

    for(var i = 0; i < value.length; i++) {

        $('#' + key[i]).css('border', '');
        var element = $('#' + key[i]).parent().children('span');
        var ext_element = $('#' + key[i]).parent().parent().children('span');
        element.html(''); ext_element.html('');
    }
    return true;
}

function getdetails(url, datas, input_id) {
    $.ajax({
        url: url,
        type: 'post',
        data: datas,
        success: function(res) { $('#'+input_id).append(res); },
        error: function(xhr, status, error) { console.log(error); }
    });
}

function restrictAmt(amount) {

    let total = 0;
    var element = $('.amount-error-msg').parent().children('span');

    $("input[type=checkbox][name='servs[]']:checked").each(function() {
        total += parseFloat($(this).data('rate')) || 0;
    });

    element.html('');
    var action = true;
    if (total > 0 && parseFloat(amount) > total) {
        element.html('Amount cannot exceed total rate of selected services.');
        action = false;
    }
    return action;
}

flatpickr(".dob_datepicker",{
    dateFormat:"d/m/Y",
    disableMobile:!0,
    maxDate: "Jan 01/2006",
});

flatpickr(".anni_datepicker",{
    dateFormat:"d/m/Y",
    disableMobile:!0,
    maxDate: "today",
});

function preg_match(regex, str) { return (new RegExp(regex).test(str)); }