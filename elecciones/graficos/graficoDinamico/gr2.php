	<div id="result"></div>
<?php // tabla multiple datos.
	
		$columnas = array(
			"estado","ingresos","ingresos por trimestre","costos","costos por trimestre",
			"resultados");
		
		$datos = array(
			array("alabama" ,254, "71, 78, 39, 66 "	,296,"68, 52, 80, 96 " ) ,
			array("Alaska"  ,246, "87, 44, 74, 41 " ,181,"29, 54, 73, 25 " ) ,
			array("Arizona" ,101, "56, 12, 8, 25 "	,191,"69, 14, 53, 55 " ) ,
			array("Arkansas",303, "81, 50, 78, 94 "	,76 ,"36, 15, 14, 11 " ) 
		
		);
		
		
		
		echo "\t\t<table id=\"table-sparkline\">\n";
		echo "\t\t\t<thead>\n";
		echo "\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t";
		foreach($columnas as $v){ echo "<th>$v</th>"; }
		echo "\n";
		echo "\t\t\t\t</tr>\n";
		echo "\t\t\t</thead>\n";
		echo "\t\t<tbody id=\"tbody-sparkline\" >\n";
		foreach($datos as $tr){
			echo "\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t";
			$n=$tr[0];$i=$tr[1];$it=$tr[2];$c=$tr[3];$ct=$tr[4];
			$t=$i-$c;
			echo "<th>$n</th>"
				."<td>$i</td><td data-sparkline=\"$it\" />"
				."<td>$c</td><td data-sparkline=\"$ct\" />"
				."<td>$t</td>"
				
			echo "\n";
			echo "\t\t\t\t</tr>\n";
		}
		echo "\t\t</table >\n";				
?>
<script>

/**
 * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
 * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
 */
Highcharts.SparkLine = function (a, b, c) {
    var hasRenderToArg = typeof a === 'string' || a.nodeName,
        options = arguments[hasRenderToArg ? 1 : 0],
        defaultOptions = {
            chart: {
                renderTo: (options.chart && options.chart.renderTo) || this,
                backgroundColor: null,
                borderWidth: 0,
                type: 'area',
                margin: [2, 0, 2, 0],
                width: 120,
                height: 20,
                style: {
                    overflow: 'visible'
                },

                // small optimalization, saves 1-2 ms each sparkline
                skipClone: true
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                startOnTick: false,
                endOnTick: false,
                tickPositions: []
            },
            yAxis: {
                endOnTick: false,
                startOnTick: false,
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                tickPositions: [0]
            },
            legend: {
                enabled: false
            },
            tooltip: {
                backgroundColor: null,
                borderWidth: 0,
                shadow: false,
                useHTML: true,
                hideDelay: 0,
                shared: true,
                padding: 0,
                positioner: function (w, h, point) {
                    return { x: point.plotX - w / 2, y: point.plotY - h };
                }
            },
            plotOptions: {
                series: {
                    animation: false,
                    lineWidth: 1,
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    marker: {
                        radius: 1,
                        states: {
                            hover: {
                                radius: 2
                            }
                        }
                    },
                    fillOpacity: 0.25
                },
                column: {
                    negativeColor: '#910000',
                    borderColor: 'silver'
                }
            }
        };

    options = Highcharts.merge(defaultOptions, options);

    return hasRenderToArg ?
        new Highcharts.Chart(a, options, c) :
        new Highcharts.Chart(options, b);
};

var start = +new Date(),
    $tds = $('td[data-sparkline]'),
    fullLen = $tds.length,
    n = 0;

// Creating 153 sparkline charts is quite fast in modern browsers, but IE8 and mobile
// can take some seconds, so we split the input into chunks and apply them in timeouts
// in order avoid locking up the browser process and allow interaction.
function doChunk() {
    var time = +new Date(),
        i,
        len = $tds.length,
        $td,
        stringdata,
        arr,
        data,
        chart;

    for (i = 0; i < len; i += 1) {
        $td = $($tds[i]);
        stringdata = $td.data('sparkline');
        arr = stringdata.split('; ');
        data = $.map(arr[0].split(', '), parseFloat);
        chart = {};

        if (arr[1]) {
            chart.type = arr[1];
        }
        $td.highcharts('SparkLine', {
            series: [{
                data: data,
                pointStart: 1
            }],
            tooltip: {
                headerFormat: '<span style="font-size: 10px">' + $td.parent().find('th').html() + ', Q{point.x}:</span><br/>',
                pointFormat: '<b>{point.y}.000</b> USD'
            },
            chart: chart
        });

        n += 1;

        // If the process takes too much time, run a timeout to allow interaction with the browser
        if (new Date() - time > 500) {
            $tds.splice(0, i + 1);
            setTimeout(doChunk, 0);
            break;
        }

        // Print a feedback on the performance
        if (n === fullLen) {
            $('#result').html('Generated ' + fullLen + ' sparklines in ' + (new Date() - start) + ' ms');
        }
    }
}
doChunk();

</script>
