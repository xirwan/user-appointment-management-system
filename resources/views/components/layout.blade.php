<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }} </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
        }

        body{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        }

        a{
        text-decoration: none;
        }

        .wrapper{
        position: relative;
        max-width: 430px;
        width: 100%;
        background: #fff;
        padding: 34px;
        border-radius: 6px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }

        .wrapper h2{
        position: relative;
        font-size: 22px;
        font-weight: 600;
        color: #333;
        }

        .wrapper h2::before{
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 25px;
        border-radius: 12px;
        background: #4070f4;
        }

        .wrapper form{
        margin-top: 30px;
        }

        .wrapper form .input-box{
        height: 52px;
        margin: 10px 0;
        }
        
        form .input-box input{
        height: 100%;
        width: 100%;
        outline: none;
        padding: 0 15px;
        font-size: 17px;
        font-weight: 400;
        color: #333;
        border: 1.5px solid #C7BEBE;
        border-bottom-width: 2.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
        }

        .input-box input:focus,
        .input-box input:valid{
        border-color: #4070f4;
        }

        form h3{
        color: #707070;
        font-size: 14px;
        font-weight: 500;
        margin-left: 10px;
        }

        .input-box.button input{
        color: #fff;
        letter-spacing: 1px;
        border: none;
        background: #4070f4;
        cursor: pointer;
        }

        .input-box.button input:hover{
        background: #0e4bf1;
        }

        form .text h3{
        color: #333;
        width: 100%;
        text-align: center;
        margin: 0px;
        }

        form .text h3 a{
        color: #4070f4;
        text-decoration: none;
        }
        
        form .text h3 a:hover{
        text-decoration: underline;
        }

        form label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        form .input-box select {
            height: 100%;
            width: 100%;
            outline: none;
            padding: 0 15px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            border: 1.5px solid #C7BEBE;
            border-bottom-width: 2.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
            background: #fff;
            appearance: none;
        }

        form .input-box select:focus {
            border-color: #4070f4;
        }

        .custom-select-wrapper {
            position: relative;
            user-select: none;
            width: 100%;
        }

        .custom-select {
            position: relative;
            display: flex;
            flex-direction: column;
            border: 1.5px solid #C7BEBE;
            border-bottom-width: 2.5px;
            border-radius: 6px;
        }

        .custom-select-trigger {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            height: 52px;
            cursor: pointer;
        }

        .arrow {
            position: relative;
            height: 10px;
            width: 10px;
            border-left: 2px solid #333;
            border-bottom: 2px solid #333;
            transform: rotate(-45deg);
            transition: 0.3s;
        }

        .custom-select.open .arrow {
            transform: rotate(135deg);
        }

        .custom-options {
            position: absolute;
            top: 110%; /* Muncul di bawah trigger */
            left: 0;
            right: 0;
            background: #fff;
            border: 1.5px solid #C7BEBE;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            z-index: 10;
            transition: all 0.3s;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            max-height: 200px; /* <--- KUNCI UTAMA: Batasi tinggi */
            overflow-y: auto;  /* <--- KUNCI UTAMA: Tambahkan scroll */
        }

        .custom-select.open .custom-options {
            opacity: 1;
            visibility: visible;
            pointer-events: all;
        }

        .custom-option {
            position: relative;
            display: block;
            padding: 0 15px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            line-height: 40px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-option:hover {
            background-color: #f2f2f2;
        }
        
        .error-message {
            color: red;
        }

    </style>
</head>
<body>
    <main>
        {{ $slot }}
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.querySelector('.custom-select-wrapper');
            const select = wrapper.querySelector('select');
            const customSelect = wrapper.querySelector('.custom-select');
            const trigger = customSelect.querySelector('.custom-select-trigger span');
            const options = customSelect.querySelectorAll('.custom-option');

            customSelect.querySelector('.custom-select-trigger').addEventListener('click', function () {
                customSelect.classList.toggle('open');
            });

            options.forEach(option => {
                option.addEventListener('click', function () {

                    trigger.textContent = this.textContent;
                    
                    select.value = this.getAttribute('data-value');
                    
                    customSelect.classList.remove('open');
                });
            });

            window.addEventListener('click', function (e) {
                if (!customSelect.contains(e.target)) {
                    customSelect.classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>