<!DOCTYPE html>
<html>
<head>
    <title>500 Internal Server Error</title>
</head>
<body style="background:#1e1e1e;color:#f8f9fa;font-family:monospace;padding:30px;line-height:1.5;">
    <h2 style="color:#ff6b6b;">Application Error (500)</h2>
    <div style="background:#2d2d2d;padding:20px;border-radius:6px;border-left:4px solid #ff6b6b;">
        <p><b>Message:</b> {{ $exception->getMessage() }}</p>
        <p><b>File:</b> {{ $exception->getFile() }} : <b>{{ $exception->getLine() }}</b></p>
    </div>
    <h3>Stack Trace:</h3>
    <pre style="background:#252526;padding:15px;overflow:auto;max-height:500px;border-radius:4px;font-size:12px;">{{ $exception->getTraceAsString() }}</pre>
</body>
</html>
