<?php
echo "Thank You for Buying with us. We hope to see you soon."
?>

<!doctype html>
<html lang="en">
<head>
    <title>PageTitle</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <!--Convert to an external stylesheet-->
    <style>
        html,
        body {
            height: 100%;
        }
        body {
            color: white;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
            color: #212121;
            border: 4px solid #ff993b;
            border-radius: 25px;
        }
        .form-signin .checkbox {
            font-weight: 400;
        }
        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
    </style>
</head>
<body class="text-center">
    <div class="form-signin bg-light">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <form>
    <input type="textbox" name="name" id="name" placeholder="Enter your name"/><br/><br/>
    <input type="textbox" name="amt" id="amt" placeholder="Enter amt"/><br/><br/>
    <input type="button" name="btn" id="btn" value="Pay Now" onclick="pay_now()"/>
    </form>
    <script>
    function pay_now(){
        var name=jQuery('#name').val();
        var amt=jQuery('#amt').val();
        var options={
            "key": "rzp_test_fiAx08cY6bevM7",
            "amount": amt *100,
            "currency": "INR",
            "name": "Acme Corp",
            "description": "Test Transaction",
            "image": "https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg",
            "handler": function (response){
                jQuery.ajax({
                    type: 'post',
                    url: 'payment_success.php',
                    data: "payment_id="+response.razorpay_payment_id+"&amt="+amt+"&name="+name,
                    success:function(result){
                        window.location.href="thank_you.php";
                    }
                });
            }
        };
        var rzp1=new Razorpay (options);
        rzp1.open();
    }
    </script>

    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>
</body>
</html>