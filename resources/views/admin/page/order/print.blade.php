<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.6">
    <title>Print</title>
</head>
<body>
{!! DNS1D::getBarcodeHTML($order->number, 'C39', 2, 30, 'black', true) !!}
<script type="text/javascript">
    window.onload = function() { window.print();window.close(); }
</script>
</body>
</html>
