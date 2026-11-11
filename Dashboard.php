
<?php

session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: reader.php");
    exit;
}

// TOTAL PARKING SLOTS
$totalSlots = $pdo->query(
    "SELECT COUNT(*) FROM parking_slots"
)->fetchColumn();

// OCCUPIED SLOTS
$occupiedSlots = $pdo->query(
    "SELECT COUNT(*) FROM parking_slots
     WHERE status = 'occupied'"
)->fetchColumn();

// AVAILABLE SLOTS
$availableSlots = $totalSlots - $occupiedSlots;

// TOTAL CARS
$totalCars = $pdo->query(
    "SELECT COUNT(*) FROM cars"
)->fetchColumn();

// DISPLAY PARKING SLOTS
$slots = $pdo->query("
    SELECT * FROM parking_slots
    ORDER BY slot_number
")->fetchAll();

// DISPLAY PARKING RECORDS
$records = $pdo->query("
    SELECT
        parking_records.id,
        cars.plate_number,
        parking_slots.slot_number,
        parking_records.entry_time,
        parking_records.exit_time,
        attendants.name AS attendant_name

    FROM parking_records

    INNER JOIN cars
    ON parking_records.car_id = cars.id

    INNER JOIN parking_slots
    ON parking_records.slot_id = parking_slots.id

    LEFT JOIN attendants
    ON parking_records.attendant_id = attendants.id

    ORDER BY parking_records.id DESC
    LIMIT 10
")->fetchAll();

// DISPLAY PAYMENTS
$payments = $pdo->query("
    SELECT
        payments.amount,
        payments.payment_method,
        payments.payment_date,
        cars.plate_number

    FROM payments

    INNER JOIN parking_records
    ON payments.record_id = parking_records.id

    INNER JOIN cars
    ON parking_records.car_id = cars.id

    ORDER BY payments.id DESC
    LIMIT 5
")->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Parking Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="topbar">

    <div>
        <h1>Car Parking Dashboard</h1>

        <p>
            Welcome,
            <?= htmlspecialchars($_SESSION["user_name"]) ?>
        </p>
    </div>

    <a href="logout.php" class="logout">
        Logout
    </a>

</header>

<div class="container">

    <div class="stats">

        <div class="stat">
            <span>Total Slots</span>
            <strong><?= $totalSlots ?></strong>
        </div>

        <div class="stat">
            <span>Occupied</span>
            <strong><?= $occupiedSlots ?></strong>
        </div>

        <div class="stat">
            <span>Available</span>
            <strong><?= $availableSlots ?></strong>
        </div>

        <div class="stat">
            <span>Total Cars</span>
            <strong><?= $totalCars ?></strong>
        </div>

    </div>

    <div class="panel">

        <h2>Parking Slots</h2>

        <div class="slot-grid">

            <?php foreach ($slots as $slot): ?>

                <div class="slot
                <?= $slot["status"] == "occupied"
                ? "occupied"
                : ($slot["status"] == "available"
                ? "available" : "maintenance") ?>">

                    <strong>
                        <?= htmlspecialchars($slot["slot_number"]) ?>
                    </strong>

                    <span>
                        <?= htmlspecialchars($slot["status"]) ?>
                    </span>

                </div>

            <?php endforeach; ?>

        </div>

        <p class="hint">
            Green = Available | Red = Occupied | Yellow = Maintenance
        </p>

    </div>

    <div class="panel">

        <h2>Recent Parking Records</h2>

        <div class="table-wrap">

        <table>

            <tr>
                <th>Plate Number</th>
                <th>Slot</th>
                <th>Entry Time</th>
                <th>Exit Time</th>
                <th>Attendant</th>
            </tr>

            <?php foreach ($records as $record): ?>

                <tr>

                    <td><?= htmlspecialchars($record["plate_number"]) ?></td>

                    <td><?= htmlspecialchars($record["slot_number"]) ?></td>

                    <td><?= htmlspecialchars($record["entry_time"]) ?></td>

                    <td>
                        <?= htmlspecialchars($record["exit_time"] ?? "Still parked") ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($record["attendant_name"] ?? "Not assigned") ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

        </div>

    </div>

    <div class="panel">

        <h2>Recent Payments</h2>

        <div class="table-wrap">

        <table>

            <tr>
                <th>Car Number</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
            </tr>

            <?php foreach ($payments as $payment): ?>

                <tr>

                    <td><?= htmlspecialchars($payment["plate_number"]) ?></td>

                    <td><?= number_format($payment["amount"], 0) ?> RWF</td>

                    <td><?= htmlspecialchars($payment["payment_method"]) ?></td>

                    <td><?= htmlspecialchars($payment["payment_date"]) ?></td>

                </tr>

            <?php endforeach; ?>

        </table>

        </div>

    </div>

</div>

<?php require_once "footer.php"; ?>

</body>
</html>
