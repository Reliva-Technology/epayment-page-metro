<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>E-Payment</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="Fadli Saad" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="images/favicon.png">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="css/materialdesignicons.min.css" />

        <!-- Custom css -->
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>

        <!-- content start -->
        <section class="section">
            <div class="container-fluid">

                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="card border">
                            <div class="card-header">
                                <h4>Pengesahan</h4>
                            </div>
                            <div class="card-body">
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

                                <dl class="row">
                                    <dt class="col-md-4">ID Transaksi</dt>
                                    <dd class="col-md-8"><?php echo $data['TRANS_ID'] ?? '' ?></dd>
                                    <dt class="col-md-4">Nama Pembayar</dt>
                                    <dd class="col-md-8"><?php echo $data['payee_name'] ?? '' ?></dd>
                                    <dt class="col-md-4">Email</dt>
                                    <dd class="col-md-8"><?php echo $data['EMAIL'] ?? '' ?></dd>
                                    <dt class="col-md-4">Jumlah</dt>
                                    <dd class="col-md-8">RM <?php echo number_format($data['AMOUNT'],2) ?? '' ?></dd>
                                    <dt class="col-md-4">Keterangan</dt>
                                    <dd class="col-md-8"><?php echo $data['description'] ?? '' ?></dd>
                                    <dt class="col-md-4">Agensi</dt>
                                    <dd class="col-md-8"><?php echo $data['merchant'] ?? '' ?></dd>
                                    <dt class="col-md-4">Kaedah Pembayaran</dt>
                                    <?php
                                        switch($data['payment_mode']){

                                        }
                                    ?>
                                    <dd class="col-md-8"><?php echo $payment_mode ?? '' ?></dd>
                                    <?php if($data['payment_mode'] != 'migs'): ?>
                                    <dt class="col-md-4">Bank</dt>
                                    <dd class="col-md-8"><?php echo $data['BANK_NAME'] ?? '' ?></dd>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </dl>
                            </div>
                            <div class="card-footer">
                                <a href="#" onclick="submitForm()" class="btn bg-biru text-white"><i class="fa fa-print"></i> Bayar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </section>

        <!-- javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>

        <!-- custom js -->
        <script src="js/app.js"></script>
        <script type='text/javascript'>
            function submitForm() {
                document.getElementById('confirm').submit();
            }
        </script>
    </body>
</html>
