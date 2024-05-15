<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <title>{{ $document->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .content {
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>{{ $document->name }}</h1>
    <div class="content">{!! $content !!}</div>
</div>
</body>
</html>
