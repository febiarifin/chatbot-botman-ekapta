<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>ChatBot Ekapta</title>
    <link rel="shortcut icon" href="{{ asset('images/mix-bot.png') }}" type="image/x-icon">
    <style>
        .chat-widget-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.9);
        }

        .chat-widget-fullscreen .chat-widget-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .chat-widget-fullscreen .chat-widget-header,
        .chat-widget-fullscreen .chat-widget-footer {
            flex: 0 0 auto;
        }

        .chat-widget-fullscreen .chat-widget-body {
            flex: 1 1 auto;
            overflow-y: auto;
        }
    </style>
</head>

<body class='snippet-body'>

    {{-- BotMan --}}
    <script>
        var botmanWidget = {
            aboutText: 'Write Something',
            introMessage: "✋ Hi! Welcome",
            title: 'EKAPTA ChatBot',
            mainColor: '#9a6e1b',
            bubbleBackground: '#9a6e1b',
            bubbleAvatarUrl: '{{ asset('images/mix-bot.png') }}',
            desktopWidth: '96%',
            mobileHeight: '100%',
            mobileWidth: '100%',
            fullScreen: true,
        };

        document.addEventListener('DOMContentLoaded', function () {
            window.botmanWidget.open();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
</body>

</html>
