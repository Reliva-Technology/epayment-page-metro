<?php
$config_filename = 'config.json';
if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}
$config = json_decode(file_get_contents($config_filename), true);
$mode = $_POST['payment_mode'];
if($mode == 'fpx'){
    $fpx = '01';
    $bank_type = 'Individual';
    $bank_description = 'For payment minimum RM 1.00 up to RM 30,000';
} else {
    $fpx = '02';
    $bank_type = 'Corporate';
    $bank_description = 'For payment minimum RM 2.00 up to RM 1,000,000';
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>E-Payment</title>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="styles/custom.css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="theme-light">
<section class="section d-flex justify-content-center align-items-center mt-3">
    <div class="row">
        <div class="cols">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center">Payment Details</h5>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Payee Name</dt><dd><?php echo $_POST['CUSTOMER_NAME'] ?></dd>
                        <dt>E-mail</dt><dd><?php echo $_POST['CUSTOMER_EMAIL'] ?></dd>
                        <dt>Telephone</dt><dd><?php echo $_POST['CUSTOMER_MOBILE'] ?></dd>
                        <dt>Transaction ID</dt><dd><?php echo $_POST['ORDER_ID'] ?></dd>
                        <dt>Details</dt><dd><?php echo $_POST['TXN_DESC'] ?></dd>
                        <dt>Payment Mode</dt><dd><?php echo ($_POST['payment_mode'] == 'migs') ? 'Credit/Debit Card' : 'Internet Banking - '.$_POST['BANK_NAME'] ?></dd>
                        <dt>TOTAL AMOUNT</dt><dd>RM <?php echo $_POST['AMOUNT'] ?></dd>
                    </dl>
                    <?php
                        $data = $_POST;

                        echo "<form id='confirm' action='action.php?id=process-payment' method='post'>";
                        if (is_array($data) || is_object($data))
                        {
                            foreach ($data as $key => $val) {
                                echo "<input type='hidden' name='".$key."' value='".$val."'>";
                            }
                        }
                        echo "</form>";
                    ?>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-2">
                        <a href="#" onclick="submitForm()" class="btn btn-primary me-md-2">Make Payment</a>
                        <a href="#" onclick="cancel()" class="btn btn-danger">Cancel Payment</a>
                    </div>
                </div>
                <!-- <div class="card-footer">
                    <p class="text-center">Majlis Perbandaran Manjung. Hakcipta Terpelihara &copy; <?php echo date('Y') ?></p>
                    <p class="text-center"><img src="images/logo.png" title="logo" alt="logo" height="48px" class="img"></p>
                </div> -->
            </div>
        </div>
    </div>
</section>
    
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type='text/javascript'>
        function submitForm() {
            document.getElementById('confirm').submit();
        }

        function cancel() {
            document.getElementById("confirm").action = 'action.php?id=cancel-payment';
            submitForm();
        }
    </script>
</body>
</html>