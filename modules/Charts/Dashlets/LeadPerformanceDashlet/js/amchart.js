var locateChartDivLeadPerformance = setTimeout(function () {
  // console.log(document.getElementById('lead-performance-chart-div'))
  if (document.getElementById('lead-performance-chart-div') !== null) {
    setupLeadPerformanceChart();
    clearTimeout(locateChartDivLeadPerformance);
  }
}, 500);

function setupLeadPerformanceChart() {
  if (typeof chart !== 'undefined') {
    chart.dispose();
  }

  var lead_performance_date_from = $(
    "input[name='lead_performance_date_from']"
  ).val()
    ? '&lead_performance_date_from=' +
      $("input[name='lead_performance_date_from']").val()
    : '';
  var lead_performance_date_to = $(
    "input[name='lead_performance_date_to']"
  ).val()
    ? '&lead_performance_date_to=' +
      $("input[name='lead_performance_date_to']").val()
    : '';
  
    var leads_performance_sales_group_user_ids = $(
      "input[name='leads_performance_sales_group_user_ids']"
    ).val()
      ? '&leads_performance_sales_group_user_ids=' +
        $("input[name='leads_performance_sales_group_user_ids']").val()
      : '';
  
  // Data Source
  
  
  // Create chart instance
  var chart = am4core.create("lead-performance-chart-div", am4charts.PieChart);
  chart.preloader.disabled = false;
  chart.radius = am4core.percent(60);


  chart.dataSource.url = '/index.php?entryPoint=retrieveLeadPerformanceChartData' 
    + lead_performance_date_from 
    + lead_performance_date_to
    + leads_performance_sales_group_user_ids;
  chart.dataSource.parser = new am4core.JSONParser();
  
  
  chart.dataSource.events.on("done", function(ev) {
    // Data loaded and parsed
    if (ev.target.data.length == 0) {
      chart.dispose();
      $('#lead-performance-chart-div')
        .css('height', 'auto')
        .css('background-color', '#fff')
        .html('<h3 class="noGraphDataPoints">No Results</h3>');
    }
  });



  // Add and configure Series
  var pieSeries = chart.series.push(new am4charts.PieSeries());
  pieSeries.dataFields.value = "leads_count";
  pieSeries.dataFields.category = "lead_status";
  
  // Let's cut a hole in our Pie chart the size of 30% the radius
  chart.innerRadius = am4core.percent(30);
  
  // Put a thick white border around each Slice
  pieSeries.slices.template.stroke = am4core.color("#fff");
  pieSeries.slices.template.strokeWidth = 2;
  pieSeries.slices.template.strokeOpacity = 1;
  pieSeries.slices.template
    // change the cursor on hover to make it apparent the object can be interacted with
    .cursorOverStyle = [
      {
        "property": "cursor",
        "value": "pointer"
      }
    ];
  
  pieSeries.labels.template.text = "{category}: {value.value}";
  pieSeries.alignLabels = true;
  pieSeries.labels.template.bent = true;
  pieSeries.labels.template.radius = 3;
  pieSeries.labels.template.padding(0,0,0,0);
  
  pieSeries.ticks.template.disabled = true;
  // pieSeries.labels.template.disabled = true;
  
  // Create hover state
  var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists
  
  // Slightly shift the shadow and make it more prominent on hover
  var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
  hoverShadow.opacity = 0.7;
  hoverShadow.blur = 5;
  
  // Add a legend
  chart.legend = new am4charts.Legend();
  chart.legend.valueLabels.template.text = "{value.value}";

}
