<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Invalid Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: all 0.3s ease;
        }

        .error-container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            width: 400px;
            transition: all 0.3s ease;
        }

        .error-container .icon {
            font-size: 100px;
            color: #e74c3c;
            transition: all 0.3s ease;
        }

        .error-container h1 {
            font-size: 24px;
            margin: 20px 0;
            color: #333;
            transition: all 0.3s ease;
        }

        .error-container p {
            color: #777;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .error-container a {
            display: inline-block;
            /* padding: 10px 20px; */
            color: white;
            /* background: #e74c3c; */
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            color: red;
        }

        .error-container .goback {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background: #e74c3c;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .error-container a:hover {
            background: #c0392b;
        }

        .error-container ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
            color: #777;
        }

        .error-container ul li {
            margin: 10px 0;
            transition: all 0.3s ease;
        }

        .error-container ul li i {
            color: #e74c3c;
            margin-right: 10px;
        }

        @media (max-width: 480px) {
            .error-container {
                padding: 20px;
                width: 350px;
            }

            .error-container .icon {
                font-size: 80px;
            }

            .error-container h1 {
                font-size: 20px;
            }
        }

        @media (max-width: 390px) {
            .error-container {
                width: 350px;
                scale: .9;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <i class="fas fa-exclamation-triangle icon"></i>
        <h1>Oops! Something went wrong</h1>
        <ul>
            <li><i class="fas fa-check-circle"></i> Recheck the form details you have entered.</li>
            <li><i class="fas fa-check-circle"></i> <a target="_blank" href="https://www.youtube.com/watch?v=T9oAWAxJ03A">Clear your browser history and cookies</a>.</li>
            <li><i class="fas fa-check-circle"></i> <a target="_blank" href="https://www.youtube.com/watch?v=auO4Gltouyk">Check if JavaScript Enabled</a>.</li>
            <li><i class="fas fa-check-circle"></i> If the issue persists, <a href="contact_us.html">contact us</a>.</li>
        </ul><br>
        <a class="goback" href="./data_officer_registration.php">Go Back</a>
    </div>
</body>

</html>