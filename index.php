<?php
include("database/connection.php");
include("database/functions.php");
include("header.php");
$datetime = $solarirradiance = $relativetemperature = $relativehumidity = $windspeed = $surfacetemperaturearray = $surfacetemperatureweather = $voltage = $current =$watt= array();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'])) {
    // Retrieve the desired date from the form submission
    $desiredDate = $_POST['date'];
} else {
    // No desired date submitted, set it to today
    $desiredDate = date('Y-m-d');

}

// SQL query to retrieve data for the desired date, sorted by datetime
$sql = "SELECT * FROM data_baru WHERE DATE(datetime) = '" . $desiredDate . "' ORDER BY datetime";

// Execute the query and get the result set
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Initialize arrays to hold the data


    // Loop through each row of data
    while ($row = $result->fetch_assoc()) {
        // Access individual columns of the row
        $datetime[] = $row['datetime'];
        $solarirradiance[] = $row['solarirradiance'];
        $relativetemperature[] = $row['relativetemperature'];
        $relativehumidity[] = $row['relativehumidity'];
        $windspeed[] = $row['windspeed'];
        $surfacetemperaturearray[] = $row['surfacetemperaturearray'];
        $voltage[] = $row['voltage'];
        $current[] = $row['current'];
        $watt[] = $row['watt'];
    }

    // Check if 00:00 exists in the data
    if (!in_array($desiredDate . ' 00:00:00', $datetime)) {
        // Add 00:00 data with all values set to 0
        $datetime[] = $desiredDate . ' 00:00:00';
        $solarirradiance[] = 0;
        $relativetemperature[] = 0;
        $relativehumidity[] = 0;
        $windspeed[] = 0;
        $surfacetemperaturearray[] = 0;

        $voltage[] = 0;
        $current[] = 0;
        $watt[] = 0;
    }

    // Check if 23:59 exists in the data
    if (!in_array($desiredDate . ' 23:59:00', $datetime)) {
        // Add 23:59 data with all values set to 0
        $datetime[] = $desiredDate . ' 23:59:00';
        $solarirradiance[] = 0;
        $relativetemperature[] = 0;
        $relativehumidity[] = 0;
        $windspeed[] = 0;
        $surfacetemperaturearray[] = 0;

        $voltage[] = 0;
        $current[] = 0;
        $watt[] = 0;
    }

    // Sort the arrays based on datetime
    array_multisort($datetime, $solarirradiance, $relativetemperature, $relativehumidity, $windspeed, $surfacetemperaturearray, $current, $voltage, $watt);

} else {
    echo "No data found!";
}                                                                                   

// Close the database connection
$conn->close();





?>


<!DOCTYPE html>
<script>
    var suhu = <?php echo json_encode($relativetemperature, JSON_HEX_TAG); ?>;
    dates = <?php echo json_encode($datetime, JSON_HEX_TAG); ?>;
    angin = <?php echo json_encode($windspeed, JSON_HEX_TAG); ?>;
    kelembapan = <?php echo json_encode($relativehumidity, JSON_HEX_TAG); ?>;
    radiasi = <?php echo json_encode($solarirradiance, JSON_HEX_TAG); ?>;
    surfacetemperature = <?php echo json_encode($surfacetemperaturearray, JSON_HEX_TAG); ?>;
    surfacetemperatureweather = <?php echo json_encode($surfacetemperatureweather, JSON_HEX_TAG); ?>;
    desired_date = <?php echo json_encode($desiredDate, JSON_HEX_TAG); ?>;
    voltage = <?php echo json_encode($voltage, JSON_HEX_TAG); ?>;
    current = <?php echo json_encode($current, JSON_HEX_TAG); ?>;
    watt = <?php echo json_encode($watt, JSON_HEX_TAG); ?>;
    // Convert the dates from string to Date objects

</script>
<html lang="en">

