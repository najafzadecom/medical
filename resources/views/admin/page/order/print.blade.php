<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
</head>
<body>
<img src="data:image/png;base64, {!! DNS1D::getBarcodePNG($order->number, 'C39', 2, 30, array(0, 0, 0), true) !!}" />
<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>
</body>
</html>
