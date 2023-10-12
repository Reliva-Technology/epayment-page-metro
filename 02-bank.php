<?php
$config_filename = 'config.json';
if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}
$config = json_decode(file_get_contents($config_filename), true);
$data = $_POST;
$payload = NULL;
foreach ($data as $key => $val) {
    $payload .= "<input type='hidden' name='".$key."' value='".$val."'>";
}
$env = 'production';
$mode = $_POST['payment_mode'];
if($mode == 'fpx'){
    $fpx = '01';
    $bank_type = 'Individual';
    $bank_description = 'For payment minimum RM 1.00 and maximum RM 30,000.00 (including charges, if any)';
} else {
    $fpx = '02';
    $bank_type = 'Corporate';
    $bank_description = 'For payment minimum RM 2.00 and maximum RM 1,000,000.00 (including charges, if any)';
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
                    <h3 class="text-center">Internet Banking (<?php echo $bank_type ?>)</h3>
                </div>
                <div class="content mb-2">
                    <p class="text-center"><?php echo $bank_description ?></p>
                    <div class="extraHeader">
                        <form class="search-form">
                            <div class="form-group searchbox">
                                <input type="text" class="form-control" placeholder="Search..." id="filter">
                                <i class="fa-solid fa-magnifying-glass" style="left: 30px;position: fixed;"></i>
                            </div>
                        </form>
                    </div>
                    <div class="list-group list-custom-small" id="bank-list"></div>
                    <div class="d-grid gap-2 col-6 mx-auto mt-2">
                        <a href="#" onclick="history.back()" class="btn btn-danger">Back</a>
                    </div>
                </div>
                <!-- <div class="card-footer">
                    <p class="text-center">Majlis Perbandaran Manjung. Hakcipta Terpelihara &copy; <?php echo date('Y') ?></p>
                    <p class="text-center"><img src="images/logo.png" title="logo" alt="logo" height="48px" class="img"></p>
                </div> -->
            </div>
            <form method="post" action="action.php?id=confirm-payment" id="form-bayar">
                <input type="hidden" id="bank-code" name="BANK_CODE" value="">
                <input type="hidden" id="bank-name" name="BANK_NAME" value="">
                <input type="hidden" id="be_message" name="BE_MESSAGE">
                <?php echo $payload ?>
            </form>
        </div>
    </div>
</section>
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script src="scripts/jquery.min.js"></script>
    <script>
        function get_list(){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/bank-list.php",
                data:{
                    mode: '<?php echo $fpx ?>',
                    env: '<?php echo $env ?>'
                },
                success: function(response) {
                    $.each(response.bank_list, function(key,value){
                        $('#bank-list').append('<a href="#" class="bank-code" data-bank-code="'+ key +'" data-bank-name="'+ value +'"><img src="images/bank/'+ key +'.png" height="48" title="'+ value +'" alt="'+ value +'"><span class="mx-3">'+ value +'</span><i class="fa fa-angle-right"></i></a>');
                    });
                    $('#be_message').val(response.be_message);
                    $('.bank-code').each(function() {
                        $(this).click(function() {
                            let bank_code = $(this).data('bank-code');
                            let bank_name = $(this).data('bank-name');
                            $('#bank-code').val(bank_code);
                            $('#bank-name').val(bank_name);
                            $("#form-bayar").submit();
                        });
                    });
                }
            });
        }
        get_list();

        $("#filter").keyup(function() {

            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val(),
            count = 0;

            // Loop through the comment list
            $('#bank-list a').each(function() {


                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).hide();

                // Show the list item if the phrase matches and increase the count by 1
                } else {
                $(this).show();
                count++;
                }

            });

        });

        </script>
</body>
</html>