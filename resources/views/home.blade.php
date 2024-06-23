<!DOCTYPE html>
<html>
<head>
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">
    <link rel="shortcut icon" href="{{ asset('images/mix-bot.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Quicksand', sans-serif;
        }
        .bg-gradient {
            background: linear-gradient(45deg, #ffa600, #ff9900);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .typing {
            border-right: .15em solid #ffffff;
            white-space: nowrap;
            overflow: hidden;
            animation: typing 3.5s steps(30, end), blink-caret .75s step-end infinite;
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: #ffffff; }
        }
    </style>
</head>
<body>
    <div class="bg-gradient">
        <h2 class="typing text-white" id="welcome-text"></h2>

        <div class="card shadow mt-4 col-md-6">
            <div class="card-header">
                <h3 class="text-secondary">Tulis Pertanyaan Kamu</h3>
                <span class="text-muted">Ayo berkontribusi dengan mengirimkan pertanyaan kamu seputar EKAPTA ataupun topik lainnya!</span>
            </div>
            <div class="card-body">
                <form action="{{ route('questions.store.contribution') }}" method="post">
                    @csrf
                    <div class="mb-3 text-left">
                        <label>Nama/Email</label>
                        <input type="text" class="form-control" placeholder="Isi nama/email kamu..." name="user_info" required>
                    </div>
                    <div class="mb-3 text-left">
                        <label>Pertanyaan</label>
                        <textarea name="question_text" class="form-control" placeholder="Isi pertanyaan kamu..." required></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm mb-3">KIRIM <i class="fas fa-paper-plane"></i></button>
                </form>
                <span class="text-center">&copy {{ now()->year }} <a href="https://ekapta.fastikom-unsiq.ac.id/" target="_blank">EKAPTA</a></span>
            </div>
        </div>
    </div>

    {{-- BotMan --}}
    <script>
        var botmanWidget = {
            aboutText: 'Write Something',
            introMessage: "✋ Hi! Welcome",
            title: 'EKAPTA ChatBot',
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const text = "Welcome to ChatBot EKAPTA✋";
            let i = 0;
            const speed = 100;
            function typeWriter() {
                if (i < text.length) {
                    document.getElementById("welcome-text").textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, speed);
                }
            }
            typeWriter();
            setInterval(function() {
                i = 0;
                document.getElementById("welcome-text").textContent = '';
                typeWriter();
            }, 8000);
        });
    </script>
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>
</html>
