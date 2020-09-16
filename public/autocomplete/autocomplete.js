$( function() {
    var availableTags = [
"Land",
"Leasehold Improvement",
"Building",
"Motor Vehicle",
"Computers",
"Office Equipment",
"Furniture & Fittings",
"Other Equipment",
"Plant & Machinery",
"Other Facilities",
"Assets Under Construction (AUC)",
"Assets in Transit",
"Land - Accum Dep",
"Leasehold Improvement - Accum Dep",
"Building - Accum Dep",
"Motor Vehicle - Accum Dep",
"Computers - Accum Dep",
"Office Equipment - Accum Dep",
"Furniture & Fittings - Accum Dep",
"Other Equipment - Accum Dep",
"Plant & Machinery - Accum Dep",
"Other Facilities - Accum Dep"
    ];
    $( "#acc_name" ).autocomplete({
      source: availableTags
    });
  } );

