<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/tailwind.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/payment.css') }}" />

    <title>ShareSell</title>
  </head>
  <body>
    <header>
      <nav
        class="
          flex
          justify-between
          items-center
          bg-white
          px-40
          py-6
          shadow-md
          md:px-4
        "
      >
        <div>
          <img src="{{ asset('payments/logo.png') }}" alt="Logo" />
        </div>
        <div>
          <button type="button" class="requestButton">Request Support</button>
        </div>
      </nav>
    </header>
    @yield('content')

    <footer class="flex justify-center py-6">
      <p>©Copyright, ShareSell. 2020, <span>Terms & Conditions</span></p>
    </footer>
  </body>
</html>
