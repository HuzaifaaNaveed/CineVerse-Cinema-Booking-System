
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #111;
        }

        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('assets/images/background2.jpg'); 
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 2.0s ease-out;
        }

        .logo-container {
            text-align: center;
        }

        .logo {
            width: 200px; 
            animation: fadeIn 3s ease-in-out; 
        }

        #loading-text {
            font-size: 40px;
            font-weight: bold;
            color: #f8f8f8;
            text-transform: uppercase;
            letter-spacing: 5px;
            text-align: center;
            animation: fadeIn 2s ease-in-out infinite alternate;
        }

        .circle {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            animation: pulse 3s infinite ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .content {
            display: none;
        }

        body.loaded .loading-screen {
            opacity: 1;
            pointer-events: none;
        }

        body.loaded .content {
            display: block;
        }
    </style>
</head>
<body>
    <div class="loading-screen">
        <div class="logo-container">
            <img src="assets/images/logo4.png" alt="Logo" class="logo">
        </div>
        <div class="circle"></div>
    </div>


    <script>
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });

        setTimeout(function() {
            window.location.href = 'index.php';  
        }, 3000);
    </script>
</body>
</html>
