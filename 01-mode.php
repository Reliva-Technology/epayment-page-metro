<?php
$config_filename = 'config.json';
if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}
$config = json_decode(file_get_contents($config_filename), true);
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
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="theme-light">
    <div id="page">
        <div class="page-content">
            <div class="card">
                <div class="content mb-2">
                    <h3>Payment Mode</h3>
                    <p>Choose Online Banking or Credit/Debit Card</p>
                    <div class="list-group list-custom-small" id="payment-mode">
                        <a href="#" class="payment-mode" data-payment-mode="fpx"><img src="images/fpx.svg" height="48" title="Personal Banking" alt="Personal Banking"><span class="mx-3">Personal Banking</span><i class="fa fa-angle-right"></i></a>
                        <a href="#" class="payment-mode" data-payment-mode="fpx1"><img src="images/fpx.svg" height="48" title="Corporate Banking" alt="Corporate Banking"><span class="mx-3">Corporate Banking</span><i class="fa fa-angle-right"></i></a>
                        <a href="#" class="payment-mode" data-payment-mode="migs"><img src="images/visa.svg" height="48" title="Credit/Debit Card" alt="Credit/Debit Card"><img src="images/mastercard.svg" height="48" title="Credit/Debit Card" alt="Credit/Debit Card"><span class="mx-3">Credit/Debit Card</span><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="alert alert-primary mt-2">Individu: Minimum RM 1.00 dan maksimum RM 30,000.00<br>Korporat: Minimum RM 2.00 dan maksimum RM 1,000,000.00</div>
                </div>
            </div>
            <form method="post" action="action.php?id=choose-bank" id="form-bayar">
                <input type="hidden" id="payment-mode" name="payment_mode" value="">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script>
        $('.payment-mode').each(function() {
            $(this).click(function() {
                let payment_mode = $(this).data('payment-mode');
                $('#payment-mode').val(payment_mode);
                $("#form-bayar").submit();
            });
        });
    </script>
</body>