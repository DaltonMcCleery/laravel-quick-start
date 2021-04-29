<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title')</title>
    <style type="text/css">
        /* Base */
        body, body *:not(html):not(style):not(br):not(tr):not(code) {
            font-family: 'work-sans-medium', Helvetica, Arial, sans-serif;
            box-sizing: border-box;
        }
        body {
            background: whitesmoke;
            color: #474748;
            height: 100%;
            hyphens: auto;
            line-height: 1.4;
            margin: 0;
            -moz-hyphens: auto;
            -ms-word-break: break-all;
            width: 100% !important;
            -webkit-hyphens: auto;
            -webkit-text-size-adjust: none;
            word-break: break-all;
            word-break: break-word;
        }

        /* Typography */
        h1 {
            color: #1A428A;
            font-size: 24px;
            font-weight: 900;
            margin-top: 0;
            text-align: center;
            line-height: 48px;
            letter-spacing: 0;
            text-transform: uppercase;
        }
        h2 {
            color: #1A428A;
            font-size: 20px;
            font-weight: 700;
            margin-top: 0;
            text-align: left;
            line-height: 48px;
            letter-spacing: 0;
            text-transform: uppercase;
        }
        p {
            color: #212121;
            font-size: 18px;
            line-height: 1.5em;
            margin-top: 0;
            text-align: left;
            font-weight: normal;
            letter-spacing: 0;

        }
        img {
            max-width: 550px;
        }
        a {
            color: #1A428A;
            font-family: inherit;
            font-weight: 600;
            font-size: inherit;
            line-height: inherit;
            letter-spacing: inherit;
            text-decoration: none;
        }

        /* Layout */
        .wrapper {
            background: whitesmoke;
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }
        .content {
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        /* Header */
        .header {
            padding: 25px 0;
            text-align: center;
            background: #2a2a2a;
        }
        .header a {
            color: #bbbfc3;
            font-size: 19px;
            font-weight: bold;
            text-decoration: none;
            text-shadow: 0 1px 0 white;
        }

        /* Body */
        .body {
            background-color: #fff;
            border-bottom: 1px solid #D6D6D7;
            border-top: 1px solid #D6D6D7;
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }
        .inner-body {
            background-color: #fff;
            margin: 0 auto;
            padding: 0;
            width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 570px;
        }
        ul {
            padding: 0;
            list-style: none;
        }

        /* Subcopy */
        .subcopy {
            border-top: 1px solid #EDEFF2;
            margin-top: 25px;
            padding-top: 25px;
        }

        /* Footer */
        .footer {
            margin: 0 auto;
            padding: 0;
            text-align: center;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            background: #2a2a2a;
        }
        .footer h2 {
            text-align: center;
            color: white;
            margin-bottom: 0;
        }

        /* Tables */
        .table table {
            margin: 30px auto;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }
        .table th {
            border-bottom: 1px solid #b7b7b8;
            padding-bottom: 8px;
            margin: 0;
        }
        .table td {
            color: #474748;
            font-size: 15px;
            line-height: 18px;
            padding: 10px 0;
            margin: 0;
        }
        .content-cell {
            padding: 35px;
        }

        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }
            .footer {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="header">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.svg') }}" alt="Logo" style="max-width: 150px"/>
                        </a>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    <table class="subcopy" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            @yield('body')
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table class="footer" align="center" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-cell" align="center">
                                    <h2>&copy; {{ date('Y') }} {{ config('app.name') }}</h2>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
