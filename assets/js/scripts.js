

  function confirmAction() {
    var confirmed = confirm("Are you sure? This will remove the record forever.");
    return confirmed;
  }

  $(function(){
    $('.tooltip_dialog').tooltip();
  });

  $('input[id=lefile]').change(function(){
    $('#photoCover').val($(this).val());
  });


  $(document).ready(function() { 
      // $.ajax({
      //   url: 'json_saleschart.php',
      //   success: function(point) {
      //     var chartSeriesData=[];
      //       $.each(point, function(i, item){
      //         var series_quantity = item.quantity;
      //         var series_sales = item.sales;
      //         var series = {
      //           yAxis: 0,
      //           name: 'Items Sold',
      //           data: item.quantity
      //         }, {
      //           yAxis: 1,
      //           name : 'Sales',
      //           data: item.sales
      //         };
      //         chartSeriesData.push(series);
      //       });

      //     var chartSeriesCategories=[];
      //       $.each(point, function(i, item){
      //         var categories_date = item.date;
      //         var categories = {item.date, };
      //         chartSeriesCategories.push(categories);
      //       });

           chart1 = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line'
            },
            title: {
                text: 'Dpoint Product Sales Monitoring'
            },

            xAxis: {
                title: {
                  text: 'date'
                },
                categories: ['2013-03-03', '2013-03-05', '2013-03-08']
            },
            yAxis: [{
              title: {
                text: 'Items Sold'
              }
            }, {
              title: {
                text: 'Sales'
              },
              opposite: true
            }],

            series: [{
                yAxis: 0,
                name: 'Items Sold',
                data: [1, 0, 4]
            }, {
                yAxis: 1,
                name: 'Sales',
                data: [230860, 230860, 46172]
            }]
          });
      //   }
      //   cache: false
      // });
      
  });

// function requestData() {
//      $.ajax({
//     url: 'array.php',
//      success: function(point) {
//       var chartSeriesData=[];
//          $.each(point, function(i,item){
//          var series_name = item.name;
//          var series_data = item.data2;     
//          var series = {data: item.data2,name:series_name};
//         chartSeriesData.push(series);
//         });
//      chart = new Highcharts.Chart({
//     chart: {
//         renderTo: 'container',
//         defaultSeriesType: 'column'      ,      

//     },
//     title: {
//         text: 'Real time data from database'
//     },
//     xAxis: {
//             categories: []
//         },
//     yAxis: {
//         minPadding: 0.2,
//         maxPadding: 0.2,
//         title: {
//             text: 'Value',
//             margin: 80
//         }
//     },
//     series: chartSeriesData
// });         
// },
// cache: false
// });
//   }

// }


    var chart;
    $(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container',
                defaultSeriesType: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Hourly Visits',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                type: 'datetime',
                tickInterval: 3600 * 1000, // one hour
                tickWidth: 0,
                gridLineWidth: 1,
                labels: {
                    align: 'center',
                    x: -3,
                    y: 20,
                    formatter: function() {
                        return Highcharts.dateFormat('%l%p', this.value);
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Visits'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return Highcharts.dateFormat('%l%p', this.x-(1000*3600)) +'-'+ Highcharts.dateFormat('%l%p', this.x) +': <b>'+ this.y + '</b>';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Count'
            }]
        }
        // Load data asynchronously using jQuery. On success, add the data
        // to the options and initiate the chart.
        // This data is obtained by exporting a GA custom report to TSV.
        // http://api.jquery.com/jQuery.get/
        jQuery.get('data.php', null, function(tsv) {
            var lines = [];
            traffic = [];
            try {
                // split the data return into lines and parse them
                tsv = tsv.split(/\n/g);
                jQuery.each(tsv, function(i, line) {
                    line = line.split(/\t/);
                    date = Date.parse(line[0] +' UTC');
                    traffic.push([
                        date,
                        parseInt(line[1].replace(',', ''), 10)
                    ]);
                });
            } catch (e) {  }
            options.series[0].data = traffic;
            chart = new Highcharts.Chart(options);
        });
    });
