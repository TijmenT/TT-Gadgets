<!DOCTYPE html>
<html>

<head>
    <title>Log Search</title>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <style>
        .selected-dates {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php
    $FoundAnything = 0;
    $logFolders = glob('logs/*', GLOB_ONLYDIR);

    if (isset($_GET['logtype'])) {
        if (!empty($_POST['dates'])) {
            $selectedDates = explode(', ', $_POST['dates'][0]);
            foreach ($selectedDates as $selectedDate) {
                $logFile = "logs/" . $_POST['company'] . "/" . $selectedDate . ".log";
                if (file_exists($logFile)) {
                    $myfile = fopen($logFile, "r") or die("Unable to open file!");
                    while (($line = fgets($myfile)) !== false) {
                        $includeLine = true;
                        if (isset($_POST['type'])) {
                            if ($_POST['type'] != "All" && !str_contains($line, "type: " . $_POST['type'])) {
                                $includeLine = false;
                            }
                        }
                        if ($_POST['userid'] !== "All") {
                            if (!str_contains($line, "UserID: " . $_POST['userid'])) {
                                $includeLine = false;
                            }
                        }
                        if ($includeLine) {
                            $FoundAnything += 1;
                            echo $line . '<br>';
                        }
                    }
                    fclose($myfile);
                }
            }
            if ($FoundAnything == 0) {
                echo "Geen data gevonden. <a href='check_log.php'>Opnieuw Zoeken?</a>";
            }
        } else {
            echo "Select at least one date. <a href='check_log.php'>Back</a>";
        }
    } else {
        ?>

        <form action="check_log.php?logtype=GetLogs" method="post">
            <label for="company">Bedrijf:</label>
            <select name="company" required>
                <?php foreach ($logFolders as $folder) {
                    $folderName = basename($folder);
                    echo "<option value='$folderName'>$folderName</option>";
                } ?>
            </select>
            <br><br>
            <label for="dates">Select Date Range:</label>
            <input type="text" id="date-range" name="dates[]" multiple="multiple">
            <br><br>

            <label for="userid">User ID:</label>
            <input type="text" value="All" name="userid">
            <br><br>

            <label for="type">Type:</label>
            <select name="type">
                <option value="All">All</option>
                <option value="login">Login</option>
                <option value="register">Register</option>
                <option value="Paid">Paid</option>
                <option value="Checkout">Checkout</option>
            </select>
            <br><br>

            <div class="selected-dates">Selected Dates: <span id="selected-dates-display"></span></div>
            <br>
            <button type="submit">Search</button>
        </form>

        <script>
            $(function () {
                var selectedDates = [];

                $('#date-range').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: 'DD-MM-YYYY',
                        cancelLabel: 'Clear'
                    }
                });

                $('#date-range').on('apply.daterangepicker', function (ev, picker) {
                    selectedDates = [];
                    var startDate = picker.startDate.format('DD-MM-YYYY');
                    var endDate = picker.endDate.format('DD-MM-YYYY');

                    var currentDate = moment(startDate, 'DD-MM-YYYY');
                    var endDateObj = moment(endDate, 'DD-MM-YYYY');

                    while (currentDate.isSameOrBefore(endDateObj)) {
                        selectedDates.push(currentDate.format('DD-MM-YYYY'));
                        currentDate.add(1, 'days');
                    }

                    $('#date-range').val(selectedDates.join(', '));
                    $('#selected-dates-display').text(selectedDates.join(', '));
                });

                $('#date-range').on('cancel.daterangepicker', function (ev, picker) {
                    selectedDates = [];
                    $('#date-range').val('');
                    $('#selected-dates-display').text('');
                });
            });
        </script>



        <?php
    }
    ?>

</body>

</html>