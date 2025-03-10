(function(){
	flatpickr("#date",{disableMobile:!0}),
	flatpickr("#datetime",{enableTime:!0,dateFormat:"Y-m-d H:i",disableMobile:!0}),
	flatpickr("#humanfrienndlydate",{altInput:!0,altFormat:"F j, Y",dateFormat:"Y-m-d",disableMobile:!0}),
	flatpickr("#daterange",{mode:"range",dateFormat:"Y-m-d",disableMobile:!0}),
	flatpickr("#timepikcr",{enableTime:!0,noCalendar:!0,dateFormat:"H:i",disableMobile:!0}),
	flatpickr("#timepickr1",{enableTime:!0,noCalendar:!0,dateFormat:"H:i",time_24hr:!0,disableMobile:!0}),
	flatpickr("#limittime",{enableTime:!0,noCalendar:!0,dateFormat:"H:i",minTime:"16:00",maxTime:"22:30",disableMobile:!0}),
	flatpickr("#limitdatetime",{enableTime:!0,minTime:"16:00",maxTime:"22:00",disableMobile:!0}),
	flatpickr("#inlinecalendar",{inline:!0,disableMobile:!0}),
	flatpickr("#weeknum",{weekNumbers:!0,disableMobile:!0}),
	flatpickr("#inlinetime",{inline:!0,enableTime:!0,noCalendar:!0,dateFormat:"H:i",disableMobile:!0}),
	flatpickr("#pretime",{enableTime:!0,noCalendar:!0,dateFormat:"H:i",defaultDate:"13:45",disableMobile:!0})
})();
