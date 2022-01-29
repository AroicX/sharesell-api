<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sharesell</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            Margin: 0;
            padding: 0;
            background-color: #f6f9fc;
        }

        table {
            border-spacing: 0;
        }

        td {
            padding: 0;
        }

        img {
            border: 0
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f6f9fc;
            padding-top: 3em;
            padding-bottom: 3em;
        }

        .inner_wrapper {
            max-width: 600px;
            min-height: 85vh;
            background: #FFFFFF;
        }

        .outer {
            Margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            font-family: 'PT Sans', sans-serif;
            color: #6f6f6f;
        }

        @media screen and (max-width: 600px) {}

        @media screen and (max-width: 400px) {}

    </style>
</head>
<body>
    <center class="wrapper">
        <div class="inner_wrapper">
            <table class="outer" align="center">
                <tr>
                    <td>
                        <table width="100%" style="border-spacing: 0;">
                            <tr>
                                <td style="padding-top: 10px;text-align: center;">
                                    <img height="110" alt="Sharesell  Logo" src="{{ $message->embed(public_path() . '/images/sharesell-logo.svg') }}" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px;">
                        <table style="border-spacing: 0;">
                            <tr>
                                <td>
                                    <p>Hello ,</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin-bottom: 2px;text-align: justify;">Welcome to Sharesell Africa, a platform that enable you connect with your customers easily from the comfort of your home.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin-bottom: 2px;text-align: justify;">Welcome to Sharesell Africa, a platform that enable you connect with your customers easily from the comfort of your home.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin-bottom: 2px;text-align: justify;">Welcome to Sharesell Africa, a platform that enable you connect with your customers easily from the comfort of your home.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="text-align: justify;">Thank you!!!</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>
</html>
