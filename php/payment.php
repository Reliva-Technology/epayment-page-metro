<?php
require ('stringer.php');

class Payment
{
    private $config;

    public function __construct()
    {
        $config_filename = ROOT_DIR.'/config.json';

        if (!file_exists($config_filename)) {
            throw new Exception("Can't find ".$config_filename);
        }
        $this->config = json_decode(file_get_contents($config_filename), true);
    }

    # process online payment
    public function process($data)
    {
        if(isset($data)){

            $merchant_code = $data['MERCHANT_CODE'];
            $payment_mode = $data['payment_mode'];
            $transaction_id = $data['ORDER_ID'];

            if($payment_mode == 'fpx' || $payment_mode == 'fpx1'){
                $payment_method = 'FPX';
            } else {
                $payment_method = 'Kad Kredit/Debit';
            }

            $transaction_data = array(
                'service_id' => 1,
                'amount' => $data['AMOUNT'],
                'payment_method' => $payment_method,
                'payment_mode' => $payment_mode,
                'status' => '2',
                'payment_id' => '0'
            );

            $transaction_extra = array(
                'nama' => $data['CUSTOMER_NAME'],
                'id' => $data['CUSTOMER_ID'],
                'telefon' => $data['CUSTOMER_MOBILE'],
                'email' => $data['CUSTOMER_EMAIL']
            );

            $encrypt = new StringerController();

            $checksum_data = [
                'TRANS_ID' => $transaction_id,
                'PAYMENT_MODE' => $transaction_data['payment_mode'],
                'AMOUNT' => $transaction_data['amount'],
                'MERCHANT_CODE' => $merchant_code
            ];

            $checksum = $encrypt->getChecksum($checksum_data);
            $checksum = json_decode($checksum,true);

            $fpx_data = array(
                'TRANS_ID' => $transaction_id,
                'AMOUNT' => $transaction_data['amount'],
                'PAYEE_NAME' => $transaction_extra['nama'],
                'PAYEE_EMAIL' => $transaction_extra['email'],
                'EMAIL' => $transaction_extra['email'],
                'PAYMENT_MODE' => $transaction_data['payment_mode'],
                'BANK_CODE' => $data['BANK_CODE'],
                'BE_MESSAGE' => $data['BE_MESSAGE'],
                'MERCHANT_CODE' => $merchant_code,
                'CHECKSUM' => trim($checksum['checksum'])
            );

            # pass to FPX controller
            echo "<form id=\"myForm\" action=\"".$this->config['fpx']['url']."\" method=\"post\">";
            foreach ($fpx_data as $a => $b) {
                echo '<input type="hidden" name="'.htmlentities($a).'" value="'.filter_var($b, FILTER_SANITIZE_STRING).'">';
            }
            foreach ($transaction_extra as $c => $d) {
                echo '<input type="hidden" name="'.htmlentities($c).'" value="'.filter_var($d, FILTER_SANITIZE_STRING).'">';
            }
            echo "</form>";
            echo "<script type=\"text/javascript\">
                document.getElementById('myForm').submit();
            </script>";

        } else {

            // error
        }
    }

    public function response()
    {
        $input = $_POST;

        $fpx_data = [
            'status' => isset($_POST['STATUS']) ? $_POST['STATUS'] : NULL,
            'status_code' => isset($_POST['STATUS_CODE']) ? $_POST['STATUS_CODE'] : NULL,
            'status_message' => isset($_POST['STATUS_MESSAGE']) ? $_POST['STATUS_MESSAGE'] : NULL,
            'payment_datetime' => $_POST['PAYMENT_DATETIME'],
            'payment_mode' => $_POST['PAYMENT_MODE'],
            'amount' => $_POST['AMOUNT'],
            'payment_transaction_id' => $_POST['PAYMENT_TRANS_ID'],
            'buyer_bank' => $_POST['BUYER_BANK'],
            'merchant_order_no' => $_POST['MERCHANT_ORDER_NO'],
            'payment_transaction_id' => $_POST['APPROVAL_CODE'],
            'trans_id' => $_POST['TRANS_ID'],
            'approval_code' => $_POST['APPROVAL_CODE'],
            'buyer_bank' => $_POST['BUYER_BANK'],
            'buyer_name' => $_POST['BUYER_NAME']
        ];

        return json_encode($fpx_data);
    }
}
