<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteSetting->site_title }}</title>
    <meta name="description" content="{{ $siteSetting->site_description }}">
    <meta name="keywords" content="{{ $siteSetting->site_keywords }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .setting-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .setting-label {
            font-weight: bold;
            color: #3498db;
            margin-bottom: 5px;
        }

        .setting-value {
            padding-left: 15px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <h1>網站設定測試頁面</h1>

    <div class="container">
        <div class="setting-item">
            <div class="setting-label">網站名稱：</div>
            <div class="setting-value">{{ $siteSetting->site_name }}</div>
        </div>

        <div class="setting-item">
            <div class="setting-label">網站標題：</div>
            <div class="setting-value">{{ $siteSetting->site_title }}</div>
        </div>

        <div class="setting-item">
            <div class="setting-label">網站描述：</div>
            <div class="setting-value">{{ $siteSetting->site_description }}</div>
        </div>

        <div class="setting-item">
            <div class="setting-label">網站關鍵詞：</div>
            <div class="setting-value">{{ $siteSetting->site_keywords }}</div>
        </div>

        <div class="setting-item">
            <div class="setting-label">聯繫郵箱：</div>
            <div class="setting-value">{{ $siteSetting->contact_email ?? '未設定' }}</div>
        </div>

        <div class="setting-item">
            <div class="setting-label">聯繫電話：</div>
            <div class="setting-value">{{ $siteSetting->contact_phone ?? '未設定' }}</div>
        </div>

        <div class="setting-item">
            <div class="setting-label">聯繫地址：</div>
            <div class="setting-value">{{ $siteSetting->contact_address ?? '未設定' }}</div>
        </div>

        <div class="setting-item">
            <div class="setting-label">社交媒體：</div>
            <div class="setting-value">
                Facebook: {{ $siteSetting->facebook_url ?? '未設定' }}<br>
                Instagram: {{ $siteSetting->instagram_url ?? '未設定' }}<br>
                Twitter: {{ $siteSetting->twitter_url ?? '未設定' }}<br>
                YouTube: {{ $siteSetting->youtube_url ?? '未設定' }}<br>
                Line: {{ $siteSetting->line_url ?? '未設定' }}
            </div>
        </div>
    </div>

    <div class="footer">
        {!! $siteSetting->footer_copyright !!}
    </div>
</body>

</html>
