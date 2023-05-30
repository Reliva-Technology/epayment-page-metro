<?php
$config_filename = 'config.json';
if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}
$config = json_decode(file_get_contents($config_filename), true);

if($config['maintenance'] == 'on'){
    header('Location:maintenance.php');
    exit;
}
$env = 'production';
$merchant_code = '';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>E-Payment Demo</title>
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

        <!-- Custom  sCss -->
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>

        <!-- home start -->
        <section class="bg-home bg-biru" id="home">
            <div class="home-center">
                <div class="home-desc-center">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <h2 class="text-white">Pembayaran</h2>
                                    <p>Isikan maklumat pembayaran seperti dibawah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- home end -->

        <!-- content start -->
        <section class="section">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="border p-3 mb-3 rounded">
                            <form method="post" action="action.php?id=confirm-payment" id="form-bayar">
                            <h4>Perbankan Internet dan Kad Kredit/Debit</h4>
                            <img src="images/fpx.svg" height="64px" class="float-right">
                            <p class="mb-4 pt-1">Pembayaran menggunakan akaun bank anda</p>

                            <div class="alert alert-info">Individu: Minimum RM 1.00 dan maksimum RM 30,000.00<br>Korporat: Minimum RM 2.00 dan maksimum RM 1,000,000.00</div>

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

                            <div class="row mb-3">
                                <div class="select_bank"></div>
                                <div class="col">
                                    <select name="bank_code" id="bank_code" class="custom-select" required="">
                                        <option>- Pilih Bank-</option>
                                    </select>
                                    <input type="hidden" name="be_message" id="be_message">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="agree" name="agree" required="">
                                        <label class="custom-control-label" for="agree">Dengan memilih mod pembayaran ini, anda bersetuju dengan <a href="https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp" target="_blank">terma dan syarat</a> FPX.</label>
                                    </div>
                                </div>
                            </div>

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

                            <div class="mt-3">
                                <button type="submit" class="btn bg-biru text-white">Pembayaran</button>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </section>

        <!-- footer start -->
        <footer class="footer bg-biru">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="text-white">&copy; 2023 Hakcipta Terpelihara</p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </footer>
        <!-- footer end -->
        
        <!-- Back to top -->    
        <a href="#" class="back-to-top" id="back-to-top"> <i class="mdi mdi-chevron-up"> </i> </a>

        <!-- javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>

        <!-- custom js -->
        <script src="js/app.js"></script>
        <script>
            $('#fpx').on('change', function() {

                var mode = "01";
                $('#bank_code').empty();
                get_list(mode);
            });

            $('#fpx1').on('change', function() {

                var mode = "02";
                $('#bank_code').empty();
                get_list(mode);
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
                            $('#bank_code').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        $('#be_message').val(response.be_message);
                    }
                });
            }
           
        </script>
    </body>
</html>
