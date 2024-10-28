<!doctype html>
<html lang="en"  >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Ecommerce</title>
</head>
<body class="
      p-8
      antialiased

      from-pink-300
      via-purple-300
      to-indigo-400
    ">

@include('guest.components.navbar')

@yield('content')


<script !src="">
    const button = document.querySelector('#menu-button');
    const menu = document.querySelector('#menu');


    button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    function isDarkMode() {
        return document.documentElement.classList.contains('dark');
    }

    function toggleDarkMode() {
        // Toggle dark mode
        document.documentElement.classList.toggle('dark');

        // Update data-theme attribute on html element
        document.documentElement.dataset.theme = isDarkMode ? 'dark' : 'light';

        // Update button icon based on dark mode state (optional)
        const darkModeButton = document.getElementById('dark-mode-toggle');
        // const darkModeIcon = darkModeButton.querySelector('svg:nth-of-type(1)');
        // const lightModeIcon = darkModeButton.querySelector('svg:nth-of-type(2)');

        // if (isDarkMode()) {
        //     darkModeIcon.style.display = 'none';
        //     lightModeIcon.style.display = 'block';
        // } else {
        //     darkModeIcon.style.display = 'block';
        //     lightModeIcon.style.display = 'none';
        // }
    }

</script>
</body>
</html>
