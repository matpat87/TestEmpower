var locateChartDivMyUsage = setTimeout( function() { 
  if(document.getElementById("my-usage-chart-div") !== null) {
    setupMyUsageChart();
    clearTimeout(locateChartDivMyUsage);
  }
}, 500);

function setupMyUsageChart() {
  
  if (typeof chart !== 'undefined') {
      chart.dispose();
  }

  var my_usage_sales_group_user_id = $("input[name='my_usage_sales_group_user_id']").val();

  var chart = am4core.create("my-usage-chart-div", am4charts.XYChart);
  chart.dateFormatter.dateFormat = "yyyy-MM";
  chart.dataSource.url = "/index.php?entryPoint=retrieveMyUsageChartData&my_usage_sales_group_user_id=" + my_usage_sales_group_user_id;
  chart.legend = new am4charts.Legend();
  chart.legend.position = "right";
  chart.legend.valign = "middle";
  chart.legend.labels.template.width = 100;
  chart.legend.valueLabels.template.width = 40;
  
  // Create axes
  var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
  dateAxis.renderer.minGridDistance = 1;
  dateAxis.dateFormats.setKey("month", "MMM");
  dateAxis.periodChangeDateFormats.setKey("month", "MMM");

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  valueAxis.maxPrecision = 0;

  // Create series

  var modules = ['Accounts', 'Calls', 'Customer Issues', 'Contacts', 'Emails', 'Leads', 'Meetings', 'Notes', 'Opportunities', 'Projects', 'Tasks'];
  
  modules.map ( (module) => {

    var module_var_name = '';

    switch (module) {
      case 'Customer Issues':
        module_var_name = 'cases';
        break;
      default:
        module_var_name = module.toLowerCase();
        break;
    }

    eval("var series_" + module_var_name + " = chart.series.push(new am4charts.LineSeries());");
    eval("series_" + module_var_name  + ".name" + " = '" + module + "'");
    eval("series_" + module_var_name  + ".dataFields.valueY" + " = '" + module + "'");
    eval("series_" + module_var_name  + ".dataFields.dateX" + " = 'YearMonth'");
    eval("series_" + module_var_name  + ".tooltip.pointerOrientation" + " = 'vertical'");
    eval("series_" + module_var_name  + ".tooltipText" + " = '" + module + ":{" + module + "}'");
    eval("series_" + module_var_name  + ".legendSettings.valueText" + " = '{" + module + "}'");
    
  });

  chart.cursor = new am4charts.XYCursor();
  chart.cursor.xAxis = dateAxis;
}

