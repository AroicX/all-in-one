// const api = window.localStorage.getItem('cpurl')
let spEntryData = [];
$(window).on('load', function() {
        $('#external-events .fc-event').each(function() {
            $(this).data('event', {
                title: $.trim($(this).text()),
                stick: true
            });
            $(this).draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            });
        });
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            //defaultDate: '2018-08-12',
            editable: true,
            droppable: true,
            events: [{
                title: 'All Day Event',
                start: '2018-08-01',
                borderColor: '#04a9f5',
                backgroundColor: '#04a9f5',
                textColor: '#fff'
            }, {
                title: 'Long Event',
                start: '2018-08-07',
                end: '2018-08-10',
                borderColor: '#f44236',
                backgroundColor: '#f44236',
                textColor: '#fff'
            }, {
                id: 999,
                title: 'Repeating Event',
                start: '2018-08-09T16:00:00',
                borderColor: '#f4c22b',
                backgroundColor: '#f4c22b',
                textColor: '#fff'
            }, {
                id: 999,
                title: 'Repeating Event',
                start: '2018-08-16T16:00:00',
                borderColor: '#3ebfea',
                backgroundColor: '#3ebfea',
                textColor: '#fff'
            }, {
                title: 'Conference',
                start: '2018-08-11',
                end: '2018-08-13',
                borderColor: '#1de9b6',
                backgroundColor: '#1de9b6',
                textColor: '#fff'
            }, {
                title: 'Meeting',
                start: '2018-08-12T10:30:00',
                end: '2018-08-12T12:30:00'
            }, {
                title: 'Lunch',
                start: '2018-08-12T12:00:00',
                borderColor: '#f44236',
                backgroundColor: '#f44236',
                textColor: '#fff'
            }, {
                title: 'Happy Hour',
                start: '2018-08-12T17:30:00',
                borderColor: '#a389d4',
                backgroundColor: '#a389d4',
                textColor: '#fff'
            }, {
                title: 'Birthday Party',
                start: '2018-08-13T07:00:00'
            }, {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2018-08-28',
                borderColor: '#a389d4',
                backgroundColor: '#a389d4',
                textColor: '#fff'
            }],
            drop: function(date) {
                if ($('#drop-remove').is(':checked')) {
                    $(this).remove();
                }
                var data = JSON.parse($(this).attr('data-key'));
                  spEntryData = JSON.parse(data.data);
                  spEntryData['transaction_date'] = date.format()
                  console.log(spEntryData)
                  document.getElementById("sp-transaction-title").value = spEntryData.title;
                  document.getElementById("sp-trans-amount").value = spEntryData.amount;
                  
                  // document.getElementById("sp-transaction-category").value = sample_entry.transaction_category_id;
                  $('.edit-sample-entry-modal').modal('show');
                console.log(date.format())
            }
        });
    });

const addSpEntry = () => {
    spEntryData['title'] = document.getElementById("sp-transaction-title").value
    spEntryData['amount'] = document.getElementById("sp-trans-amount").value
    spEntryData['transaction_partner_id'] = document.getElementById("sp-transaction-partner").value
    console.log(spEntryData)
    console.log('add sp entry')
    $.ajax({
        type: "POST",
        url: `${api}/corpfin/addentry`,
        data: spEntryData,
        
        // dataType: "html",
        success: function (data) {
            console.log(data)
        }
    });
}