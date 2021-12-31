<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print</title>
</head>
<body>
{!! DNS1D::getBarcodeSVG($order->number, 'C39') !!}
<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>
</body>
</html>
