var locateChartDivOpportunityByVelocity = setTimeout(function () {
  if (document.getElementById('opportunity-by-velocity-chart-div') !== null) {
    setupOpportunityByVelocityChart();
    clearTimeout(locateChartDivOpportunityByVelocity);
  }
}, 500);

function setupOpportunityByVelocityChart() {
  if (typeof chart !== 'undefined') {
    chart.dispose();
  }

  var opportunity_by_velocity_my_opportunities = $(
    "input[name='opportunity_by_velocity_my_opportunities']"
  ).val()
    ? '&opportunity_by_velocity_my_opportunities=' +
      $("input[name='opportunity_by_velocity_my_opportunities']").val()
    : '';
  var opportunity_by_velocity_sales_stages = $(
    "input[name='opportunity_by_velocity_sales_stages']"
  ).val()
    ? '&opportunity_by_velocity_sales_stages=' +
      $("input[name='opportunity_by_velocity_sales_stages']").val()
    : '';
  var opportunity_by_velocity_sales_group_user_ids = $(
    "input[name='opportunity_by_velocity_sales_group_user_ids']"
  ).val()
    ? '&opportunity_by_velocity_sales_group_user_ids=' +
      $("input[name='opportunity_by_velocity_sales_group_user_ids']").val()
    : '';
  var opportunity_by_velocity_amount = $(
    "input[name='opportunity_by_velocity_amount']"
  ).val()
    ? '&opportunity_by_velocity_amount=' +
      $("input[name='opportunity_by_velocity_amount']").val()
    : '';
  var opportunity_by_velocity_date_from = $(
    "input[name='opportunity_by_velocity_date_from']"
  ).val()
    ? '&opportunity_by_velocity_date_from=' +
      $("input[name='opportunity_by_velocity_date_from']").val()
    : '';
  var opportunity_by_velocity_date_to = $(
    "input[name='opportunity_by_velocity_date_to']"
  ).val()
    ? '&opportunity_by_velocity_date_to=' +
      $("input[name='opportunity_by_velocity_date_to']").val()
    : '';

  // Create chart instance
  var chart = am4core.create(
    'opportunity-by-velocity-chart-div',
    am4charts.XYChart
  );

  chart.dataSource.url =
    '/index.php?entryPoint=retrieveOpportunityByVelocityChartData' +
    opportunity_by_velocity_my_opportunities +
    opportunity_by_velocity_sales_stages +
    opportunity_by_velocity_sales_group_user_ids +
    opportunity_by_velocity_amount +
    opportunity_by_velocity_date_from +
    opportunity_by_velocity_date_to;

  chart.legend = new am4charts.Legend();
  chart.cursor = new am4charts.XYCursor();
  chart.scrollbarY = new am4core.Scrollbar();
  chart.legend.position = 'right';

  // Create axes
  var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = 'sales_stage';
  categoryAxis.renderer.grid.template.opacity = 0;

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  valueAxis.renderer.inside = true;
  valueAxis.renderer.labels.template.disabled = true;
  valueAxis.min = 0;

  // Create series
  function createSeries(field, name) {
    // Set up series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.name = name;
    series.dataFields.valueY = field;
    series.dataFields.categoryX = "sales_stage";
    series.sequencedInterpolation = true;
    
    // Make it stacked
    series.stacked = true;
    
    // Configure columns
    series.tooltipY = am4core.percent(50);
    series.tooltipText = "[bold]{name}[font-size:14px]: {valueY}";
    
    // Add label
    var labelBullet = series.bullets.push(new am4charts.LabelBullet());
    labelBullet.label.text = "{valueY}";
    labelBullet.locationY = 0.5;
    labelBullet.label.hideOversized = true;
  }

  chart.colors.list = [
    am4core.color('#a6cee3'),
    am4core.color('#1f78b4'),
    am4core.color('#b2df8a'),
    am4core.color('#33a02c'),
    am4core.color('#fb9a99'),
    am4core.color('#e31a1c'),
    am4core.color('#fdbf6f'),
    am4core.color('#ff7f00'),
    am4core.color('#cab2d6'),
    am4core.color('#6a3d9a'),
    am4core.color('#ffff99'),
    am4core.color('#b15928'),
  ];

  $.ajax({
    url:
      'index.php?entryPoint=retrieveOpportunitySalesGroupUsersForChartSeries&to_pdf=1' +
      opportunity_by_velocity_sales_group_user_ids,
    success: function (result) {
      var jsonResult = JSON.parse(result);

      if (jsonResult) {
        for (var [key, value] of Object.entries(jsonResult)) {
          createSeries(key, value);
        }
      }
    },
  });
}
