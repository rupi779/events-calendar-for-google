/*!
FullCalendar Events Listing

*/   

document.addEventListener('DOMContentLoaded', function() {
		
  var calendarEl = document.getElementById('gc_google_calender');
	var startdate =  events_objects.current_date; 
	var calendar_api =  events_objects.api; 
	var calendar_id = events_objects.id; 
  var timezone = events_objects.cal_timezone; 
  	
  var calendar = new FullCalendar.Calendar(calendarEl, {
    timeZone: timezone,
	//locale: 'es', for language intialization some day
    headerToolbar: {
	  left :'dayGridMonth,listMonth',
      center: 'title',
	  end: 'prev,today,next'
    },
  contentHeight: 'auto',

  initialDate: startdate,

  //displayEventTime: false,
  titleFormat: { year: 'numeric', month: 'short' } ,

  
  googleCalendarApiKey: calendar_api,
  events: calendar_id,

    eventClick: function(arg) {
      // opens events in a popup window
      window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');

      arg.jsEvent.preventDefault() // don't navigate in main tab
    },

    loading: function(bool) {
      document.getElementById('loading').style.display =
        bool ? 'block' : 'none';
    }

  });

  calendar.render();
});
  
  