var locateChartDivOpportunityByValue = setTimeout(function () {
  if (document.getElementById('opportunity-by-value-chart-div') !== null) {
    setupOpportunityByValueChart();
    clearTimeout(locateChartDivOpportunityByValue);
  }
}, 500);

function setupOpportunityByValueChart() {
  if (typeof chart !== 'undefined') {
    chart.dispose();
  }

  var opportunity_by_value_my_opportunities = $(
    "input[name='opportunity_by_value_my_opportunities']"
  ).val()
    ? '&opportunity_by_value_my_opportunities=' +
      $("input[name='opportunity_by_value_my_opportunities']").val()
    : '';
  var opportunity_by_value_sales_stages = $(
    "input[name='opportunity_by_value_sales_stages']"
  ).val()
    ? '&opportunity_by_value_sales_stages=' +
      $("input[name='opportunity_by_value_sales_stages']").val()
    : '';
  var opportunity_by_value_sales_group_user_ids = $(
    "input[name='opportunity_by_value_sales_group_user_ids']"
  ).val()
    ? '&opportunity_by_value_sales_group_user_ids=' +
      $("input[name='opportunity_by_value_sales_group_user_ids']").val()
    : '';
  var opportunity_by_value_amount = $(
    "input[name='opportunity_by_value_amount']"
  ).val()
    ? '&opportunity_by_value_amount=' +
      $("input[name='opportunity_by_value_amount']").val()
    : '';
  var opportunity_by_value_date_from = $(
    "input[name='opportunity_by_value_date_from']"
  ).val()
    ? '&opportunity_by_value_date_from=' +
      $("input[name='opportunity_by_value_date_from']").val()
    : '';
  var opportunity_by_value_date_to = $(
    "input[name='opportunity_by_value_date_to']"
  ).val()
    ? '&opportunity_by_value_date_to=' +
      $("input[name='opportunity_by_value_date_to']").val()
    : '';

  // Create chart instance
  var chart = am4core.create(
    'opportunity-by-value-chart-div',
    am4charts.XYChart
  );
  chart.dataSource.url =
    '/index.php?entryPoint=retrieveOpportunityByValueChartData' +
    opportunity_by_value_my_opportunities +
    opportunity_by_value_sales_stages +
    opportunity_by_value_sales_group_user_ids +
    opportunity_by_value_amount +
    opportunity_by_value_date_from +
    opportunity_by_value_date_to;

  chart.legend = new am4charts.Legend();
  chart.cursor = new am4charts.XYCursor();
  chart.scrollbarY = new am4core.Scrollbar();
  chart.legend.position = 'right';

  // Create axes
  var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = 'username';
  categoryAxis.renderer.grid.template.opacity = 0;
  categoryAxis.renderer.labels.template.fontSize = 10;
  categoryAxis.renderer.minGridDistance = 10;

  var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
  valueAxis.min = 0;
  valueAxis.renderer.grid.template.opacity = 0;
  valueAxis.renderer.ticks.template.strokeOpacity = 0.5;
  valueAxis.renderer.ticks.template.length = 10;
  valueAxis.renderer.line.strokeOpacity = 0.5;
  valueAxis.renderer.baseGrid.disabled = true;

  // Create series
  function createSeries(field, name) {
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueX = field;
    series.dataFields.categoryY = 'username';
    series.stacked = true;
    series.name = name;
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
      'index.php?entryPoint=retrieveOpportunitySalesStagesForChartSeries&to_pdf=1' +
      opportunity_by_value_sales_stages,
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
