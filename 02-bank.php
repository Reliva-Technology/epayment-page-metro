<?php
$config_filename = 'config.json';
if (!file_exists($config_filename)) {
    throw new Exception("Can't find ".$config_filename);
}
$config = json_decode(file_get_contents($config_filename), true);
$env = 'production';
$mode = $_POST['payment_mode'];
if($mode == 'fpx'){
    $fpx = '01';
    $bank_type = 'Individual';
    $bank_description = 'For payment minimum RM 1 up to RM 30,000';
} else {
    $fpx = '02';
    $bank_type = 'Corporate';
    $bank_description = 'For payment minimum RM 2 up to RM 1,000,000';
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
                    <h3>Online Banking (<?php echo $bank_type ?>)</h3>
                    <p><?php echo $bank_description ?></p>
                    <div class="list-group list-custom-small" id="bank-list"></div>
                </div>
            </div>
            <form method="post" action="action.php?id=confirm-payment" id="form-bayar">
                <input type="hidden" id="bank-code" name="BANK_CODE" value="">
                <input type="hidden" id="bank-name" name="BANK_NAME" value="">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
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

        </script>
</body>