<?php
$config_filename = 'config.json';
if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}
$config = json_decode(file_get_contents($config_filename), true);
$env = 'production';
// Takes raw data from the request
$json = file_get_contents('php://input');
// Converts it into a PHP object
$input = json_decode($json, true);
?>
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
        <link rel="stylesheet" type="text/css" href="css/bank.css" />
    </head>

    <body>

        <!-- content start -->
        <section class="section">
            <div class="container-fluid">

                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="card border">
                            <div class="card-header">
                                <h4>Maklumat Pembayaran</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="action.php?id=confirm-payment" id="form-bayar">

                                <div class="form-group row">
                                    <label for="merchant" class="col-lg-3 col-form-label">Agensi</label>
                                    <div class="col-lg-9">
                                        <input type="text" readonly class="form-control" name="merchant" value="MyManjung - Majlis Perbandaran Manjung" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="trans_id" class="col-lg-3 col-form-label">ID Transaksi</label>
                                    <div class="col-lg-9">
                                        <input type="text" readonly class="form-control" name="TRANS_ID" value="<?php echo $input['TRANS_ID'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payee_name" class="col-lg-3 col-form-label">Nama Pembayar</label>
                                    <div class="col-lg-9">
                                        <input type="text" readonly class="form-control" name="payee_name" value="<?php echo $input['payee_name'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payee_email" class="col-lg-3 col-form-label">Email</label>
                                    <div class="col-lg-9">
                                        <input type="text" readonly class="form-control" name="EMAIL" value="<?php echo $input['payee_email'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="amount" class="col-lg-3 col-form-label">Jumlah</label>
                                    <div class="col-lg-9">
                                        <input type="text" readonly class="form-control" name="AMOUNT" value="<?php echo $input['AMOUNT'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-lg-3 col-form-label">Keterangan</label>
                                    <div class="col-lg-9">
                                        <input type="text" readonly class="form-control" name="description" value="<?php echo $input['payment_details'] ?>" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card border">
                            <div class="card-header">
                                <h4>Pilihan Pembayaran</h4>
                            </div>
                            <div class="card-body">

                                <img src="images/fpx.svg" height="64px" class="float-right">
                                <p class="mb-4 pt-1">Pembayaran menggunakan akaun bank anda</p>

                                <div class="row mb-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fpx" name="payment_mode" class="custom-control-input" value="fpx">
                                            <label class="custom-control-label" for="fpx">Perbankan Internet (Individu)</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fpx1" name="payment_mode" class="custom-control-input" value="fpx1">
                                            <label class="custom-control-label" for="fpx1">Perbankan Internet (Korporat)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hiddenradio" id="select_bank"></div>

                                <input type="hidden" name="be_message" id="be_message">

                                <div class="alert alert-info">Individu: Minimum RM 1.00 dan maksimum RM 30,000.00<br>Korporat: Minimum RM 2.00 dan maksimum RM 1,000,000.00</div>
                                
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="agree" name="agree" required="">
                                            <label class="custom-control-label" for="agree">Dengan memilih mod pembayaran ini, anda bersetuju dengan <a href="https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp" target="_blank">terma dan syarat</a> FPX.</label>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <img src="images/visa.svg" height="64px" class="float-right">
                                <img src="images/mastercard.svg" height="64px" class="float-right">
                                <p class="mb-3 pt-1">Pembayaran menggunakan kad kredit/debit</p>
                                <div class="row mb-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="migs" name="payment_mode" class="custom-control-input" value="migs">
                                            <label class="custom-control-label" for="migs">Kad Kredit/Debit</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="MERCHANT_CODE" value="<?php echo $input['MERCHANT_CODE'] ?>">
                                <input type="hidden" id="bank-code" name="BANK_CODE" value="">
                                <input type="hidden" id="bank-name" name="BANK_NAME" value="">
                                <button type="submit" class="btn bg-biru text-white">Pembayaran</button>
                                </form>
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
        <script>
            $('#fpx').on('change', function() {
                var mode = "01";
                $('#select_bank').empty();
                get_list(mode);
                $('#select_bank').show();
            });

            $('#fpx1').on('change', function() {
                var mode = "02";
                $('#select_bank').empty();
                get_list(mode);
                $('#select_bank').show();
            });

            $('#migs').on('change', function() {
                $('#select_bank').empty().hide();
                $('#agree').prop("checked", false);
            });

            function get_list(mode){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "php/bank-list.php",
                    data:{
                        mode: mode,
                        env: '<?php echo $env ?>'
                    },
                    success: function(response) {
                        $.each(response.bank_list, function(key,value){
                            $('#select_bank').append('<div class="col-lg-3 col-xs-6"><label for="'+ key +'" class="bank"><input type="radio" id="'+ key +'" value="'+ key +'" class="bank-code" name="bank_code"><img src="images/bank/'+ key +'.png" height="70" title="'+ value +'" alt="'+ value +'">'+ value +'</label></div>');
                        });
                        $('#be_message').val(response.be_message);
                        $('.bank-code').each(function() {
                            $(this).click(function() {
                                let bank_code = $(this).val();
                                $('#bank-code').val(bank_code);
                                console.log(bank_code);
                            });
                        });
                    }
                });
            }

        </script>
    </body>
</html>
