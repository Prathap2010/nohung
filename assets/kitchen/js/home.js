$(document).ready(function(){
    
    load_sales_overview_chart();
    $("#earning_year").change(function(){
        load_sales_overview_chart();
    });

    load_earning_report();
    $("#earningyear,#earningmonth").change(function(){
        load_earning_report();
    });    
});
function load_sales_overview_chart(){
    var year = $("#earning_year").val();

    $.ajax({
        url: SITE_URL+'home/get_total_sales',
        type: 'POST',
        data: {year:year},
        dataType: 'json',
        // async: false,
        success: function(response){
            $("#total_earning").html("₹"+parseFloat(response.total_earning).toFixed(2));
            
            Highcharts.chart('sales_overview_chart', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: ''
                },
                /* subtitle: {
                    text: 'Source: WorldClimate.com'
                }, */
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Sales'
                    },
                    labels: {
                        formatter: function () {
                            return this.value;
                        }
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#FFA451',
                            lineWidth: 1
                        }
                    },
                    series: {
                        color: '#FFA451'
                    }
                },
                series: [{
                    name: 'Sales',
                    marker: {
                        symbol: 'circle'
                    },
                    data: response.total_earning_in_year
            
                }]
            });

        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}
function load_earning_report(){
    var year = $("#earningyear").val();
    var month = $("#earningmonth").val();

    $.ajax({
        url: SITE_URL+'home/get_total_earning',
        type: 'POST',
        data: {year:year,month:month},
        dataType: 'json',
        // async: false,
        success: function(response){
            // $("#totalearning").html("₹"+parseFloat(response.total_earning).toFixed(2));
            var html = "";
            if(response.total_earning_in_month.length > 0){
                html += '<ul>';
                for(var i=0; i<response.total_earning_in_month.length; i++){
                    html += '<li>\
                                <p>Week '+(i+1)+'</p>\
                                <span>'+parseFloat(response.total_earning_in_month[i]).toFixed(2)+'</span>\
                            </li>';
                }
                html += '</ul>';
                // ₹
            }
            $(".earningWeekDetails").html(html);
        },
        error: function(xhr) {
        //alert(xhr.responseText);
        },
    });
}