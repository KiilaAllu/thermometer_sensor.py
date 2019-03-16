$(function () {
 
$('#container').highcharts({
chart: {
type: 'line'
},
time: {
timezone: 'America/New_York'
},
title: {
text: 'Temperature vs Time'
},
xAxis: {
title: {
text: 'Time'
},
type: 'datetime',
},
yAxis: {
title: {
text: 'Temperature'
}
},
series: [{
name: 'Celcius',
data: <?php echo json_encode($dateTemp, JSON_NUMERIC_CHECK);?>
}]
});
});
Line 26 is the most important, so I will show it here again.

1
data: <?php echo json_encode($dateTemp, JSON_NUMERIC_CHECK);?>
We are telling Highcharts that the [x,y] pairs should come from our $dateTemp array that we made previously.  The beauty here is that it updates dynamically.  Every time you refresh the page it reads the chart again, and adds any new points.

Here is the code all together:

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
68
69
70
71
72
73
74
75
76
77
78
79
80
81
82
83
84
85
86
87
88
89
90
<?php

$username="alvari";
$password="alvari";//use your password
$database="sensor";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die ( "Unable to make it happen Cap'n");

$query = "SELECT datetime, temperature FROM bmesensor";
$result = mysql_query($query);
$dateTemp = array();
$index = 0;
while ($row = mysql_fetch_array($result, MYSQL_NUM))
{
$dateTemp[$index]=$row;
$index++;
}

//echo json_encode($dateTemp, JSON_NUMERIC_CHECK);

mysql_close();

?>

<!DOCTYPE html>
<html>
<head>
<title>HighChart</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data-2012-2022.min.js"></script>

</head>
<body>

<script type="text/javascript">
$(function () {

$('#container').highcharts({
chart: {
type: 'line'
},
time: {
timezone: 'America/New_York'
},
title: {
text: 'Temperature vs Time'
},
xAxis: {
title: {
text: 'Time'
},
type: 'datetime',
},
yAxis: {
title: {
text: 'Temperature'
}
},
series: [{
name: 'Celcius',
data: <?php echo json_encode($dateTemp, JSON_NUMERIC_CHECK);?>
}]
});
});

</script>
<script src="charts/js/highcharts.js"></script>
<script src="charts/js/modules/exporting.js"></script>

<div class="container">
<br/>
<h2 class="text-center">Living Room Sensor - Temp vs. Time</h2>
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">Dashboard</div>
<div class="panel-body">
<div id="container"></div>
</div>
</div>
</div>
</div>
</div>

</body>
</html>
