

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