<head>

    <!-- <meta http-equiv="refresh" content="10"> -->
    <?php
    if ($desiredDate == date('Y-m-d')) {
        echo '<meta http-equiv="refresh" content="30">';
    }
    ?>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Forecasting Monitoring</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/Awan.png" rel="icon">
    <link href="assets/img/Awan.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.1/dist/apexcharts.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center" style="  background: #3584fa;">
        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center">
                <img src="assets/img/Awan.png" alt="">
                <span class="d-none d-lg-block">FoMo</span>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </a>
            <div class="logo-container">
                <a href="#" class="logo d-flex align-items-center">
                    <img src="assets/img/Logo4.png" alt="">
                    <span style="font-size: smaller;">Supported by</span>
                </a>


            </div>
            <div class="logo-container">
                <a href="#" class="logo d-flex align-items-center">
                    <img src="assets/img/Logo1.png" alt="">
                    <!-- <span class="d-none d-lg-block">Logo 1</span> -->
                </a>
            </div>
            <div class="logo-container">
                <a href="#" class="logo d-flex align-items-center">
                    <img src="assets/img/Logo2.png" alt="">
                    <!-- <span class="d-none d-lg-block">Logo 2</span> -->
                </a>
            </div>
            <div class="logo-container">
                <a href="#" class="logo d-flex align-items-center">
                    <img src="assets/img/Logo3.png" alt="">
                    <!-- <span class="d-none d-lg-block">Logo 3</span> -->
                </a>
            </div>

        </div><!-- End Logo -->
    </header><!-- End Header -->


    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link active" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>Data</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="detail.php">
                    <i class="ri ri-bar-chart-box-line"></i>
                    <span>Reports</span>
                </a>
            </li><!-- End Components Nav -->

            <li class="nav-item ">
                <a class="nav-link collapsed" href="prediksi.php">
                    <i class="bi bi-cloud-haze-fill"></i>
                    <span>Prediction</span>
                </a>
            </li><!-- End Components Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" href="about us.php">
                    <i class="bi bi-envelope"></i>
                    <span>About Us</span>
                </a>
            </li><!-- End Contact Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Photovoltaic and Weather Station Monitoring, Deli Building</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <section class="section dashboard">
            <div class="row">
                <!-- <div class="card containcard"> -->
                <div class="card contain-card">
                    <div class="card-body">
                        <h7>Data </h7>





                        <!-- Left side columns -->
                        <div class="col-lg">
                            <!-- current pv power card -->

                            <div class="row">
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card" style="background-color: gold;">
                                        <div class="card-body">
                                            <h5 class="card-title">Today's Date:</h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-lightning-charge"></i>
                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $today = date("d F Y");
                                                        echo $today; ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- yang current current -->
                                <!-- current Solar Irradiance card -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title ">Solar Irradiance </h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($solarirradiance, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> W/m²
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- current pv power card -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title ">Wind Speed </h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($windspeed, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> m/s
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- current pv power card -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">
                                        <div class="card-body">
                                            <h5 class="card-title ">Current</h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($current, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> Ampere
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- current pv power card -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title ">Voltage </h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($voltage, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> Volt
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- current pv power card -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title ">Relative Humidity </h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($relativehumidity, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> %
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- current pv power card -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">



                                        <div class="card-body">
                                            <h5 class="card-title ">Surface Temperature PV</h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($surfacetemperaturearray, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> °C
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- current pv power card -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title ">Relative Temperature </h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($relativetemperature, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> °C
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- End PV powerCard -->
                                <div class="col-xxl-4 col-md-4">
                                    <div class="card info-card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title ">Wattage </h5>

                                            <div class="d-flex align-items-center">
                                                <!-- <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-lightning-charge"></i>
                                                </div> -->
                                                <div class="ps-3">
                                                    <h6>
                                                        <?php
                                                        $slice = array_slice($watt, -2, 1);
                                                        $lastData = end($slice);
                                                        echo !empty($lastData) ? $lastData : 0;
                                                        ?> Watt
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Location -->
                                <div class="col-xxl-6 col-md-4">
                                    <div class="card info-card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title">Location</h5>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="ps-3">
                                                    <h6><img src="assets\img\lokasi.png" alt="Image Description"
                                                            style="width: 100%; height: 100%;"></h6>
                                                </div>
                                                <div class="ps-3 mt-3">
                                                    <a class="btn btn-primary"
                                                        href="https://goo.gl/maps/s4hgPXoaycMQie4y9"
                                                        target="_blank">Enlarge Map</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- End Location -->

                                <!-- Weather -->
                                <div class="col-xxl-6 col-md-4">
                                    <div class="card blue-card">

                                        <div class="card-body">
                                            <h5 class="card-title">Weather</h5>
                                            <div class="d-flex align-items-center">
                                                <div class="tomorrow" data-location-id="056196" data-language="EN"
                                                    data-unit-system="METRIC" data-skin="light"
                                                    data-widget-type="aqiMini"
                                                    style="padding-bottom:22px;position:relative;">
                                                </div>
                                                <!--
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cloud-moon-fill"></i>
                      </div>
                      <div class="ps-3">
                        <h6>Mendung</h6>
                      </div>
                      -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Weather -->
                            </div>
                            <div class='col-6'>
                                <!-- <div class="card date-card"> -->
                                <!-- HTML form with a date picker and a submit button -->
                                <form method="POST" action="index.php" class="form-container">
                                    <div class="form-field">
                                        <label for="date" class="form-label">Select a date:</label>
                                        <input type="date" id="date" name="date" class="form-input" required>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button onclick="downloadCSV()" class="btn btn-primary">Download
                                            All</button>
                                    </div>

                                </form>
                                <!-- </div> -->
                            </div>
                            <!-- download all button -->
                            <div class="row">
                                <div class="form-field text-center">
                                    <!-- <button onclick="downloadCSV()" class="btn btn-primary">Download All</button> -->
                                </div>
                                <!-- <button id="downloadBtn" class="btn btn-primary">Download Data</button> -->
                                <script>
                                    function downloadCSV() {

                                        // Combine the data into a single array
                                        var data = [dates, suhu, angin, kelembapan, radiasi, surfacetemperature, voltage, current, watt];

                                        // Create the CSV content
                                        var csvContent = "data:text/csv;charset=utf-8,";

                                        // Add the header row
                                        csvContent += "Date,Relativetemperature,Windspeed,Relativehumidity,Solarirradiance,Surfacetemperature,Voltage,Current,Watt\n";

                                        // Add the data rows
                                        for (var i = 0; i < dates.length; i++) {
                                            var row = dates[i] + "," + suhu[i] + "," + angin[i] + "," + kelembapan[i] + "," + radiasi[i] + "," + surfacetemperature[i] + "," + voltage[i]+ "," + current[i]+ "," + watt[i];
                                            csvContent += row + "\n";
                                        }

                                        // Create a temporary link element and set its attributes
                                        var link = document.createElement("a");
                                        link.setAttribute("href", encodeURI(csvContent));
                                        link.setAttribute("download", "data_" + desired_date + ".csv");

                                        // Append the link element to the document body
                                        document.body.appendChild(link);

                                        // Simulate a click on the link to start the download
                                        link.click();

                                        // Remove the link element from the document body
                                        document.body.removeChild(link);
                                    }
                                </script>

                            </div>
                        </div>
                        <div class='row'>
                            <!-- chart 1 -->
                            <div class="col-6">
                                <div class="card blue-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Solar Irradiance & Relative Temperature<span>|
                                                <?php echo $desiredDate ?>
                                            </span></h5>

                                        <!-- Line Chart -->
                                        <div id="Chart1"></div>

                                        <!-- Download Button -->
                                        <button id="downloadBtn" class="btn btn-primary">Download Data</button>

                                        <script>

                                            // $suhu[] = $row['suhu'];
                                            // $radiasi[] = $row['radiasi'];
                                            // $angin[] = $row['angin'];
                                            // $kelembapan[] = $row['kelembapan'];
                                            // $date[] = $row['date'];
                                            // $arus_sebelum[] = $row['arus_sebelum'];
                                            // $arus_sesudah[] = $row['arus_sesudah'];
                                            // $tegangan_sebelum[] = $row['tegangan_sebelum'];
                                            // $tegangan_sesudah[] = $row['tegangan_sesudah'];

                                            document.addEventListener("DOMContentLoaded", () => {
                                                var adjustedDates = dates.map(date => {
                                                    var utcDate = new Date(date);
                                                    utcDate.setUTCHours(utcDate.getUTCHours() + 7); // Adjust the hours for UTC+07
                                                    return utcDate.toISOString();
                                                });

                                                var chartData = {
                                                    series: [
                                                        {
                                                            name: 'Solar Irradiance(W/m²)',
                                                            data: radiasi,
                                                        },
                                                        {
                                                            name: 'Relative Temperature(°C)',
                                                            data: suhu
                                                        }
                                                    ],
                                                    chart: {
                                                        height: 'auto',
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        },
                                                    },
                                                    markers: {
                                                        size: 0
                                                    },
                                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: adjustedDates,
                                                        timezone: 'Etc/GMT+7'
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        },
                                                    }
                                                };

                                                var chart = new ApexCharts(document.querySelector("#Chart1"), chartData);
                                                chart.render();

                                                // Attach click event listener to the download button
                                                document.getElementById("downloadBtn").addEventListener("click", function () {
                                                    var password = prompt("Enter the password:");
                                                    var correctPassword = "fomotelyu";

                                                    if (password === correctPassword) {
                                                        var csvContent = "data:text/csv;charset=utf-8;";

                                                        // Add the header row
                                                        csvContent += "Timestamp,Solar Irradiance,Relative Temperature\n";

                                                        // Add the data rows
                                                        for (var i = 0; i < chartData.series[0].data.length; i++) {
                                                            csvContent += chartData.xaxis.categories[i] + "," + chartData.series[0].data[i] + "," + chartData.series[1].data[i] + "\n";
                                                        }

                                                        // Create a temporary link element to trigger the download
                                                        var encodedUri = encodeURI(csvContent);
                                                        var link = document.createElement("a");
                                                        link.setAttribute("href", encodedUri);
                                                        link.setAttribute("download", "Solar Irradiance & Relative Temperature.csv");
                                                        document.body.appendChild(link); // Required for Firefox
                                                        link.click();
                                                        document.body.removeChild(link);
                                                    } else {
                                                        alert("Incorrect password. Access denied.");
                                                    }
                                                });
                                            });


                                        </script>
                                    </div>
                                </div>
                            </div>
                            <!-- end chart1 -->

                            <!-- chart 2 -->
                            <div class="col-6">
                                <div class="card blue-card">



                                    <div class="card-body">
                                        <h5 class="card-title">Relative Humidity & Wind Speed <span>|
                                                <?php echo $desiredDate ?>
                                            </span></h5>

                                        <!-- Line Chart -->
                                        <div id="Chart2"></div>

                                        <!-- Download Button -->
                                        <button id="downloadBtn2" class="btn btn-primary">Download Data</button>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                var adjustedDates = dates.map(date => {
                                                    var utcDate = new Date(date);
                                                    utcDate.setUTCHours(utcDate.getUTCHours() + 7); // Adjust the hours for UTC+07
                                                    return utcDate.toISOString();
                                                });

                                                var chartData = {
                                                    series: [
                                                        {
                                                            name: 'Relative Humidity(%)',
                                                            data: kelembapan,
                                                        },
                                                        {
                                                            name: 'Wind Speed(m/s)',
                                                            data: angin
                                                        }
                                                    ],
                                                    chart: {
                                                        height: 'auto',
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        },
                                                    },
                                                    markers: {
                                                        size: 0
                                                    },
                                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: adjustedDates,
                                                        timezone: 'Etc/GMT+7'
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        },
                                                    }
                                                };

                                                var chart = new ApexCharts(document.querySelector("#Chart2"), chartData);
                                                chart.render();

                                                // Attach click event listener to the download button
                                                document.getElementById("downloadBtn2").addEventListener("click", function () {
                                                    var password = prompt("Enter the password:");
                                                    var correctPassword = "fomotelyu";

                                                    if (password === correctPassword) {
                                                        var csvContent = "data:text/csv;charset=utf-8;";

                                                        // Add the header row
                                                        csvContent += "Timestamp,Relative Humidity,Wind Speed\n";

                                                        // Add the data rows
                                                        for (var i = 0; i < chartData.series[0].data.length; i++) {
                                                            csvContent += chartData.xaxis.categories[i] + "," + chartData.series[0].data[i] + "," + chartData.series[1].data[i] + "\n";
                                                        }

                                                        // Create a temporary link element to trigger the download
                                                        var encodedUri = encodeURI(csvContent);
                                                        var link = document.createElement("a");
                                                        link.setAttribute("href", encodedUri);
                                                        link.setAttribute("download", "Relative Humidity & Wind Speed.csv");
                                                        document.body.appendChild(link); // Required for Firefox
                                                        link.click();
                                                        document.body.removeChild(link);
                                                    } else {
                                                        alert("Incorrect password. Access denied.");
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <!-- end chart2 -->

                            <!-- chart 3 -->
                            <div class="col-6">
                                <div class="card blue-card">



                                    <div class="card-body">
                                        <h5 class="card-title">Surface Temperature PV & Voltage <span>|
                                                <?php echo $desiredDate ?>
                                            </span></h5>

                                        <!-- Line Chart -->
                                        <div id="Chart3"></div>

                                        <!-- Download Button -->
                                        <button id="downloadBtn3" class="btn btn-primary">Download Data</button>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                var adjustedDates = dates.map(date => {
                                                    var utcDate = new Date(date);
                                                    utcDate.setUTCHours(utcDate.getUTCHours() + 7); // Adjust the hours for UTC+07
                                                    return utcDate.toISOString();
                                                });

                                                var chartData = {
                                                    series: [
                                                        {
                                                            name: 'Surface Temperature PV(°C)',
                                                            data: surfacetemperature,
                                                        },
                                                        {
                                                            name: 'Voltage(V)',
                                                            data: voltage
                                                        }
                                                    ],
                                                    chart: {
                                                        height: 'auto',
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        },
                                                    },
                                                    markers: {
                                                        size: 0
                                                    },
                                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: adjustedDates,
                                                        timezone: 'Etc/GMT+7'
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        },
                                                    }
                                                };

                                                var chart = new ApexCharts(document.querySelector("#Chart3"), chartData);
                                                chart.render();

                                                // Attach click event listener to the download button
                                                document.getElementById("downloadBtn3").addEventListener("click", function () {
                                                    var password = prompt("Enter the password:");
                                                    var correctPassword = "fomotelyu";

                                                    if (password === correctPassword) {
                                                        var csvContent = "data:text/csv;charset=utf-8;";

                                                        // Add the header row
                                                        csvContent += "Timestamp,Surface Temperature PV,voltage\n";

                                                        // Add the data rows
                                                        for (var i = 0; i < chartData.series[0].data.length; i++) {
                                                            csvContent += chartData.xaxis.categories[i] + "," + chartData.series[0].data[i] + "," + chartData.series[1].data[i] + "\n";
                                                        }

                                                        // Create a temporary link element to trigger the download
                                                        var encodedUri = encodeURI(csvContent);
                                                        var link = document.createElement("a");
                                                        link.setAttribute("href", encodedUri);
                                                        link.setAttribute("download", "Surface Temperature PV & voltage.csv");
                                                        document.body.appendChild(link); // Required for Firefox
                                                        link.click();
                                                        document.body.removeChild(link);
                                                    } else {
                                                        alert("Incorrect password. Access denied.");
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <!-- end chart3 -->

                            <!-- chart 4 -->
                            <div class="col-6">
                                <div class="card blue-card">



                                    <div class="card-body">
                                        <h5 class="card-title">Solar Irradiance & Current <span>|
                                                <?php echo $desiredDate ?>
                                            </span></h5>

                                        <!-- Line Chart -->
                                        <div id="Chart4"></div>

                                        <!-- Download Button -->
                                        <button id="downloadBtn4" class="btn btn-primary">Download Data</button>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                var adjustedDates = dates.map(date => {
                                                    var utcDate = new Date(date);
                                                    utcDate.setUTCHours(utcDate.getUTCHours() + 7); // Adjust the hours for UTC+07
                                                    return utcDate.toISOString();
                                                });

                                                var chartData = {
                                                    series: [
                                                        {
                                                            name: 'Solar Irradiance(W/m²)',
                                                            data: radiasi,
                                                        },
                                                        {
                                                            name: 'Current(A)',
                                                            data: current
                                                        }
                                                    ],
                                                    chart: {
                                                        height: 'auto',
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        },
                                                    },
                                                    markers: {
                                                        size: 0
                                                    },
                                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: adjustedDates,
                                                        timezone: 'Etc/GMT+7'
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        },
                                                    }
                                                };

                                                var chart = new ApexCharts(document.querySelector("#Chart4"), chartData);
                                                chart.render();

                                                // Attach click event listener to the download button
                                                document.getElementById("downloadBtn4").addEventListener("click", function () {
                                                    var password = prompt("Enter the password:");
                                                    var correctPassword = "fomotelyu";

                                                    if (password === correctPassword) {
                                                        var csvContent = "data:text/csv;charset=utf-8;";

                                                        // Add the header row
                                                        csvContent += "Timestamp,Solar Irradiance,Current\n";

                                                        // Add the data rows
                                                        for (var i = 0; i < chartData.series[0].data.length; i++) {
                                                            csvContent += chartData.xaxis.categories[i] + "," + chartData.series[0].data[i] + "," + chartData.series[1].data[i] + "\n";
                                                        }

                                                        // Create a temporary link element to trigger the download
                                                        var encodedUri = encodeURI(csvContent);
                                                        var link = document.createElement("a");
                                                        link.setAttribute("href", encodedUri);
                                                        link.setAttribute("download", "Solar Irradiance & Current.csv");
                                                        document.body.appendChild(link); // Required for Firefox
                                                        link.click();
                                                        document.body.removeChild(link);
                                                    } else {
                                                        alert("Incorrect password. Access denied.");
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <!-- end chart4 -->

                            <!-- chart 5 -->
                            <div class="col-6">
                                <div class="card blue-card">



                                    <div class="card-body">
                                        <h5 class="card-title">Voltage <span>|
                                                <?php echo $desiredDate ?>
                                            </span></h5>

                                        <!-- Line Chart -->
                                        <div id="Chart5"></div>

                                        <!-- Download Button -->
                                        <button id="downloadBtn5" class="btn btn-primary">Download Data</button>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                var adjustedDates = dates.map(date => {
                                                    var utcDate = new Date(date);
                                                    utcDate.setUTCHours(utcDate.getUTCHours() + 7); // Adjust the hours for UTC+07
                                                    return utcDate.toISOString();
                                                });

                                                var chartData = {
                                                    series: [
                                                        {
                                                            name: 'voltage',
                                                            data: voltage,
                                                        }
                                                    ],
                                                    chart: {
                                                        height: 'auto',
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        },
                                                    },
                                                    markers: {
                                                        size: 0
                                                    },
                                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: adjustedDates,
                                                        timezone: 'Etc/GMT+7'
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        },
                                                    }
                                                };

                                                var chart = new ApexCharts(document.querySelector("#Chart5"), chartData);
                                                chart.render();

                                                // Attach click event listener to the download button
                                                document.getElementById("downloadBtn5").addEventListener("click", function () {
                                                    var password = prompt("Enter the password:");
                                                    var correctPassword = "fomotelyu";

                                                    if (password === correctPassword) {
                                                        var csvContent = "data:text/csv;charset=utf-8;";

                                                        // Add the header row
                                                        csvContent += "Timestamp,Voltage\n";

                                                        // Add the data rows
                                                        for (var i = 0; i < chartData.series[0].data.length; i++) {
                                                            csvContent += chartData.xaxis.categories[i] + "," + chartData.series[0].data[i] + "," + chartData.series[1].data[i] + "\n";
                                                        }

                                                        // Create a temporary link element to trigger the download
                                                        var encodedUri = encodeURI(csvContent);
                                                        var link = document.createElement("a");
                                                        link.setAttribute("href", encodedUri);
                                                        link.setAttribute("download", "Voltage.csv");
                                                        document.body.appendChild(link); // Required for Firefox
                                                        link.click();
                                                        document.body.removeChild(link);
                                                    } else {
                                                        alert("Incorrect password. Access denied.");
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <!-- end chart5 -->

                            <!-- chart 6 -->
                            <div class="col-6">
                                <div class="card blue-card">



                                    <div class="card-body">
                                        <h5 class="card-title">Current <span>|
                                                <?php echo $desiredDate ?>
                                            </span></h5>

                                        <!-- Line Chart -->
                                        <div id="Chart6"></div>

                                        <!-- Download Button -->
                                        <button id="downloadBtn6" class="btn btn-primary">Download Data</button>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                var adjustedDates = dates.map(date => {
                                                    var utcDate = new Date(date);
                                                    utcDate.setUTCHours(utcDate.getUTCHours() + 7); // Adjust the hours for UTC+07
                                                    return utcDate.toISOString();
                                                });

                                                var chartData = {
                                                    series: [
                                                        {
                                                            name: 'Current',
                                                            data: current,
                                                        }
                                                    ],
                                                    chart: {
                                                        height: 'auto',
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        },
                                                    },
                                                    markers: {
                                                        size: 0
                                                    },
                                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: adjustedDates,
                                                        timezone: 'Etc/GMT+7'
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        },
                                                    }
                                                };

                                                var chart = new ApexCharts(document.querySelector("#Chart6"), chartData);
                                                chart.render();

                                                // Attach click event listener to the download button
                                                document.getElementById("downloadBtn6").addEventListener("click", function () {
                                                    var password = prompt("Enter the password:");
                                                    var correctPassword = "fomotelyu";

                                                    if (password === correctPassword) {
                                                        var csvContent = "data:text/csv;charset=utf-8;";

                                                        // Add the header row
                                                        csvContent += "Timestamp,Current\n";

                                                        // Add the data rows
                                                        for (var i = 0; i < chartData.series[0].data.length; i++) {
                                                            csvContent += chartData.xaxis.categories[i] + "," + chartData.series[0].data[i] + "," + chartData.series[1].data[i] + "\n";
                                                        }

                                                        // Create a temporary link element to trigger the download
                                                        var encodedUri = encodeURI(csvContent);
                                                        var link = document.createElement("a");
                                                        link.setAttribute("href", encodedUri);
                                                        link.setAttribute("download", "Current.csv");
                                                        document.body.appendChild(link); // Required for Firefox
                                                        link.click();
                                                        document.body.removeChild(link);
                                                    } else {
                                                        alert("Incorrect password. Access denied.");
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <!-- end chart6 -->






                        </div>
                    </div>
                </div><!-- End Left side columns -->
            </div>
            </div>

            <!-- Right side columns -->

            <!-- </div> -->
        </section>


    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <!-- <footer id="footer" class="footer">
  </footer>End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script>
        (function (d, s, id) {
            if (d.getElementById(id)) {
                if (window.__TOMORROW__) {
                    window.__TOMORROW__.renderWidget();
                }
                return;
            }
            const fjs = d.getElementsByTagName(s)[0];
            const js = d.createElement(s);
            js.id = id;
            js.src = "https://www.tomorrow.io/v1/widget/sdk/sdk.bundle.min.js";

            fjs.parentNode.insertBefore(js, fjs);
        })(document, 'script', 'tomorrow-sdk');
    </script>
    <script src="plugins/chart.js/Chart.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>


</body>

</html>