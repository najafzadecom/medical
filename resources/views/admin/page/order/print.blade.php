<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
</head>
<body>
{!! DNS1D::getBarcodeSVG($order->number, 'UPCA') !!}
<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>
</body>
</html>
