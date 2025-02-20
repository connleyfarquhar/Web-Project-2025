document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    const aboutHeading = document.querySelector('.about-heading h1');
    const aboutContentHeadings = document.querySelectorAll('.about-content h2');
    const aboutContentParagraphs = document.querySelectorAll('.about-content p');
    const interstellaHeading = document.querySelector('.interstella-heading h1'); 
    const merchContentElements = document.querySelectorAll('.merch-content'); 

    themeToggle.style.color = '#ffffff';

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000); // Convert days to milliseconds
        document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/`;
    }

    function getCookie(name) {
        const cookies = document.cookie.split('; ');
        for (const cookie of cookies) {
            const [key, value] = cookie.split('=');
            if (key === name) return value;
        }
        return null;
    }

    const currentTheme = getCookie('theme');
    if (currentTheme === 'dark') {
        applyTheme(true);
    } else {
        applyTheme(false);
    }

    themeToggle.addEventListener('click', () => {
        const isDarkMode = document.body.style.backgroundColor === 'rgb(26, 26, 26)';
        applyTheme(!isDarkMode);
        setCookie('theme', isDarkMode ? 'light' : 'dark', 365); // Save theme as a cookie in browser for 1 Year.
    });

    function applyTheme(isDark) {
        if (isDark) {
            document.body.style.backgroundColor = '#1a1a1a';
            document.body.style.color = '#ffffff';

            if (aboutHeading) {
                aboutHeading.style.color = '#ffffff';
            }

            aboutContentHeadings.forEach(h2 => {
                h2.style.color = '#ffffff';
            });

            aboutContentParagraphs.forEach(p => {
                p.style.color = '#cccccc'; 
            });

            if (interstellaHeading) {
                interstellaHeading.style.color = '#ffffff'; 
            }

            merchContentElements.forEach(element => {
                element.style.color = '#ffffff'; 
            });

            updateButtonText(true);
        } else {
            document.body.style.backgroundColor = '';
            document.body.style.color = '';

            if (aboutHeading) {
                aboutHeading.style.color = '';
            }

            aboutContentHeadings.forEach(h2 => {
                h2.style.color = '';
            });

            aboutContentParagraphs.forEach(p => {
                p.style.color = ''; 
            });

            if (interstellaHeading) {
                interstellaHeading.style.color = ''; 
            }

            merchContentElements.forEach(element => {
                element.style.color = '#ffffff'; 
            });

            updateButtonText(false);
        }
    }

    function updateButtonText(isDark) {
        themeToggle.innerHTML = isDark ? 'Enable Light Mode' : 'Enable Dark Mode';
    }

document.querySelector('.collapsible').addEventListener('click', function () {
    var formContainer = document.querySelector('.form-container');
    
    if (formContainer.style.display === 'block') {
      formContainer.style.display = 'none';
    } else {
      formContainer.style.display = 'block';
    }
  });
  
});
