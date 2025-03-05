(function() {
    
    /* ---------- holidays Datas ----------- */
    var holiday_keys = Object.keys(holidays);
    var holiday_values = Object.values(holidays);

    var bus_holidays = [];
    for(var h = 0; h < holiday_keys.length; h++) {
        bus_holidays.push({
            'id' : (h + 1),
            'start' : holiday_values[h]['fld_sadate'],
            'end' : holiday_values[h]['fld_sadate'],
            'title' : holiday_values[h]['fld_satitle'],
            'description' : 'Holiday',
            'app_id' : holiday_values[h]['fld_said'],
        });
    }


    /* ---------- Attendance Datas ----------- */
    var attend_keys = Object.keys(attendance);
    var attend_values = Object.values(attendance);

    var present = [], absent = [];
    for(var a = 0; a < attend_keys.length; a++) {

        if(attend_values[a]['fld_sastatus'] == 'P') {
            present.push({
                'id' : (a + 1),
                'start' : attend_values[a]['fld_sadate'],
                'end' : attend_values[a]['fld_sadate'],
                'title' : 'Present',
                'description' : 'Attendance',
                'app_id' : attend_values[a]['fld_said'],
            });
        } else if(attend_values[a]['fld_sastatus'] == "L") {
            absent.push({
                'id' : (a + 1),
                'start' : attend_values[a]['fld_sadate'],
                'end' : attend_values[a]['fld_sadate'],
                'title' : 'Leave',
                'description' : 'Attendance',
                'app_id' : attend_values[a]['fld_said'],
            });
        }
    }

    /* ---------- Appointment Datas ---------- */
    var appoint_keys = Object.keys(appointments);
    var appoint_values = Object.values(appointments);

    var appoints = [];
    for(var ap = 0; ap < appoint_keys.length; ap++) {
        appoints.push({
            'id' : (ap + 1),
            'start' : appoint_values[ap]['app_date'],
            'end' : appoint_values[ap]['app_date'],
            'title' : appoint_values[ap]['app_name'],
            'description' : appoint_values[ap]['app_serv'],
            'app_id' : appoint_values[ap]['app_id'],
            'app_servs' : appoint_values[ap]['app_serv'],
            'app_date' : displayDate(appoint_values[ap]['app_date']),
            'app_time' : appoint_values[ap]['app_time'],
            'app_sts' : appoint_values[ap]['app_sts'],
            'app_note' : appoint_values[ap]['app_note'],
            'app_cnote' : appoint_values[ap]['cnote'],
        });
    }

    var calyear = moment().format("YYYY"), calmonth = moment().format("MM"),

        app_data = {
            id: 1,
            className: "bg-info-transparent",
            textColor: "#000",
            events: appoints
        },
        holiday_data = {
            id: 2,
            className: "bg-warning-transparent",
            textColor: "#fff",
            events: bus_holidays
        },
        present_data = {
            id: 3,
            className: "bg-success-transparent",
            textColor: "#fff",
            events: present
        },
        absent_data = {
            id: 4,
            className: "bg-danger-transparent",
            textColor: "#fff",
            events: absent
        };


    var staffcalendar = document.getElementById("staffcalendar");
    new FullCalendar.Calendar(staffcalendar, {
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,listWeek"
        },
        initialView: "timeGridWeek",
        navLinks: false, /* for click week header date (Sun 12/5) */
        businessHours: !0,
        selectable: !0,
        selectMirror: !0,
        droppable: false,
        eventClick: function(n) {
            $('.app_detail').empty();
            var ele = n.event._def;
            var desc = ele.extendedProps.description;
            if(desc != "Holiday" && desc != "Attendance") {
                $('.app_detail').append('<li>'+
                            '<h5 class="mb-1 fw-medium"> #'+ ele.extendedProps.app_id + ' &nbsp;&nbsp;<span class="badge bg-info text-dark"> <b>' + ele.extendedProps.app_sts + '</b> </span> </h5>'+
                            '<div class="d-flex align-items-center justify-content-between flex-wrap">'+
                                '<h6 class="mb-1 fw-medium"> '+ ele.title +', '+ ele.extendedProps.app_date +'</h6>'+
                                '<span class="badge bg-light text-default mb-1">'+ ele.extendedProps.app_time +'</span>'+
                            '</div>'+
                            '<p class="mb-0 text-muted fs-12">'+ ele.extendedProps.description +'</p>'+
                            '<p class="mb-0 fs-12"> <b>Spcial Notes:</b> '+ ele.extendedProps.app_cnote +'</p>'+
                            '<p class="mb-0 fs-12"> <b>Service Notes:</b> '+ ele.extendedProps.app_note +'</p></li>');
            }
        },
        editable: false,
        dayMaxEvents: !0,
        eventSources: [app_data, holiday_data, present_data, absent_data]
    }).render();

    var p = document.getElementById("full-calendar-activity");
    new SimpleBar(p, { autoHide: !0 });
})();