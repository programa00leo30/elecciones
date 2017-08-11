<div >
	<div id="grafic1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	<div id="grafic2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	<div id="grafic3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	<div id="grafic4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
<script>

Highcharts.chart('grafic1', {
    chart: {   type: 'spline'   },
    title: {  text: 'Wind speed during two days'  },
    subtitle: { text: 'May 31 and and June 1, 2015 at two locations in Vik i Sogn, Norway'  },
    xAxis: { 
        type: 'datetime',
        labels: { overflow: 'justify' }
    },
    yAxis: {
        title: { text: 'Wind speed (m/s)' },
        minorGridLineWidth: 0,
        gridLineWidth: 0,
        alternateGridColor: null,
        plotBands: [{ // Light air
            from: 0.3,
            to: 1.5,
            color: 'rgba(68, 170, 213, 0.1)',
            label: { text: 'Light air', style: { color: '#606060' } }
        }, { // Light breeze
            from: 1.5,
            to: 3.3,
            color: 'rgba(0, 0, 0, 0)',
            label: { text: 'Light breeze', style: { color: '#606060' }
            }
        }, { // Gentle breeze
            from: 3.3,
            to: 5.5,
            color: 'rgba(68, 170, 213, 0.1)',
            label: { text: 'Gentle breeze', style: { color: '#606060' }
            }
        }, { // Moderate breeze
            from: 5.5,
            to: 8,
            color: 'rgba(0, 0, 0, 0)',
            label: { text: 'Moderate breeze', style: { color: '#606060' }
            }
        }, { // Fresh breeze
            from: 8,
            to: 11,
            color: 'rgba(68, 170, 213, 0.1)',
            label: { text: 'Fresh breeze', style: { color: '#606060' }
            }
        }, { // Strong breeze
            from: 11,
            to: 14,
            color: 'rgba(0, 0, 0, 0)',
            label: { text: 'Strong breeze', style: { color: '#606060' }
            }
        }, { // High wind
            from: 14,
            to: 15,
            color: 'rgba(68, 170, 213, 0.1)',
            label: { text: 'High wind', style: { color: '#606060' }
            }
        }]
    },
    tooltip: { valueSuffix: ' m/s' },
    plotOptions: {
        spline: {
            lineWidth: 4,
            states: { hover: {  lineWidth: 5 } },
            marker: { enabled: false },
            pointInterval: 3600000, // one hour
            pointStart: Date.UTC(2015, 4, 31, 0, 0, 0)
        }
    },
    series: [{
        name: 'Hestavollane',
        data: [0.2, 0.8, 0.8, 0.8, 1, 1.3, 1.5, 2.9, 1.9, 2.6, 1.6, 3, 4, 3.6, 4.5, 4.2, 4.5, 4.5, 4, 3.1, 2.7, 4, 2.7, 2.3, 2.3, 4.1, 7.7, 7.1, 5.6, 6.1, 5.8, 8.6, 7.2, 9, 10.9, 11.5, 11.6, 11.1, 12, 12.3, 10.7, 9.4, 9.8, 9.6, 9.8, 9.5, 8.5, 7.4, 7.6]

    }, {
        name: 'Vik',
        data: [0, 0, 0.6, 0.9, 0.8, 0.2, 0, 0, 0, 0.1, 0.6, 0.7, 0.8, 0.6, 0.2, 0, 0.1, 0.3, 0.3, 0, 0.1, 0, 0, 0, 0.2, 0.1, 0, 0.3, 0, 0.1, 0.2, 0.1, 0.3, 0.3, 0, 3.1, 3.1, 2.5, 1.5, 1.9, 2.1, 1, 2.3, 1.9, 1.2, 0.7, 1.3, 0.4, 0.3]
    }],
    navigation: { menuItemStyle: { fontSize: '10px' } }
});
	</script><script>
		$(document).ready(function () {
		Highcharts.setOptions({
			global: {
				useUTC: false
			}
		});

		Highcharts.chart('grafic2', {
			chart: {
				type: 'spline',
				animation: Highcharts.svg, // don't animate in old IE
				marginRight: 10,
				events: {
					load: function () {

						// set up the updating of the chart each second
						var series = this.series[0];
						setInterval(function () {
							var x = (new Date()).getTime(), // current time
								y = Math.random();
							series.addPoint([x, y], true, true);
						}, 1000);
					}
				}
			},
			title: {
				text: 'Live random data'
			},
			xAxis: {
				type: 'datetime',
				tickPixelInterval: 150
			},
			yAxis: {
				title: {
					text: 'Value'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
						Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
						Highcharts.numberFormat(this.y, 2);
				}
			},
			legend: {
				enabled: false
			},
			exporting: {
				enabled: false
			},
			series: [{
				name: 'Random data',
				data: (function () {
					// generate an array of random data
					var data = [],
						time = (new Date()).getTime(),
						i;

					for (i = -19; i <= 0; i += 1) {
						data.push({
							x: time + i * 1000,
							y: Math.random()
						});
					}
					return data;
				}())
			}]
		});
	});
	</script>
