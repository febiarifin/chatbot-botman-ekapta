<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>ChatBot Ekapta</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="shortcut icon" href="{{ asset('images/mix-bot.png') }}" type="image/x-icon">
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        body {
            background: #eee;
            font-family: 'Quicksand', sans-serif;
        }

        #regForm {
            background-color: #ffffff;
            margin: 0px auto;
            padding: 40px;
            border-radius: 10px
        }

        #register {
            color: #9a6e1b;
        }

        h1 {
            text-align: center
        }

        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            border: 1px solid #aaaaaa;
            border-radius: 10px;
            -webkit-appearance: none;
        }

        textarea {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            border: 1px solid #aaaaaa;
            border-radius: 10px;
            -webkit-appearance: none;
        }

        .tab input:focus {
            border: 1px solid #9a6e1b !important;
            outline: none;
        }

        input.invalid {

            border: 1px solid #e03a0666;
        }

        button {
            background-color: #9a6e1b;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer
        }

        button:hover {
            opacity: 0.8
        }

        button:focus {
            outline: none !important;
        }

        .typing::after {
            color: #9a6e1b;
            content: '|';
            animation: blink-caret 0.75s step-end infinite;
        }

        @keyframes blink-caret {
            from, to {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }
    </style>
</head>

<body className='snippet-body'>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-8">
                <form id="regForm" action="{{ route('questions.store.contribution') }}" method="post">
                    @csrf
                    <div class="mb-3 text-center">
                        <h3 class="typing" id="welcome-text" style="color: #9a6e1b;"></h3>
                    </div>
                    <p class="text-muted text-center">Ayo! Berkontribusi dengan mengirimkan pertanyaan kamu seputar
                        EKAPTA ataupun
                        topik lainnya.</p>

                    <div class="mb-2">
                        <h6>Nama / Email</h6>
                        <input type="text" name="user_info" placeholder="Isi nama atau email kamu..." required>
                    </div>
                    <div class="mb-2">
                        <h6>Pertanyaan</h6>
                        <textarea name="question_text" placeholder="Isi pertanyaan kamu..." required></textarea>
                    </div>
                    <div style="overflow:auto;">
                        <div style="float:left;">
                            <button type="submit" class="rounded-pill"><i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        &copy {{ now()->year }} <a href="https://ekapta.fastikom-unsiq.ac.id/"
                            target="_blank">EKAPTA</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>
    </script>
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
        document.addEventListener('DOMContentLoaded', function() {
            const text = "Welcome to ChatBot Ekapta ✋";
            let i = 0;
            const speed = 100;
            let typingInterval;

            function typeWriter() {
                if (i < text.length) {
                    document.getElementById("welcome-text").textContent += text.charAt(i);
                    i++;
                    typingInterval = setTimeout(typeWriter, speed);
                } else {
                    setTimeout(function () {
                        document.getElementById("welcome-text").textContent = '';
                        i = 0;
                        typeWriter();
                    }, 2000); // Adjust the delay before resetting the text
                }
            }

            typeWriter();
        });
    </script>
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>

</html>
