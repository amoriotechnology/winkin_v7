<style type="text/css">
.fc-event-title { 
    font-size: 12px !important;
    font-weight: bold !important;
}    
</style>

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        	
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Calendar</h1>
        </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">

            <div class="col-xl-9">
                <div class="card custom-card">
                <div class="card-body">
                    <div id='admincalendar'></div>
                </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <h6 class="align-items-center"> 
                                <p> <span class="badge bg-danger">&nbsp;</span>&emsp;Leave </p>
                                <p> <span class="badge bg-warning">&nbsp;</span>&emsp;Holidays </p>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>
</div>
<!-- End::content  -->



<!-- Fullcalendar JS -->
<script src="<?= base_url('../assets/libs/fullcalendar/index.global.min.js'); ?>"></script>

<script type="text/javascript">

    var curdate = new Date();
    var holidays  = <?= $holiday_record; ?>;
    var attendance = <?= $attend_record; ?>;

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
                'start': attend_values[a]['fld_sadate'],
                'end': attend_values[a]['fld_sadate'],
                'title': attend_values[a]['fld_uname']+' - '+attend_values[a]['fld_staffid'],
                'description': 'Attendance',
                'app_id': attend_values[a]['fld_said'],
            });
        } else if(attend_values[a]['fld_sastatus'] == "L") {
            absent.push({
                'id': (a + 1),
                'start': attend_values[a]['fld_sadate'],
                'end': attend_values[a]['fld_sadate'],
                'title': attend_values[a]['fld_uname']+' - '+attend_values[a]['fld_staffid'],
                'description': 'Attendance',
                'app_id': attend_values[a]['fld_said'],
            });
        }
    }

    var calyear = curdate.getFullYear(), calmonth = (curdate.getMonth() + 1),

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

    var admincalendar = document.getElementById("admincalendar");
    var calendar = new FullCalendar.Calendar(admincalendar, {
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
        },
        select: function(info) {
            var selectedDate = info.startStr;
            // openEventPopup(selectedDate);
            $('#eventPopup').modal('show');
        },
        views: {
            dayGrid: {  },
        },
        initialView: "dayGridMonth",
        navLinks: false, /* for click week header date (Sun 12/5) */
        businessHours: true,
        selectable: true,
        selectMirror: true,
        droppable: false,
        eventClick: function(n) {},
        editable: false,
        dayMaxEvents: true,
        eventSources: [holiday_data, present_data, absent_data]
    }).render();

    function openEventPopup(selectedDate) {
         var popupHTML = `
            <!-- Modal HTML structure -->
            <div class="modal fade" id="eventPopup" tabindex="-1" aria-labelledby="eventPopupLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventPopupLabel">Add Event for ${selectedDate}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="eventForm">
                                <div class="form-group">
                                    <label for="eventTitle">Event Title</label>
                                    <input type="text" class="form-control" id="eventTitle" required>
                                </div>
                                <div class="form-group">
                                    <label for="eventDescription">Event Description</label>
                                    <textarea class="form-control" id="eventDescription" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Event</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append the popup to the body
        document.body.insertAdjacentHTML('beforeend', popupHTML);

        // Handle form submission
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var title = document.getElementById('eventTitle').value;
            var description = document.getElementById('eventDescription').value;

            // Add the new event to the calendar
            calendar.addEvent({
                title: title,
                start: selectedDate,
                end: selectedDate,
                description: description,
                allDay: true
            });

            closePopup();  // Close the popup after event is added
        });
    }

    // Function to close the popup
    function closePopup() {
        var popup = document.getElementById('eventPopup');
        if (popup) {
            popup.remove();
        }
    }

</script>