
        $(document).ready(function () {
            console.log("jQuery is loaded");

            if ($('#darkModeToggle').length) {
                console.log("darkModeToggle element exists");

                $('#darkModeToggle').on('click', function () {
                    console.log("darkModeToggle clicked");
                    $('body').toggleClass('dark-mode');
                    console.log("dark-mode class toggled");
                });
            } else {
                console.log("darkModeToggle element does not exist");
            }
        });