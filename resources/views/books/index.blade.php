<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Laravel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f3f4f6;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            margin: 0;
            font-size: 2.5rem;
        }
        .info-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .success {
            color: #059669;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .detail {
            padding: 15px;
            background: #f9fafb;
            border-left: 4px solid #667eea;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .detail strong {
            color: #667eea;
        }
        code {
            background: #1f2937;
            color: #10b981;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Books Page</h1>
        <p style="margin-top: 10px; opacity: 0.9;">Welcome to your first Laravel view!</p>
    </div>
    
    <div class="info-box">
        <div class="success">✅ Success! Laravel is working!</div>
        
        <div class="detail">
            <strong>Current Time:</strong> {{ date('l, F j, Y - g:i A') }}
        </div>
        
        <div class="detail">
            <strong>Route:</strong> <code>/books</code>
        </div>
        
        <div class="detail">
            <strong>View File:</strong> <code>resources/views/books/index.blade.php</code>
        </div>
        
        <div class="detail">
            <strong>Blade Syntax:</strong> The <code>{{ }}</code> automatically escapes output for security!
        </div>
        
        <h3 style="margin-top: 30px; color: #667eea;">🎯 What You Just Learned:</h3>
        <ul style="line-height: 2;">
            <li>✅ How to create a route in <code>routes/web.php</code></li>
            <li>✅ How to create a Blade view in <code>resources/views/</code></li>
            <li>✅ How to use Blade syntax <code>{{ }}</code> to output data</li>
            <li>✅ How Laravel maps URLs to views</li>
        </ul>
        
        <div style="margin-top: 30px; padding: 20px; background: #fef3c7; border-radius: 8px;">
            <strong>📖 Next Step:</strong> We'll add a database query to show real books from your database! <br>
            Check the tutorial: <code>step_by_step_tutorial.md</code>
        </div>
    </div>
</body>
</html>
